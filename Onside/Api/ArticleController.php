<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Article;

class ArticleController extends BaseController
{
    protected $filters = array('author', 'source', 'link', 'type');
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new Article($db);
    }
    
    public function actionDelete($id)
    {
        $this->results[] = $this->_mapper->deleteItem($id);
    }
    
    public function actionGet($data = array())
    {
	$where = $this->getAcceptedFilters($data);
        $this->results[] = $this->_mapper->selectItem($where, array('publish' => false));
    }
    
    public function actionItem($id)
    {
        $this->results[] = $this->_mapper->getItem($id);
    }
    
    public function actionPost($id, $data)
    {
        $this->results[] = $this->_mapper->updateItem($id, $data);
    }
    
    public function actionPut($data)
    {
        $this->results[] = $this->_mapper->addItem($data);
    }
}
