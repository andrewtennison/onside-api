<?php
namespace Onside\Model;
use \Onside\Model;

class Email extends Model
{
    protected $_table = 'email';
    protected $_index = array(
	'UNIQUE KEY `name` (`name`)',
    );
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'name' => 'VARCHAR(50) NOT NULL',
        'to' => 'VARCHAR(150) NULL',
        'cc' => 'VARCHAR(150) NULL',
	'bcc' => 'VARCHAR(150) NULL',
	'subject' => 'VARCHAR(150) NULL',
	'text' => 'TEXT NULL',
	'html' => 'TEXT NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
    public $to;
    public $cc;
    public $bcc;
    public $subject;
    public $text;
    public $html;
    public $added;
}
