<?php
namespace Onside\Model;
use \Onside\Model;

class Auth extends Model
{
    protected $_table = 'auth';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'key' => 'VARCHAR(100)',
	'secret' => 'VARCHAR(100)',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $key;
    public $added;
}
