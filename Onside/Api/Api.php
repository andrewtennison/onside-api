<?php
namespace Onside\Api;
use \Onside\Api\BaseApi;

class Api extends BaseApi
{
    protected $allowedServices = array(
	'article',
	'channel',
	'comment',
	'email',
	'event',
	'search',
	'user',
	'sport',
	'source',
    );
}
