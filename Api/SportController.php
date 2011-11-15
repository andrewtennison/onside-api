<?php
namespace Api;
use \Api\BaseController;
use \Onside\Mapper\Channel;

class SportController extends BaseController
{
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new Channel($db);
    }
    
    public function actionGet()
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'GET' not implemented yet ");
    }
}