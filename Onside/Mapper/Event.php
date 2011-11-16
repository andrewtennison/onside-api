<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Event extends Mapper
{
    protected $_table = 'event';
    protected $_model = '\Onside\Model\Event';
    
    public function searchItem($get = array())
    {
	$where = array(
	    'sport' => array('=', $get['q'], 'OR'),
	    'type' => array('=', $get['q'], 'OR'),
	    'name' => array('LIKE', "%{$get['q']}%", 'OR'),
	    'keywords' => array('LIKE', "%{$get['q']}%", 'OR'),
	);
	return $this->_selectItem($where, array(), null);
    }
}
