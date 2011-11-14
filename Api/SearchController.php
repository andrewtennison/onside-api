<?php
namespace Api;
use \Api\BaseController;

class SearchController extends BaseController
{
    public function actionGet()
    {
        $this->results[] = array('channels' => array(), 'events' => array(), 'articles' => array());
    }
    
    public function actionList()
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'LIST' not implemented yet ");
    }
}
