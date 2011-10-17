<?php
namespace Onside;
use \PDO;

abstract class Db extends PDO
{
    protected function prepared($sql, array $args = array())
    {
        $stmt = $this->prepare($sql);
        try {
            $stmt->execute($args);
        } catch (PDOException $e) {
            // TODO: return error object
        }
        return $stmt;
    }
}
