<?php
namespace Onside;

class Model
{
    private $_fields;
    private $_values;
    private $_where;
    private $_sort;
    private $_limit;
    
    protected $_schema;
    protected $_table;
    protected $_definitions = array();
    
    final static public function getModelFromArray($data)
    {
        $class = get_called_class();
        $model = new $class();
        foreach ($data as $field => $value) {
            if (property_exists($model, $field)) {
                $model->$field = $value;
            }
        }
        return $model;
    }
    
    public function setWhere($where)
    {
        $this->_where = array();
        // TODO: define where clauses considering AND/OR
    }
    
    public function clearSort()
    {
        $this->_sort = array();
    }
    
    public function setSort($field, $ascend = true)
    {
        $this->_sort[] = $field . ' ' . ($ascend ? 'asc' : 'desc');
    }
    
    public function setLimit($limit, $offset = 0)
    {
        $this->_limit = array($offset, $limit);
    }

    public function getSelectSQL()
    {
        $this->_values = array();
        $sql = 'SELECT * FROM ' . $this->_getTable();
        //foreach ($where as $w)
        
        // sort order
        if (is_array($this->_sort) && count($this->_sort) > 0) {
            $sql .= ' ORDER BY ' . implode(', ', $this->_sort);
        }
        
        // limit
        if (null !== $this->_limit && count($this->_limit) === 2)
            $sql .= ' LIMIT ' . $this->_limit[0] . ', ' . $this->_limit[1];
        
        return $sql;
    }
    
    public function getInsertSQL()
    {
        $this->_values = array();
        return 'INSERT INTO ' . $this->_getTable() . ' (' . $this->_getFieldList() . ') VALUES (' . $this->_getFieldPlaceholders() . ')';
    }
    
    public function getUpdateSQL()
    {
        $this->_values = array();
        return 'UPDATE ' . $this->_getTable() . ' SET ' . $this->_getFieldListPlaceholders() . ' WHERE id = ?';
    }
    
    public function getDeleteSQL()
    {
        $this->_values = array($this->id);
        return 'DELETE FROM ' . $this->_getTable() . ' WHERE id = ?';
    }
    
    public function getDropSQL()
    {
        return 'DROP TABLE IF EXISTS ' . $this->_getTable();
    }
    
    public function getTruncateSQL()
    {
        return 'TRUNCATE TABLE ' . $this->_getTable();
    }
    
    public function getCreateSQL()
    {
        return <<<SQL
CREATE TABLE IF NOT EXISTS {$this->_getTable()} (
    {$this->_getFieldDefinitions()},
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 
SQL;
    }
    
    public function getValues()
    {
        return $this->_values;
    }
    
    public function validate()
    {
        if (null === $this->_fields) $this->_setFields();
        
        foreach ($this->_fields as $field) {
            if (!$this->_validateField($field))
                return false;
        }
        
        return true;
    }
    
    private function _validateField($field)
    {
        
        return true;
    }
    
    private function _getTable()
    {
        return ((null !== $this->_schema) ? "`{$this->_schema}`." : '') . "`{$this->_table}`";
    }
    /**
    private function _getFieldValues()
    {
        if (null === $this->_fields) $this->_setFields();
        $values = array();
        foreach ($this->_fields as $field) {
            if (null !== $this->$field)
                $values[] = $this->$field;
        }
        
        return $values;
    }
    
    private function _getFieldUpdateValues()
    {
        if (null === $this->_fields) $this->_setFields();
        
    }
    */
    private function _getFieldDefinitions()
    {
        if (null === $this->_fields) $this->_setFields();
        
        $str = '`id` ' . $this->_definitions['id'];
        foreach ($this->_fields as $field) {
            $str .= ', `' . $field . '` ' . $this->_definitions[$field];
        }
        return $str;
    }
    
    private function _getFieldList()
    {
        if (null === $this->_fields) $this->_setFields();
        
        return '`' . implode('`, `', $this->_fields) . '`';
    }
    
    private function _getFieldListPlaceholders()
    {
        if (null === $this->_fields) $this->_setFields();
        
        $str = '';
        foreach ($this->_fields as $field) {
            if (null !== $this->$field) {
                $this->_values[] = $this->$field;
                $str .= ', `' . $field . '` = ?';
            }
        }
        $this->_values[] = $this->id;
        
        return substr($str, 2);
    }
    
    private function _getFieldPlaceholders()
    {
        if (null === $this->_fields) $this->_setFields();
        
        foreach ($this->_fields as $field)
            $this->_values[] = $this->$field;
        return substr(str_repeat(', ?', count($this->_fields)), 2);
    }
    
    private function _setFields()
    {
        $fields = array();
        $refect = new \ReflectionClass($this);
        foreach ($refect->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflectp) {
            if ('id' !== $reflectp->name)
                $fields[] = $reflectp->name;
        }
        $this->_fields = $fields;
    }
}
