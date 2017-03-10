<?php
App::uses('AppModel', 'Model');

class News extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'new' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 150,
                        'h' => 140,
                        'crop' => true
                    ),
                    'modal' => array(
                        'w' => 450,
                        'h' => 500,
                        'crop' => true
                    ),
                    'banner' => array(
                        'w' => 535,
                        'h' => 160,
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
        'description' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'A descrição não deve ser deixada em branco'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->addModelIdToSession('new_id');
    }
}
