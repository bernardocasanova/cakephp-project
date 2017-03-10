<?php
App::uses('AppModel', 'Model');

class Gallery extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'gallery' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 190,
                        'h' => 190,
                        'crop' => true
                    ),
                    'thumb' => array(
                        'w' => 125,
                        'h' => 125,
                        'crop' => true
                    )
                ),
                'multiple' => true
            )
        )
    );

    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um nome para a galeria'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '40'),
                'message' => 'O nome deve conter no máximo 40 caracteres'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->addModelIdToSession('gallery_id');
    }

    
}
