<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Article extends Mapper
{
    protected $_table = 'article';
    protected $_model = '\Onside\Model\Article';
    
    public function searchItem($get = array())
    {
	$where = array(
	    'title' => array('LIKE', "%{$get['q']}%"),
	    'keywords' => array('LIKE', "%{$get['q']}%"),
	);
//echo print_r($where, true);
	return $this->_selectItem($where, array(), null);
    }
}
