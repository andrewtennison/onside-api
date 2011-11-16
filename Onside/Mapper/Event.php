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
	    'sport' => $get['q'],
	    'type' => $get['q'],
	    'name' => array('LIKE', "%{$get['q']}%"),
	    'keywords' => array('LIKE', "%{$get['q']}%"),
	);
//echo print_r($where, true);
	return $this->_selectItem($where, array(), null);
    }
}
