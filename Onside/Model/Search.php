<?php
namespace Onside\Model;
use \Onside\Model;

class Search extends Model
{
    protected $_table = 'search';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'user' => 'INT(11) NULL',
        'name' => 'VARCHAR(100) NULL',
	'query' => 'VARCHAR(100) NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $user;
    public $name;
    public $query;
//    public $added;
}
