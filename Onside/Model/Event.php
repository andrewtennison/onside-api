<?php
namespace Onside\Model;
use \Onside\Model;

class Event extends Model
{
    protected $_table = 'event';
    protected $_definitions = array(
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        'name' => 'VARCHAR(100)',
	'hash' => 'VARCHAR(10)', // for use with twitter
        'sport' => 'VARCHAR(50)',
        'type' => 'VARCHAR(50)',
	'keywords' => 'TEXT',
	'participants' => 'TEXT',
	'time' => 'TEXT',
	'parent' => 'INT(4) NULL',
	'location' => 'TEXT',
        'geolat' => 'DECIMAL(10,6) default NULL',
        'geolng' => 'DECIMAL(10,6) default NULL',
//        'added' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    );
    protected $_jsonfields = array('participants', 'time');


    public $id;
    public $name; /* searchable */
    public $hash;
    public $sport; /* searchable */
    public $type; /* searchable */
    public $keywords; /* comma separated - searchable */
    public $participants; /* needs to be defined per sport - are included in response as objects */
    public $time;
    public $parent; /* another event - always the same type of object */
    public $location;
    public $geolat;
    public $geolng;
//    public $added;
}

/**
 * status - [pre/live/post]
 * 
 * (match) - team names
 * (tournament) - multiple team names
 * 
 * [participent] - these will be specific to the event
 * name
 * position
 * score
 * points
 * 
 * [time] - these will be specific to the event type
 * start_date
 * end_date
 * duration
 */
