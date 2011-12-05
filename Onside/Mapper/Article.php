<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Article extends Mapper
{
    protected $_table = 'article';
    protected $_model = '\Onside\Model\Article';
    
    public function searchItem($get = array(), $sort = array(), $limit = null)
    {
	$where = array(
	    'title' => array('LIKE', "%{$get['q']}%", 'OR'),
	    'keywords' => array('LIKE', "%{$get['q']}%", 'OR'),
	);
	return $this->_selectItem($where, $sort, $limit, array());
    }
    
    
    public function selectItem($where = array(), $sort = array(), $limit = null, $join = array())
    {
	if (array_key_exists('channel', $where)) {
	    $join[] = array(
		'table' => 'carticle',
		'leftfield' => 'id',
		'rightfield' => 'article',
		'type' => 'JOIN',
		'fields' => array(),
		'wherefield' => 'channel',
		'wherevalue' => $where['channel'],
	    );
	    unset($where['channel']);
	}
	if (array_key_exists('event', $where)) {
//	    $join[] = array(
//		'table' => 'channel',
//		'leftfield' => 'id',
//		'rightfield' => 'channel',
//		'type' => 'JOIN',
//		'fields' => array(),
//		'wherefield' => 'user',
//		'wherevalue' => $where['user'],
//	    );
	    unset($where['event']);
	}
	
        return $this->_selectItem($where, $sort, $limit, $join);
    }
}
