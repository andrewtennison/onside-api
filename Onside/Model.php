<?php
namespace Onside;

class Model
{
    private $_fields;
    private $_values;
    private $_where;
    private $_sort;
    private $_limit;
    private $_join;

    protected $_schema;
    protected $_table;
    protected $_index = array();
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

    public function clearWhere() { $this->_where = array(); }
    public function clearJoin() { $this->_join = array(); }

    public function setJoin($table, $leftfield, $rightfield, $wherefield, $wherevalue, $fields = array(), $type = 'JOIN', $lefttable = null)
    {
	$this->_join[] = array(
	    'table' => $table,
	    'type' => $type,
	    'fields' => $fields,
	    'leftfield' => $leftfield,
	    'rightfield' => $rightfield,
	    'wherefield' => $wherefield,
	    'wherevalue' => $wherevalue,
	    'lefttable' => $lefttable
	);
    }

    public function setWhere($leftside, $rightside, $operator = '=', $type = 'AND')
    {
//echo "\$leftside: $leftside, \$rightside: $rightside, \$operator: $operator, \$type: $type\n";
//echo 'strpos(): ' . (false !== strpos($leftside, '`') ? 'TRUE' : 'FALSE') . "\n";
	// only wrap field value if its a string and is not a mysql funcation
	// so far on PASSWORD() function is trapped
	if (is_string($rightside) && strpos($rightside, 'PASSWORD') === false) {
	    $rightside = "'" . $this->_addSlashes($rightside) . "'";
	}
//	$this->_where[] = '`' . $leftside . '` ' . $operator . ' ' . $rightside . ' ' . $type . ' ';
        $this->_where[] = (false !== strpos($leftside, '`') ?
	    $leftside . $operator . ' ' . $rightside . ' ' . $type . ' ':
	    '`' . $leftside . '` ' . $operator . ' ' . $rightside . ' ' . $type . ' ');
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
	// TODO: list fields individually to allow
	// programatically joins
        $sql = 'SELECT t.* FROM ' . $this->_getTable(null, true);

	// joins
	if (count($this->_join) > 0) {
            $tableKeys = array();
	    foreach ($this->_join as $key => $join) {
//echo print_r($join, true) . "\n";
                $tableKeys[$join['table']] = $key;
		// only works for channel <-> channel relationship
		if (is_array($join['leftfield']) && is_array($join['rightfield']) && count($join['leftfield']) == count($join['rightfield'])) {
		    $on = '';
		    for($i = 0; $i < count($join['leftfield']); $i++) {
			$otherfield = $i ? $join['rightfield'][0] : $join['rightfield'][1];
			$on .= '(t.' . $join['leftfield'][$i] . ' = t' . $key . '.' . $join['rightfield'][$i] . ' AND t' . $key . '.' . $otherfield . ' = ' . $join['wherevalue'] . ') OR ';
		    }
		    $on = ' ON (' . substr($on, 0, -4) . ')';

                    $sql .= ' ' . $join['type'] . ' ' . $this->_getTable($join['table']) . ' t' . $key . $on;

		} else {
                    $leftTableExpr = 't';
                    if ($join['lefttable'] !== null) {
                        assert(array_key_exists($join['lefttable'], $tableKeys));
                        $leftTableExpr .= $tableKeys[$join['lefttable']];
                    }
		    // TODO: add select tables to sql
		    $sql .= ' ' . $join['type'] . ' ' . $this->_getTable($join['table']) . ' t' . $key . ' ON ' . $leftTableExpr . '.' . $join['leftfield'] . ' = t' . $key . '.' . $join['rightfield'];
		}

		if (is_array($join['wherefield'])) {
//		    foreach ($join['wherefield'] as $wherefield)
//			$this->setWhere('t' . $key . '.`' . $wherefield . '`', $join['wherevalue']);
		} else if ($join['wherefield'] !== null) {
		    $this->setWhere('t' . $key . '.`' . $join['wherefield'] . '`', $join['wherevalue']);
		}
	    }
	}

	// TODO: refactor to be more efficient
        if (count($this->_where) > 0) {
//echo 'WHERE: ' . print_r($this->_where, true) . "\n";
	    $parts = explode(' ', trim($this->_where[count($this->_where) - 1]));
            $sql .= ' WHERE t.' . substr(implode('t.', $this->_where), 0, -strlen($parts[count($parts) - 1]) - 1);
	    // TODO: such a hack :(
	    $sql = str_replace('t.t', 't', $sql);
        }

        // sort order
        if (is_array($this->_sort) && count($this->_sort) > 0) {
            $sql .= ' ORDER BY ' . implode(', ', $this->_sort);
        }

        // limit
        if (null !== $this->_limit && count($this->_limit) === 2)
            $sql .= ' LIMIT ' . $this->_limit[0] . ', ' . $this->_limit[1];
//file_put_contents('/tmp/oside', $sql);
//echo '$sql: ' . $sql . "\n";
//exit;
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
    {$this->_getIndexDefinition()}
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


    private function _addSlashes($sql)
    {
	return addslashes($sql);
    }

    private function _getIndexDefinition()
    {
	return implode(",\n", array_merge(array('PRIMARY KEY (`id`)'), $this->_index));
    }

    private function _validateField($field)
    {

        return true;
    }

    private function _getTable($table = null, $alias = false)
    {
	if (null === $table) $table = $this->_table;
        return ((null !== $this->_schema) ? "`{$this->_schema}`." : '') .
	    "`{$table}`" .
	    ($alias ? ' AS t' : '');
    }

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

        $filteredFields = array_filter($this->_fields, array($this, 'filterPasswordField'));

        return '`' . implode('`, `', $filteredFields) . '`';
    }

    private function filterPasswordField($field)
    {
        return $field !== 'password';
    }

    private function _getFieldListPlaceholders()
    {
        if (null === $this->_fields) $this->_setFields();
        $str = '';
        foreach ($this->_fields as $field) {
            if ($field === 'password') {
                if ($this->$field) {
                    $this->_values[] = $this->$field;
                    $str .= ', `' . $field . '` = PASSWORD(?)';
                }
            } else {
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

	$placeholders = '';
        foreach ($this->_fields as $field) {
	    if ($field === 'password') {
                if ($this->$field) {
                    $this->_values[] = $this->$field;
		    $placeholders .= ', PASSWORD(?)';
                }
	    } else {
                $this->_values[] = $this->$field;
		$placeholders .= ', ?';
	    }
	}
	$placeholders = substr($placeholders, 2);

	return $placeholders;
    }

    private function _setFields()
    {
        $fields = array();
        $refect = new \ReflectionClass($this);
	$defaults = $refect->getDefaultProperties();
        foreach ($refect->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflectp) {
            if ('id' !== $reflectp->name)
                $fields[] = $reflectp->name;
        }
        $this->_fields = $fields;
    }
}
