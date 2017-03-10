<?php
App::uses('AppModel', 'Model');

class Event extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'event' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 150,
                        'h' => 140,
                        'crop' => true
                    )
                )
            )
        )
    );

    public $validate = array(
        'name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', '20'),
                'message' => 'O nome deve conter no máximo 20 caracteres'
            )
        ),
        'local' => array(
            'maxLength' => array(
                'rule' => array('maxLength', '20'),
                'message' => 'O local deve conter no máximo 20 caracteres'
            )
        ),
        'hour' => array(
            'time' => array(
                'rule' => 'time',
                'message' => 'A hora informada é inválida'
            )
        ),
        'date' => array(
            'date' => array(
                'rule' => array('date', 'dmy'),
                'message' => 'A data informada é inválida'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->addModelIdToSession('event_id');
    }
}
