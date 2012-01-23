<?php
namespace Onside\Model;
use \Onside\Model;

class Source extends Model
{
    protected $_table = 'source';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'status' => 'ENUM("processed","running", "failed") NOT NULL Default "processed"',
	'lastfetched' => 'TIMESTAMP NOT NULL Default CURRENT_TIMESTAMP',
	'url' => 'VARCHAR(100) NOT NULL',
	'channels' => 'VARCHAR(100) NULL',
	'frequency' => 'VARCHAR(100) NULL',
	'map_type' => 'VARCHAR(100) NULL',
	'map_article' => 'VARCHAR(100) NULL',
	'map_title' => 'VARCHAR(100) NULL',
	'map_content' => 'VARCHAR(100) NULL',
	'map_images' => 'VARCHAR(100) NULL',
	'map_videos' => 'VARCHAR(100) NULL',
	'map_author' => 'VARCHAR(100) NULL',
        'map_source' => 'VARCHAR(100) NULL',
	'map_link' => 'VARCHAR(100) NULL',
	'map_extended' => 'VARCHAR(100) NULL',
        'map_publish' => 'VARCHAR(100) NULL',
	'map_keywords' => 'VARCHAR(100) NULL',
    );
    
    public $id;
    public $status = 'processed';
    public $lastfetched;
    public $url;
    public $channels;
    public $frequency;
    public $map_type;
    public $map_article;
    public $map_title;
    public $map_content;
    public $map_images;
    public $map_videos;
    public $map_author;
    public $map_source;
    public $map_link;
    public $map_extended;
    public $map_publish;
    public $map_keywords;
}
