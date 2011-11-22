<?php
namespace Onside\Model;
use \Onside\Model;

class Sport extends Model
{
    protected $_table = 'sport';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100) NOT NULL',
    );
    
    public $id;
    public $name;
}
