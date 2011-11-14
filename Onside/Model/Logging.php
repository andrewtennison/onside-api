<?php
namespace Onside\Model;
use \Onside\Model;

class Logging extends Model
{
    protected $_table = 'logging';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'code' => 'INT(4) NOT NULL',
	'message' => 'TEXT NOT NULL',
	'stacktrace' => 'TEXT',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $code;
    public $message;
    public $stacktrace;
    public $added;
}
