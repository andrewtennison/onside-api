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
        'password' => 'VARCHAR(50) NULL',
	'facebook' => 'VARCHAR(50) NULL',
	'twitter' => 'VARCHAR(50) NULL',
	'google' => 'VARCHAR(50) NULL',
	'language' => 'VARCHAR(5) NOT NULL default "en_gb"',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
	'admin' => 'BOOLEAN NOT NULL Default false',
	'enabled' => 'BOOLEAN NOT NULL Default false',
    );
    
    public $id;
    public $name;
    public $email;
    public $password;
    public $facebook;
    public $twitter;
    public $google;
    public $language;
    public $added;
    public $admin;
    public $enabled;
}
