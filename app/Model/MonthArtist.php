<?php
App::uses('AppModel', 'Model');

class MonthArtist extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'month_artist' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 263,
                        'h' => 175,
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
        $this->addModelIdToSession('month_artist_id');
    }
}
