<?php
namespace Onside\Model;
use \Onside\Model;

class Event extends Model
{
    protected $_table = 'event';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
        'sport' => 'VARCHAR(50)',
        'type' => 'VARCHAR(50)',
        'geolat' => 'DECIMAL(10,6) default NULL',
        'geolng' => 'DECIMAL(10,6) default NULL',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
    public $sport;
    public $type;
    public $geolat;
    public $geolng;
//    public $added;
}
