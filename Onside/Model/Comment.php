<?php
namespace Onside\Model;
use \Onside\Model;

class Comment extends Model
{
    protected $_table = 'comment';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'article' => 'INT(4) NULL',
	'channel' => 'INT(4) NULL',
	'event' => 'INT(4) NULL',
	'user' => 'INT(4) NULL',
	'reply' => 'INT(4) NULL',
        'comment' => 'TEXT',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $article;
    public $channel;
    public $event;
    public $user;
    public $reply;
    public $comment;
    public $added;
}
