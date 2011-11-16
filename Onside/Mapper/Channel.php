<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Channel extends Mapper
{
    protected $_table = 'channel';
    protected $_model = '\Onside\Model\Channel';
    
    public function searchItem($get = array())
    {
	$where = array(
	    'sport' => $get['q'],
	    'type' => $get['q'],
	    'name' => array('LIKE', "%{$get['q']}%"),
	    'keywords' => array('LIKE', "%{$get['q']}%"),
	);
	return $this->_selectItem($where, array(), null);
    }
}
