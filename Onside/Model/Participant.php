<?php
namespace Onside\Model;
use \Onside\Model;

class Participant extends Model
{
    protected $_table = 'participant';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100) NOT NULL',
	'position' => 'VARCHAR(50) NULL',
	'score' => 'VARCHAR(50) NULL',
	'points' => 'VARCHAR(50) NULL',
    );
    
    public $id;
    public $name;
    public $position;
    public $score;
    public $points;
}
