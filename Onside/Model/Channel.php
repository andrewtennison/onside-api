<?php
namespace Onside\Model;
use \Onside\Model;

class Channel extends Model
{
    protected $_table = 'channel';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
//    public $added;
}
