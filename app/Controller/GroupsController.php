<?php
App::uses('AppController', 'Controller');

class GroupsController extends AppController
{
    public $components = array(
        'RequestHandler'
    );

    private $privateGroups = array(1, 2);

    public function admin_index()
    {
        $groups = $this->Group->find('all', array(
            'fields' => array(
                'id',
                'name',
                'created',
                'modified'
            ),
            'contain' => array(
                'User' => array('id')
            ),
            'conditions' => array(
                'id !=' => $this->privateGroups // dont bring dev or admin group since they can't be edited
            )
        ));

        $this->set('groups', $groups);
        $this->set('title', 'Grupos');
    }

    public function admin_create()
    {
        $acos = $this->Group->getAllAcos();

        $this->set('acos', $acos);
        $this->set('title', 'Cadastrar grupo');
    }

    public function admin_store()
    {
        if ($this->request->is('post')) {
            $this->Group->set($this->request->data);
            $this->modelValidations($this->Group, array('action' => 'create', 'admin' => true));

            if (!$this->Group->save($this->Group->data, false)) {
                $this->Notification->flash('error', 'Não foi possível cadastrar o grupo ' . $this->request->data['Group']['name']);
                return $this->redirect(array('action' => 'create', 'admin'  => true));
            }

            $this->Notification->flash('success', 'Grupo cadastrado com sucesso');
            return $this->redirect(array('action' => 'index', 'admin'  => true));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_edit($id = null)
    {
        if (!$this->Group->exists($id) || in_array($id, $this->privateGroups)) {
            throw new NotFoundException(__('Grupo não encontrado'));
        }

        $group = $this->Group->find('first', array(
            'conditions' => array('id' => $id)
        ));

        $acos = $this->Group->getAllAcos($id);

        $this->set(compact('group', 'acos'));
        $this->set('title', 'Editar grupo');
    }

    public function admin_update($id = null)
    {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->Group->exists($id) || in_array($id, $this->privateGroups)) {
                throw new NotFoundException(__('Grupo não encontrado'));
            }

            $this->Group->id = $id;
            $this->Group->set($this->request->data);
            $this->modelValidations($this->Group, array('action' => 'edit', 'admin' => true, $id));

            if (!$this->Group->save($this->Group->data, false)) {
                $this->Notification->flash('error', __('Não foi possível editar o grupo'));
                return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
            }

            $this->Notification->flash('success', __('Usuário editado com sucesso'));
            return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_destroy($id = null)
    {
        if (!$this->Group->exists($id) || in_array($id, $this->privateGroups)) {
            throw new NotFoundException(__('Grupo não encontrado'));
        }

        // Move the users from this group to the temporary group
        $updated = $this->Group->User->updateAll(
            array('group_id' => 2),
            array('group_id' => $id)
        );

        if (!$updated || !$this->Group->delete($id, true)) {
            $this->Notification->flash('error', __('Não foi possível excluir o grupo'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Grupo excluído com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

}
