<?php
namespace Onside;
use \PDO;

class Db extends PDO
{
    public function prepared($sql, array $args = array())
    {
//echo '$sql: ' . $sql . "\n";
//echo '$args: ' . print_r($args, true) . "\n";
        try {
            $stmt = $this->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            $i = 1;
            // can't use execute($args) because of apparent PHP bug — 'invalid syntax for booelan ""'
            foreach($args as $value) {
                assert('is_scalar($value) || NULL === $value');
                $stmt->bindValue($i++, $value, is_string($value) ? PDO::PARAM_STR : (is_int($value) ? PDO::PARAM_INT : (null === $value ? PDO::PARAM_NULL : PDO::PARAM_BOOL)));
            }
            
            $r = $stmt->execute();
//echo '$r: ' . ($r ? 'TRUE' : 'FALSE') . "\n";
            if ($this->_isNonModifyingQuery($sql))
                return $stmt;
        } catch (PDOException $e) {
            // TODO: return error object
            throw $e;
//echo print_r($e->getTraceAsString(), true) . "\n";
        }
//echo 'lastInsertId(): ' . $this->lastInsertId() . "\n";
//echo 'rowCount(): ' . $stmt->rowCount() . "\n";
        return $this->lastInsertId() > 0 ? $this->lastInsertId() : $stmt->rowCount();
    }
    
    private function _isNonModifyingQuery($sql)
    {
        return !preg_match('/^\s*(?:INSERT|DELETE|UPDATE|BEGIN|ALTER|CREATE)\s/i', $sql);
    }
}
