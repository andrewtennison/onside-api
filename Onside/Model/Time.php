<?php
namespace Onside\Model;
use \Onside\Model;

class Time extends Model
{
    protected $_table = 'time';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'start' => 'TIMESTAMP NULL',
	'finish' => 'TIMESTAMP NULL',
	'duration' => 'VARCHAR(50) NULL',
    );
    
    public $id;
    public $start;
    public $finish;
    public $duration;
}
