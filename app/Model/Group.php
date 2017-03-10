<?php
App::uses('AppModel', 'Model');

class Group extends AppModel
{
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Informe um nome para o grupo'
            )
        )
    );

    public $hasMany = array(
        'User'
    );

    public $actsAs = array(
        'Acl' => array('type' => 'requester')
    );

    protected $translatedModelName = 'Grupo';

    protected $acosInfo = array(
        'Criar' => array(
            'notAllowedMessage' => 'Você não possui permissão para criar os grupos',
            'actions' => array(
                'admin_create',
                'admin_store'
            )
        ),
        'Editar' => array(
            'notAllowedMessage' => 'Você não possui permissão para editar os grupos',
            'actions' => array(
                'admin_edit',
                'admin_update'
            )
        ),
        'Excluir' => array(
            'notAllowedMessage' => 'Você não possui permissão para excluir os grupos',
            'actions' => array('admin_destroy')
        ),
        'Visualizar' => array(
            'notAllowedMessage' => 'Você não possui permissão para visualizar os grupos',
            'actions' => array('admin_index')
        )
    );

    public function parentNode()
    {
        return null;
    }

    public function getAvailableGroups()
    {
        $groups = $this->find('list', array(
            'conditions' => array(
                'id !=' => 2 // no one can create a tmp user
            )
        ));

        return $groups;
    }

    public function afterSave($created, $options = array())
    {
        $this->grantPermissionsToGroup();
    }

    private function grantPermissionsToGroup()
    {
        $this->revokePermissionsFromGroup();

        // first deny access to everything
        $Acl = new AclComponent(new ComponentCollection());
        $Acl->deny(array('model' => 'Group', 'foreign_key' => $this->id), 'controllers');

        if (!isset($this->data['Group']['permissions']) || empty($this->data['Group']['permissions'])) {
            return;
        }

        // then iterate the permissions array and grant access to the actions needed
        foreach ($this->data['Group']['permissions'] as $key => $permission) {
            list($controller, $label) = explode('.', $permission);

            // instantiate the model if needed
            $model      = Inflector::singularize($controller);
            ${$model}   = $this->initModel($model);

            // get an array with the actions to be allowed
            $acoActions = ${$model}->getAcoActionsByLabel($label);

            if (!empty($acoActions)) {
                foreach ($acoActions as $action) {
                    $Acl->allow(array('model' => 'Group', 'foreign_key' => $this->id), 'controllers/' . $controller . '/' . $action);
                }
            }
        }
    }

    private function revokePermissionsFromGroup()
    {
        $Aro      = $this->initModel('Aro');
        $ArosAcos = $this->initModel('ArosAcos');

        $result = $Aro->find('first', array(
            'conditions' => array(
                'foreign_key' => $this->id
            )
        ));

        $ArosAcos->deleteAll(array('aro_id' => $result['Aro']['id']));
    }

/**
 * This method will returns the main Acos with all his childrens created
 * on their model.
 *
 * @return array  the acos each group can access or not
 */
    public function getAllAcos($id = null)
    {
        $Aco = ClassRegistry::init('Aco');

        $acos = $Aco->find('all', array(
            'conditions' => array('parent_id' => 1),
            'recursive'  => -1
        ));

        $results = array();

        foreach ($acos as $key => $aco) {
            if ($this->startsWith($aco['Aco']['alias'], 'radio')) {
                continue;
            }

            $model    = Inflector::singularize($aco['Aco']['alias']);
            ${$model} = ClassRegistry::init($model);

            $results[$key]['parentAlias'] = $aco['Aco']['alias'];
            $results[$key]['parentName']  = ${$model}->getAcoParentName();
            $results[$key]['permissions'] = ${$model}->getAcoLabels();

            if (!is_null($id)) {
                $results[$key]['allowed'] = ${$model}->getAcoAllowedLabels($id);
            }
        }

        return $results;
    }
}
