<?php
namespace Onside\Api;

abstract class BaseController
{
    protected $results = array();
    protected $errors = array();
    protected $filters = array();
    protected $limit = null;

    public function actionDelete($id)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'DELETE' not implemented yet ");
    }

    public function actionGet($data = array())
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'GET' not implemented yet ");
    }

    public function actionItem($id)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'ITEM($id)' not implemented yet ");
    }

    public function actionPost($id, $data)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'POST' not implemented yet ");
    }

    public function actionPut($data)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'PUT' not implemented yet ");
    }

    public function getResults() { return $this->results; }

    public function getErrors() { return $this->errors; }

    protected function getAcceptedFilters($data = array())
    {
	if (array_key_exists('limit', $data)) {
	    $this->limit = $data['limit'];
	}

	$where = array();
	foreach ($this->filters as $filter)
	    if (array_key_exists($filter, $data))
		$where[$filter] = $data[$filter];
	return $where;
    }

    protected function getSort($data)
    {
        $sort = array();
        if (array_key_exists('sort', $data)) {
            $sortItems = explode(',', $data['sort']);
            foreach ($sortItems as $sortItem) {
                $sortParts = explode(' ', $sortItem);
                $sort[$sortParts[0]] = (!array_key_exists(1, $sortParts) || $sortParts[1] !== 'desc' );
            }
        }
        return $sort;
    }
}
