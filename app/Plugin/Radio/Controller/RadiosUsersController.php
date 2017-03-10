<?php
App::uses('RadioAppController', 'Radio.Controller');

class RadiosUsersController extends RadioAppController
{
    public $components = array(
        'RequestHandler'
    );

    public $uses = array(
        'User'
    );

    private $privateUser = array(1);

    public function login()
    {
        $this->layout = false;

        if ($this->Session->read('Auth.Manager')) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }

    public function attempt()
    {
        if ($this->request->is('post')) {
            $response = array(
                'status'  => 'redirect',
                'data'    => array(
                    'redirectUrl' => Router::url(array(
                        'controller' => 'pages',
                        'action'     => 'home',
                        'plugin'     => 'radio',
                        'radioSlug'  => $this->params['radioSlug']
                    ), true)
                ),
                'message' => null
            );

            if (!$this->Auth->login() || !$this->isUserAllowed()) {
                $this->Auth->logout();

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

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    private function isUserAllowed()
    {
        return $this->Acl->check(
            array('model' => 'User', 'foreign_key' => $this->Auth->user('id')),
            'radio-' . $this->getRadioId()
        );
    }

}
