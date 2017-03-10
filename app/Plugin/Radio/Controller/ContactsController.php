<?php
App::uses('RadioAppController', 'Radio.Controller');

App::uses('CakeEmail', 'Network/Email');

class ContactsController extends RadioAppController
{
    public $components = array(
        'RequestHandler',
        'Email'
    );

    public $uses = array(
        'Contact',
        'Radio'
    );

    public function send()
    {
        if ($this->request->is('post')) {

            $this->Contact->set($this->request->data);
            $this->Contact->set('radio_id', $this->getRadioId());

            if (!$this->Contact->save($this->Contact->data)) {
                
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível realizar o contato'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => null,
                'message' => 'Contato realizado com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }
}
