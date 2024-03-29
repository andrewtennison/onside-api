<?php
namespace Onside\Model;
use \Onside\Model;

class Channel extends Model
{
    protected $_table = 'channel';

    protected $_index = array(
        'UNIQUE KEY `channel_name_idx` (`name`)',
        'UNIQUE KEY `channel_search_term_idx` (`search_term`)',
    );

    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
	'hash' => 'VARCHAR(10)', // for use with twitter
	'image' => 'VARCHAR(150) NULL',
        'description' => 'TEXT',
        'sport' => 'VARCHAR(50)',
        'type' => 'VARCHAR(50)',
        'level' => 'INT(1) NOT NULL default 1',
	'keywords' => 'TEXT',
	'status' => 'ENUM("active","hidden") default "hidden"',
	'branding' => 'VARCHAR(100) NULL',
        'geolat' => 'DECIMAL(10,6) default NULL',
        'geolng' => 'DECIMAL(10,6) default NULL',
        'search_term' => 'VARCHAR(50)',
        'user' => 'INT(11) default NULL',
        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );

    public $id;
    public $name; /* searchable */
    public $hash;
    public $image;
    public $description;
    public $sport; /* searchable */
    public $type; /* searchable */
    public $level;
    public $keywords; /* searchable */
    public $status;
    public $branding;
    public $geolat;
    public $geolng;
    public $search_term;
    public $user;

//    public $added;
}

/**
 * source(s) can be [fliker/rss/twitter/youtube]
 *
 * users (admin)
 * followers
 *
 * can save a search as a source for channe, this will
 * associate channel/event/articles* to this channel
 */
