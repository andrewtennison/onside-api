<?php
namespace Api;
use \Api\BaseApi;

class Api extends BaseApi
{
    protected $allowedServices = array(
	'article',
	'channel',
	'comment',
	'event',
	'search',
	'user',
	'sport',
    );
}
