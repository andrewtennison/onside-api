<?php
namespace Onside\Model;
use \Onside\Model;

class Cevent extends Model
{
    protected $_table = 'cevent';
    protected $_index = array(
	'UNIQUE KEY `channelevent` (`channel`,`event`)',
    );
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'channel' => 'INT(11) NOT NULL',
        'event' => 'INT(11) NOT NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $channel;
    public $event;
    public $added;
}
