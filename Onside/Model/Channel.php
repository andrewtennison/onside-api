<?php
namespace Onside\Model;
use \Onside\Model;

class Channel extends Model
{
    protected $_table = 'channel';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
        'description' => 'TEXT',
        'sport' => 'VARCHAR(50)',
        'type' => 'VARCHAR(50)',
        'level' => 'INT(1) NOT NULL default 1',
        'geolat' => 'DECIMAL(10,6) default NULL',
        'geolng' => 'DECIMAL(10,6) default NULL',

//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
    public $description;
    public $sport;
    public $type;
    public $level;
    public $geolat;
    public $geolng;
//    public $added;
}
