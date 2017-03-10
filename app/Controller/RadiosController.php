<?php
App::uses('AppController', 'Controller');

class RadiosController extends AppController
{
    public $components = array(
        'RequestHandler'
    );

    public function admin_index()
    {
        $radios = $this->Radio->find('all', array(
            'fields' => array(
                'id',
                'name',
                'status',
                'created',
                'modified'
            ),
            'contain' => array(
                'Owner' => array('email')
            )
        ));

        $this->set('radios', $radios);
        $this->set('title', 'Rádios');
    }

    public function admin_create()
    {
        $users = $this->Radio->User->getAvailableUsersForRadios();

        $this->set('users', $users);
        $this->set('title', 'Cadastrar rádio');
    }

    public function admin_store()
    {
        if ($this->request->is('post')) {

            $userId = $this->Radio->User->getUserIdForRadios($this->request->data);

            if ($userId === false) {
                $this->Notification->flash('error', 'Não foi possível cadastrar seu usuário junto a rádio');
                return $this->redirect(array('action' => 'create', 'admin'  => true));
            }

            unset($this->request->data['User']);

            $this->Radio->set($this->request->data);
            $this->Radio->set('user_id', $userId);
            $this->modelValidations($this->Radio, array('action' => 'create', 'admin' => true));

            if (!$this->Radio->saveAll($this->Radio->data, array('validate' => false))) {
                $this->Notification->flash('error', 'Não foi possível cadastrar a rádio ' . $this->request->data['Radio']['name']);
                return $this->redirect(array('action' => 'create', 'admin'  => true));
            }

            $this->Radio->addAttachments($this->request->data['Radio']['template']);

            $this->Notification->flash('success', 'Rádio cadastrada com sucesso');
            return $this->redirect(array('action' => 'index', 'admin'  => true));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_edit($id = null)
    {
        if (!$this->Radio->exists($id)) {
            throw new NotFoundException(__('Rádio não encontrada'));
        }

        $types     = $this->Radio->Streaming->getTypes();
        $radio     = $this->Radio->find('first', array(
            'conditions' => array('Radio.id' => $id),
            'contain'    => array(
                'Owner',
                'Streaming'
            )
        ));

        $this->set(compact('types', 'radio'));
        $this->set('title', 'Editar rádio');
    }

    public function admin_update($id = null)
    {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->Radio->exists($id)) {
                throw new NotFoundException(__('Rádio não encontrada'));
            }

            $this->Radio->set('id', $id);
            $this->Radio->set($this->request->data);
            $this->modelValidations($this->Radio, array('action' => 'edit', 'admin' => true, $id));

            $this->Radio->deleteRemovedStreamings();

            if (!$this->Radio->saveAll($this->Radio->data, array('validate' => false))) {
                $this->Notification->flash('error', __('Não foi possível editar a rádio'));
                return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
            }

            $this->Notification->flash('success', __('Rádio editada com sucesso'));
            return $this->redirect(array('action' => 'edit', 'admin' => true, $id));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function admin_destroy($id = null)
    {
        if (!$this->Radio->exists($id)) {
            throw new NotFoundException(__('Rádio não encontrada'));
        }

        if (!$this->Radio->delete($id, true)) {
            $this->Notification->flash('error', __('Não foi possível excluir a rádio'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Rádio excluída com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_activate($id = null)
    {
        if (!$this->Radio->exists($id)) {
            throw new NotFoundException(__('Rádio não encontrada'));
        }

        $this->Radio->id = $id;
        $this->Radio->set(array('status' => 1));

        if (!$this->Radio->save(null, false)) {
            $this->Notification->flash('error', __('Não foi possível ativar a rádio'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Rádio ativada com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_deactivate($id = null)
    {
        if (!$this->Radio->exists($id)) {
            throw new NotFoundException(__('Rádio não encontrada'));
        }

        $this->Radio->id = $id;
        $this->Radio->set(array('status' => 0));

        if (!$this->Radio->save(null, false)) {
            $this->Notification->flash('error', __('Não foi possível desativar a rádio'));
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Notification->flash('success', __('Rádio desativada com sucesso'));
        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_streaming_html()
    {
        if ($this->request->is('post')) {
            $index     = $this->request->data['index'];
            $types     = $this->Radio->Streaming->getTypes();

            return $this->set(compact('index', 'types'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }
}
