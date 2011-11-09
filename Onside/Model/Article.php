<?php
namespace Onside\Model;
use \Onside\Model;

class Article extends Model
{
    protected $_table = 'article';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'title' => 'VARCHAR(100) NOT NULL',
        'source' => 'VARCHAR(100) NOT NULL',
        'publish' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $title;
    public $source;
    public $publish;
//    public $added;
}
