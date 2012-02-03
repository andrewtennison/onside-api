<?php
namespace Onside\Model;
use \Onside\Model;

class Cchannel extends Model
{
    protected $_table = 'cchannel';
    protected $_index = array(
	'UNIQUE KEY `channelchannel` (`channel1`,`channel2`)',
    );
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'channel1' => 'INT(11) NOT NULL',
        'channel2' => 'INT(11) NOT NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $channel1;
    public $channel2;
    public $added;
}
