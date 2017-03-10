<?php
App::uses('AppModel', 'Model');

class Participant extends AppModel
{
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Seu nome não deve ser deixado em branco'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '30'),
                'message' => 'Seu nome deve conter no máximo 30 caracteres'
            )
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Seu e-mail não deve ser deixado em branco'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '255'),
                'message' => 'Seu e-mail deve conter no máximo 255 caracteres'
            )
        )
    );

    public $belongsTo = array('Promotion');
}
