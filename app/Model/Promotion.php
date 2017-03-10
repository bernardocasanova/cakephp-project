<?php
App::uses('AppModel', 'Model');

class Promotion extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'promotion' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 260,
                        'h' => 360,
                        'crop' => true
                    )
                )
            )
        )
    );

    public $validate = array(
        'name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', '10'),
                'message' => 'O nome deve conter no máximo 10 caracteres'
            )
        ),
        'title' => array(
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
        $this->addModelIdToSession('promotion_id');
    }
}
