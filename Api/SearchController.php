<?php
namespace Api;
use \Api\BaseController;
use \Onside\Mapper\Article;
use \Onside\Mapper\Channel;
use \Onside\Mapper\Event;

class SearchController extends BaseController
{
    private $mappers;
    
    public function __construct()
    {
	global $db;
        $this->mappers = array(
	    'article' => new Article($db),
	    'channel' => new Channel($db),
	    'event' => new Event($db),
	);
    }
    
    public function actionGet($get = array())
    {
//die(print_r($get, true));
        $this->results[] = array(
	    'channels' => $this->mappers['channel']->searchItem($get),
	    'events' => $this->mappers['event']->searchItem($get),
	    'articles' => $this->mappers['article']->searchItem($get),
	);
    }
    
    public function actionList()
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'LIST' not implemented yet ");
    }
}
