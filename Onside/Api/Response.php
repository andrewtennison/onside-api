<?php
namespace Onside\Api;
use \Onside\Api\BaseResponse;

class Response extends BaseResponse
{
//    protected $allowedTypes = array('Event', 'Article', 'Channel', 'User', 'Search');
//    protected $integerFields = array('vote', 'votes');
    protected $booleanFields = array('isModerated');
}
