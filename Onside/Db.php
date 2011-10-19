<?php
namespace Onside;
use \PDO;

class Db extends PDO
{
    public function prepared($sql, array $args = array())
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
