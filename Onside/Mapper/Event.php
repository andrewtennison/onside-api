<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class Event extends Mapper
{
    protected $_table = 'event';
    protected $_model = '\Onside\Model\Event';
    
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
    
    public function addChannel($channel, $event)
    {
	$model = \Onside\Model\Cevent::getModelFromArray(array('channel' => $channel, 'event' => $event));

	$sql = $model->getInsertSQL();
        $args = $model->getValues();

        $id = $this->_db->prepared($sql, $args);
	// TODO: feed back success using http code
	return $id == 0 ? array('status' => 'event already associated with channel') : array('status' => 'event now associated with channel');
    }
    
    public function removeChannel($channel, $event)
    {
	$model = \Onside\Model\Cevent::getModelFromArray(array());
	$model->setWhere('channel', $channel);
	$model->setWhere('event', $event);
	
	$sql = $model->getSelectSQL();
	$args = $model->getValues();
	
	$row = $this->_db->prepared($sql, $args)->fetch();
	// Perform delete
	if (is_array($row) && array_key_exists('id', $row)) {
	    $model = \Onside\Model\Cevent::getModelFromArray($row);
	    $sql = $model->getDeleteSQL();
	    $args = $model->getValues();
	    $this->_db->prepared($sql, $args);
	    return array('status' => 'event no longer associated with channel');
	}
	return array('status' => 'event not associated with channel');
    }
}
