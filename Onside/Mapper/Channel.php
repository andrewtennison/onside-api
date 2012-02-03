<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Channel extends Mapper
{
    protected $_table = 'channel';
    protected $_model = '\Onside\Model\Channel';
    
    public function te()
    {
	throw new \Exception('default exception', 99999);
    }
    
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
    
    public function removeFollower($channel, $user)
    {
	$model = \Onside\Model\Follower::getModelFromArray(array());
	$model->setWhere('channel', $channel);
	$model->setWhere('user', $user);
	
	$sql = $model->getSelectSQL();
	$args = $model->getValues();
	
	$row = $this->_db->prepared($sql, $args)->fetch();
	// Perform delete
	if (is_array($row) && array_key_exists('id', $row)) {
	    $model = \Onside\Model\Follower::getModelFromArray($row);
	    $sql = $model->getDeleteSQL();
	    $args = $model->getValues();
	    $this->_db->prepared($sql, $args);
	    return array('status' => 'user no longer following channel');
	}
	return array('status' => 'user not following channel');
    }
    
    public function addChannel($channel1, $channel2)
    {
	// force no dupes
	$channels = array($channel1, $channel2);
	sort($channels);
	$channel1 = $channels[0];
	$channel2 = $channels[1];
	
	$model = \Onside\Model\Cchannel::getModelFromArray(array('channel1' => $channel1, 'channel2' => $channel2));

	$sql = $model->getInsertSQL();
        $args = $model->getValues();

        $id = $this->_db->prepared($sql, $args);
	// TODO: feed back success using http code
	return $id == 0 ? array('status' => 'channel already associated with channel') : array('status' => 'channel now associated with channel');
    }
    
    public function removeChannel($channel1, $channel2)
    {
	// force no dupes
	$channels = array($channel1, $channel2);
	sort($channels);
	$channel1 = $channels[0];
	$channel2 = $channels[1];
	
	$model = \Onside\Model\Cchannel::getModelFromArray(array());
	$model->setWhere('channel1', $channel1);
	$model->setWhere('channel2', $channel2);
	
	$sql = $model->getSelectSQL();
	$args = $model->getValues();
	
	$row = $this->_db->prepared($sql, $args)->fetch();
	// Perform delete
	if (is_array($row) && array_key_exists('id', $row)) {
	    $model = \Onside\Model\Cchannel::getModelFromArray($row);
	    $sql = $model->getDeleteSQL();
	    $args = $model->getValues();
	    $this->_db->prepared($sql, $args);
	    return array('status' => 'channel no longer associated with channel');
	}
	return array('status' => 'channel not associated with channel');
    }
    
    public function searchItem($get = array(), $sort = array(), $limit = null)
    {
	$where = array(
	    'sport' => array('=', $get['q'], 'OR'),
	    'type' => array('=', $get['q'], 'OR'),
	    'name' => array('LIKE', "%{$get['q']}%", 'OR'),
	    'keywords' => array('LIKE', "%{$get['q']}%", 'OR'),
	);
	return $this->_selectItem($where, $sort, $limit, array());
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
	
	if (array_key_exists('event', $where)) {
	    $join[] = array(
		'table' => 'cevent',
		'leftfield' => 'id',
		'rightfield' => 'channel',
		'type' => 'JOIN',
		'fields' => array(),
		'wherefield' => 'event',
		'wherevalue' => $where['event'],
	    );
	    unset($where['event']);
	}
	
	if (array_key_exists('channel', $where)) {
	    $join[] = array(
		'table' => 'cchannel',
		'leftfield' => array('id', 'id'),
		'rightfield' => array('channel1', 'channel2'),
		'type' => 'JOIN',
		'fields' => array(),
		'wherefield' => array(),
		'wherevalue' => $where['channel'],
	    );
	    unset($where['channel']);
	}
	
        return $this->_selectItem($where, $sort, $limit, $join);
    }
}
