<?php
namespace Api;
use \Api\BaseController;

class SearchController extends BaseController
{
    public function actionGet()
    {
        return array(array(
            'channels' => array(),
            'events' => array(),
            'articles' => array(),
        ), array());
    }
    
    public function actionList()
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'LIST' not implemented yet")));
    }
}
