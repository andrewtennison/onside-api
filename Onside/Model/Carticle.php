<?php
namespace Onside\Model;
use \Onside\Model;

class Carticle extends Model
{
    protected $_table = 'carticle';
    protected $_index = array(
	'UNIQUE KEY `channelarticle` (`channel`,`article`)',
    );
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'channel' => 'INT(11) NOT NULL',
        'article' => 'INT(11) NOT NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $channel;
    public $article;
    public $added;
}
