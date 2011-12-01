<?php
namespace Onside\Model;
use \Onside\Model;

class Article extends Model
{
    protected $_table = 'article';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'type' => 'ENUM("rss","twitter","youtube","google","custom") NOT NULL Default "rss"',
	'title' => 'VARCHAR(100) NOT NULL',
	'content' => 'TEXT',
	'images' => 'TEXT',
	'videos' => 'TEXT',
	'author' => 'VARCHAR(100) NULL',
        'source' => 'VARCHAR(100) NOT NULL',
	'link' => 'VARCHAR(100) NOT NULL',
	'extended' => 'TEXT',
        'publish' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
	'keywords' => 'TEXT',
	'original' => 'TEXT',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    
    public $id;
    public $type;
    public $title; /* searchable */
    public $content;
    public $images;
    public $videos;
    public $author;
    public $source; /* searchable */
    public $link;
    public $extended;
    public $publish;
    public $keywords;
    public $original;
//    public $added;
}


/**
 * title
 * image(s) - plus dimensions
 * video
 * content
 * author // searchable
 * source (link)
 * extended (link for more)
 * publication date // searchable
 * 
 * type - will be need to be defined by the processing engine
 * 
 * 
 * 

[title] => Kurucz eyes loan deal
[description] => West Ham goalkeeper Peter Kurucz has revealed he is willing to go out on loan to League Two in order to find first-team football.
[link] => http://www1.skysports.com/football/news/11688/7304128/
[guid] => 11688_7304128
[pubDate] => Fri, 11 Nov 2011 16:09:16 GMT
[category] => News Story
[enclosure] => stdClass Object
    (
	[@attributes] => stdClass Object
	(
	    [type] => image/jpg
	    [url] => http://img.skysports.com/11/11/128x67/Peter-Kurucz_2677155.jpg
	    [length] => 123456
	)
    )
)
 */