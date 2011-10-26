<?php
namespace Onside\Model;
use \Onside\Model;

class Article extends Model
{
    protected $_table = 'article';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
//    public $added;
}
