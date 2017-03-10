<?php
App::uses('AppModel', 'Model');

class Script extends AppModel
{
    public $belongsTo = array('Radio');
}