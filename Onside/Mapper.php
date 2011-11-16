<?php
namespace Onside;

class Mapper
{
    protected $_db;
    protected $_model;
    
    public function __construct(Db $db)
    {
        assert('null !== $db');
        $this->_db = $db;
    }
    
    public function addItem(array $data)
    {
        return $this->_addItem($data);
    }
    
    public function updateItem($id, array $data)
    {
        return $this->_updateItem((int) $id, $data);
    }
    
    public function deleteItem($id)
    {
        return $this->_deleteItem((int) $id);
    }
    
    public function selectItem($where = array(), $sort = array(), $limit = null)
    {
        return $this->_selectItem($where, $sort, $limit);
    }
    
    public function getItem($id)
    {
        return $this->_selectItem(array('id' => $id), array(), null);
    }
    
    // TODO: ->getItem($id) ->selectItem() ..... etc ....
    
    protected function _addItem($data)
    {
        $class = $this->_model;
        $model = $class::getModelFromArray($data);
        $sql = $model->getInsertSQL();
        $args = $model->getValues();
        
        $id = $this->_db->prepared($sql, $args);
        return $this->_selectItem(array('id' => $id), null, null);
        
        return $this->_db->prepared($sql, $args);
    }
    
    protected function _updateItem($id, $data)
    {
        $data['id'] = $id;
        $class = $this->_model;
        $model = $class::getModelFromArray($data);
        $sql = $model->getUpdateSQL();
        $args = $model->getValues();

        $this->_db->prepared($sql, $args);
        return $this->_selectItem(array('id' => $id), null, null);
        
        return $this->_db->prepared($sql, $args);
    }
    
    protected function _deleteItem($id)
    {
        $class = $this->_model;
        $model = $class::getModelFromArray(array('id' => $id));
        $sql = $model->getDeleteSQL();
        $args = $model->getValues();

        return $this->_db->prepared($sql, $args);
    }
    
    protected function _selectItem($where, $sort, $limit)
    {
//echo '$where: ' . print_r($where, true) . ', $sort: ' . print_r($sort, true) . ', $limit: ' . print_r($limit, true) . "\n";
        $class = $this->_model;
        $model = $class::getModelFromArray(array());

        // TODO: where clause
        // $leftside, $rightside, $operator = '=', $type = 'AND'
//        $model->setWhere(array('id' => 30));
        if (count($where) > 0) {
            foreach ($where as $field => $value) {
		if (is_array($value)) {
		    $model->setWhere($field, $value[1], $value[0], 'OR');
		} else {
		    $model->setWhere($field, $value, '=', 'OR');
		}
            }
        }
        
        // sort order
        if (count($sort) > 0) {
            foreach ($sort as $field => $order)
                $model->setSort($field, $order);
        }
        
        // limit
        if (null !== $limit) {
            if (is_array($limit)) {
                if (count($limit) == 1) {
                    $model->setLimit($limit[0]);
                } else {
                    $model->setLimit($limit[0], $limit[1]);
                }
            } else if (is_numeric($limit)) {
                $model->setLimit($limit);
            }
        }
        $sql = $model->getSelectSQL();
        $args = $model->getValues();
//echo '$sql: ' . $sql . "\n";
//echo '$args: ' . print_r($args, true) . "\n";
        return $this->_db->prepared($sql, $args)->fetchAll(\PDO::FETCH_CLASS, $this->_model);
    }
}
