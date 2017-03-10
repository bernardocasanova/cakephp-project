<?php
App::uses('AppModel', 'Model');

class Announcer extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'announcer' => array(
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
                'rule' => array('maxLength', '100'),
                'message' => 'O nome deve conter no máximo 100 caracteres'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->addModelIdToSession('announcer_id');
    }
}
