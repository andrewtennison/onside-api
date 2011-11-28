<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Article;
use \Onside\Mapper\Channel;
use \Onside\Mapper\Event;
use \Onside\Mapper\Search;

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
	    'search' => new Search($db),
	);
    }
    
    public function actionGet($get = array())
    {
//die(print_r($get, true));
        $this->results[] = array(
	    'channels' => $this->mappers['channel']->searchItem($get),
	    'events' => $this->mappers['event']->searchItem($get),
	    'articles' => $this->mappers['article']->searchItem($get, array('publish' => false)),
	);
    }
    
    public function actionSave($id, $data)
    {
	$this->results[] = $this->mappers['search']->addItem($data);
    }
    
    public function actionList($id, $data)
    {
	$this->results[] = $this->mappers['search']->selectItem($data);
    }
}
