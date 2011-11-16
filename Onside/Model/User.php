<?php
namespace Onside\Model;
use \Onside\Model;

class User extends Model
{
    protected $_table = 'user';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
        'email' => 'VARCHAR(255) NOT NULL',
        'password' => 'VARCHAR(50) NOT NULL',
	'facebook' => 'VARCHAR(50) NULL',
	'twitter' => 'VARCHAR(50) NULL',
	'google' => 'VARCHAR(50) NULL',
	'linkedin' => 'VARCHAR(50) NULL',
	'language' => 'VARCHAR(5) NOT NULL default "en_us"',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $name;
    public $email;
    public $password;
    public $facebook;
    public $twitter;
    public $google;
    public $linkedin;
    public $language;
    public $added;
}
