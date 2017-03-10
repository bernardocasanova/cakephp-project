<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
    public $validate = array(
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um e-mail'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'E-mail informado é inválido'
            ),
            'isUnique' => array(
                'rule' => array('isUnique', array('email', 'group_id'), false),
                'message' => 'O e-mail informado já possui um cadastro nesse grupo',
                'on' => 'create'
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe uma senha'
            ),
            'minLength' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Sua senha deve ter no mínimo 6 caracteres'
            )
        ),
        'group_id' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Grupo inválido'
            ),
            'notAllowed' => array(
                'rule' => array('comparison', '!=', 2),
                'message' => 'Você não possui permissão para adicionar usuários a esse grupo'
            )
        )
    );

    public $belongsTo = array('Group');

    public $hasOne = array(
        'Profile' => array(
            'dependent' => true
        )
    );

    public $hasMany = array(
        'Radio' => array(
            'dependent' => true
        )
    );

    public $hasAndBelongsToMany = array(
        'Radio'
    );

    public $actsAs = array(
        'Acl' => array('type' => 'requester')
    );

    protected $translatedModelName = 'Usuário';

    protected $acosInfo = array(
        'Criar' => array(
            'notAllowedMessage' => 'Você não possui permissão para criar os usuários',
            'actions' => array(
                'admin_create',
                'admin_store'
            )
        ),
        'Editar' => array(
            'notAllowedMessage' => 'Você não possui permissão para editar os usuários',
            'actions' => array(
                'admin_edit',
                'admin_update',
                'admin_activate',
                'admin_deactivate'
            )
        ),
        'Excluir' => array(
            'notAllowedMessage' => 'Você não possui permissão para excluir os usuários',
            'actions' => array('admin_destroy')
        ),
        'Visualizar' => array(
            'notAllowedMessage' => 'Você não possui permissão para visualizar os usuários',
            'actions' => array('admin_index')
        )
    );

    public function parentNode()
    {
        if (!$this->id && empty($this->data)) {
            return null;
        }

        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }

        if (!$groupId) {
            return null;
        }

        return array('Group' => array('id' => $groupId));
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->name]['password']) && !empty($this->data[$this->name]['password'])) {
            $this->data[$this->name]['password'] = AuthComponent::password($this->data[$this->name]['password']);
        }

        return true;
    }

    public function beforeValidate($options = array())
    {
        $this->unsetEmptyProfileFields();
    }

    public function getAvailableUsersForRadios()
    {
        $result = $this->find('all', array(
            'conditions' => array(
                'status'   => 1,
                'group_id' => 3
            ),
            'contain' => array(
                'Profile'
            )
        ));

        if (empty($result)) {
            return array();
        }

        $availableUsers = array();

        foreach ($result as $key => $user) {
            $availableUsers[$user['User']['id']] = $this->getUserLabel($user);
        }

        return $availableUsers;
    }

    public function getUserIdForRadios($data = array())
    {
        if (isset($data['Radio']['user_id']) && !empty($data['Radio']['user_id'])) {
            return $data['Radio']['user_id'];
        }

        $data['User']['group_id'] = 3;

        if (!$this->save($data)) {
            return false;
        }

        return $this->id;
    }

    private function getUserLabel($user = array())
    {
        if (empty($user['Profile']['first_name']) && empty($user['Profile']['last_name'])) {
            return $user['User']['email'];
        }

        return trim($user['Profile']['first_name'] . ' ' . $user['Profile']['last_name']) . ' <' . $user['User']['email'] . '>';
    }

    private function unsetEmptyProfileFields()
    {
        if (isset($this->data['Profile'])) {
            foreach ($this->data['Profile'] as $field => $value) {
                if (empty($value)) {
                    unset($this->data['Profile'][$field]);
                }
            }
        }
    }
}
