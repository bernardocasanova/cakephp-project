<?php
App::uses('AppModel', 'Model');

class Slider extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'slider' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 940,
                        'h' => 294,
                        'crop' => true
                    ),
                    'thumb' => array(
                        'w' => 94,
                        'h' => 85,
                        'crop' => true
                    )
                )
            )
        )
    );

    public $validate = array(
        'title' => array(
            'maxLength' => array(
                'rule' => array('maxLength', '50'),
                'message' => 'O título deve conter no máximo 50 caracteres'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->addModelIdToSession('slider_id');
    }
}
