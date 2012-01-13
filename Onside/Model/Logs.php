<?php
namespace Onside\Model;
use \Onside\Model;

class Logs extends Model
{
    protected $_table = 'logs';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
	'level' => "ENUM('info','warn','error','fatal') NOT NULL DEFAULT 'error'",
	'message' => 'TEXT NOT NULL',
    );
    
    public $id;
    public $added;
    public $level;
    public $message;
}
