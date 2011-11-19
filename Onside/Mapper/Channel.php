<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Channel extends Mapper
{
    protected $_table = 'channel';
    protected $_model = '\Onside\Model\Channel';
    
    public function addFollower($channel, $user)
    {
	// TODO: check for existance first
	$model = \Onside\Model\Follower::getModelFromArray(array('channel' => $channel, 'user' => $user));
	$sql = $model->getInsertSQL();
        $args = $model->getValues();

        $id = $this->_db->prepared($sql, $args);
	// TODO: feed back success using http code
	return $id == 0 ? array('status' => 'user already following channel') : array('status' => 'user now following channel');
    }
    
    public function searchItem($get = array())
    {
	$where = array(
	    'sport' => array('=', $get['q'], 'OR'),
	    'type' => array('=', $get['q'], 'OR'),
	    'name' => array('LIKE', "%{$get['q']}%", 'OR'),
	    'keywords' => array('LIKE', "%{$get['q']}%", 'OR'),
	);
	return $this->_selectItem($where, array(), null, array());
    }
    
    public function selectItem($where = array(), $sort = array(), $limit = null, $join = array())
    {
	if (array_key_exists('user', $where)) {
	    $join[] = array(
		'table' => 'follower',
		'leftfield' => 'id',
		'rightfield' => 'channel',
		'type' => 'JOIN',
		'fields' => array(),
		'wherefield' => 'user',
		'wherevalue' => $where['user'],
	    );
//	    $where['t0.user'] = $where['user'];
	    unset($where['user']);
//echo 'NEEDS JOIN DEFINITION' . "\n";
//exit;
	    // TODO: where clause adding ` round it which doesn't work for aliases
	}
        return $this->_selectItem($where, $sort, $limit, $join);
    }
}
