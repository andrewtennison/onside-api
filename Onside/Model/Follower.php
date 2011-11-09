<?php
namespace Onside\Model;
use \Onside\Model;

class Follower extends Model
{
    protected $_table = 'follower';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'channel' => 'INT(11) NOT NULL',
        'user' => 'INT(11) NOT NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $channel;
    public $user;
    public $added;
}
