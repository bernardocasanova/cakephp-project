<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    public $components = array(
        'RequestHandler'
    );

    private $privateUser = array(1);

    public function admin_index()
    {
        $users = $this->User->find('all', array(
            'fields' => array(
                'id',
                'email',
                'status',
                'created',
                'modified'
            ),
            'contain' => array(
                'Group' => array('name')
            ),
            'conditions' => array(
                'User.id !=' => $this->privateUser // dont bring dev user
            )
        ));

        $this->set('users', $users);
        $this->set('title', 'Usuários');
    }

    public function admin_create()
    {
        $groups = $this->User->Group->getAvailableGroups();

        $this->set('groups', $groups);
        $this->set('title', 'Cadastrar usuário');
    }

    public function admin_store()
    {
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            $this->modelValidations($this->User, array('action' => 'create', 'admin' => true));

            if (!$this->User->saveAll($this->User->data, array('validate' => false))) {
                $this->Notification->flash('error', 'Não foi possível cadastrar o usuário ' . $this->request->data['User']['email']);
                return $this->redirect(array('action' => 'create', 'admin' => true));
            }

            $this->Notification->flash('success', 'Usuário cadastrado com sucesso');
            return $this->redirect(array('action' => 'index', 'admin'  => true));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_edit($id = null)
    {
        if (!$this->User->exists($id) || in_array($id, $this->privateUser)) {
            throw new NotFoundException(__('Usuário não foi encontrado'));
        }

        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $id),
            'contain'    => array('Profile')
        ));

        $groups = $this->User->Group->getAvailableGroups();

        $this->set(compact('user', 'groups'));
        $this->set('title', 'Editar usuário');
    }

    public function admin_update($id = null)
    {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->User->exists($id) || in_array($id, $this->privateUser)) {
                throw new NotFoundException(__('Usuário não encontrado'));
            }

            $this->User->set('id', $id);
            $this->User->set($this->request->data);
            $this->modelValidations($this->User, array('action' => 'edit', 'admin' => true, $id));

            $this->User->Profile->deleteAll(array('user_id' => $id));

            if (!$this->User->saveAll($this->User->data, array('validate' => false))) {
                $this->Notification->flash('error', __('Não foi possível editar o usuário'));
                return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
            }

            $this->Notification->flash('success', __('Usuário editado com sucesso'));
            return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_destroy($id = null)
    {
        if (!$this->User->exists($id) || in_array($id, $this->privateUser)) {
            throw new NotFoundException(__('Usuário não encontrado'));
        }

        if (!$this->User->delete($id, true)) {
            $this->Notification->flash('error', __('Não foi possível excluir o usuário'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Usuário excluído com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_activate($id = null)
    {
        if (!$this->User->exists($id) || in_array($id, $this->privateUser)) {
            throw new NotFoundException(__('Usuário não encontrado'));
        }

        $this->User->id = $id;
        $this->User->set(array('status' => 1));

        if (!$this->User->save(null, false)) {
            $this->Notification->flash('error', __('Não foi possível ativar o usuário'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Usuário ativado com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_deactivate($id = null)
    {
        if (!$this->User->exists($id) || in_array($id, $this->privateUser)) {
            throw new NotFoundException(__('Usuário não encontrado'));
        }

        $this->User->id = $id;
        $this->User->set(array('status' => 0));

        if (!$this->User->save(null, false)) {
            $this->Notification->flash('error', __('Não foi possível desativar o usuário'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Usuário desativado com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_login()
    {
        $this->layout = false;

        if ($this->Session->read('Auth.Admin')) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }

    public function admin_attempt()
    {
        if ($this->request->is('post')) {
            $response = array(
                'status'  => 'redirect',
                'data'    => array(
                    'redirectUrl' => Router::url(array(
                        'controller' => 'users',
                        'action'     => 'index',
                        'admin'      => true
                    ), true)
                ),
                'message' => null
            );

            if (!$this->Auth->login()) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $this->Auth->authError
                );
            }

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_logout()
    {
        return $this->redirect($this->Auth->logout());
    }

}
