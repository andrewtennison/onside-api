<?php
namespace Api;
use \Api\BaseResponse;

class Response extends BaseResponse
{
    protected $allowedTypes = array('Events', 'Articles', 'Channels');
//    protected $integerFields = array('vote', 'votes');
    protected $booleanFields = array('isModerated');
}
