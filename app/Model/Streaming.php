<?php
App::uses('AppModel', 'Model');

class Streaming extends AppModel
{
    public $belongsTo = array('Radio');

    private $types = array(
        'AAC', 'MP3', 'WMA', 'WMV', 'iPhone', 'Android'
    );

    public function getTypes()
    {
        return $this->types;
    }
}
