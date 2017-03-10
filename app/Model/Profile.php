<?php
App::uses('AppModel', 'Model');

class Profile extends AppModel
{
    public $validate = array(
        'first_name' => array(
            'maxLength' => array(
                'allowEmpty' => true,
                'rule' => array('maxLength', '100'),
                'message' => 'O nome deve conter no máximo 100 caracteres'
            )
        ),
        'last_name' => array(
            'maxLength' => array(
                'allowEmpty' => true,
                'rule' => array('maxLength', '100'),
                'message' => 'O sobrenome deve conter no máximo 100 caracteres'
            )
        ),
        'phone' => array(
            'maxLength' => array(
                'allowEmpty' => true,
                'rule' => array('maxLength', '20'),
                'message' => 'O telefone deve conter no máximo 20 caracteres'
            )
        )
    );

    public $belongsTo = array('User');
}
