<?php
namespace Api;
use \Api\BaseApi;

class Api extends BaseApi
{
    protected $allowedServices = array(
	'article',
	'channel',
	'discussion',
	'event',
	'search',
	'user'
    );
}
