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
    
    protected function _addItem($data)
    {
        $class = $this->_model;
        $model = $class::getModelFromArray($data);
        $sql = $model->getInsertSQL();
        $args = $model->getValues();
        
        return $this->_db->prepared($sql, $args);
    }
    
    protected function _updateItem($id, $data)
    {
        $data['id'] = $id;
        $class = $this->_model;
        $model = $class::getModelFromArray($data);
        $sql = $model->getUpdateSQL();
        $args = $model->getValues();

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
        $class = $this->_model;
        $model = $class::getModelFromArray(array());

        // TODO: where clause
//        $model->setWhere(array('id' => 30));
        
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
