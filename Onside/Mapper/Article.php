<?php
namespace Onside\Mapper;
use \Onside\Mapper;
use \Onside\Db;
use \Onside\Model\Channel;

class Article extends Mapper
{
    protected $_table = 'article';
    protected $_model = '\Onside\Model\Article';
    private $_channelMapper;

    public function __construct(Db $db)
    {
        parent::__construct($db);
        $this->_channelMapper = new \Onside\Mapper\Channel($db);
    }

    public function searchItem($get = array(), $sort = array(), $limit = null)
    {
	$where = array(
	    'title' => array('LIKE', "%{$get['q']}%", 'OR'),
	    'keywords' => array('LIKE', "%{$get['q']}%", 'OR'),
	);
	return $this->_selectItem($where, $sort, $limit, array());
    }


    public function selectItem($where = array(), $sort = array(), $limit = null, $join = array())
    {
	if (array_key_exists('channel', $where)) {
            $channels = $this->_channelMapper->getItem($where['channel']);
            $channel = $channels[0];
            if(!empty($channel->search_term)) {
                return $this->searchItem(array('q' => $channel->search_term), $sort, $limit);
            }
            else {
                $join[] = array(
                    'table' => 'carticle',
                    'leftfield' => 'id',
                    'rightfield' => 'article',
                    'type' => 'JOIN',
                    'fields' => array(),
                    'wherefield' => 'channel',
                    'wherevalue' => $where['channel'],
                );
                unset($where['channel']);
            }
	}
	if (array_key_exists('event', $where)) {
//	    $join[] = array(
//		'table' => 'channel',
//		'leftfield' => 'id',
//		'rightfield' => 'channel',
//		'type' => 'JOIN',
//		'fields' => array(),
//		'wherefield' => 'user',
//		'wherevalue' => $where['user'],
//	    );
	    unset($where['event']);
	}

        return $this->_selectItem($where, $sort, $limit, $join);
    }
}
