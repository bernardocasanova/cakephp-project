<?php
App::uses('RadioAppController', 'Radio.Controller');

class ParticipantsController extends RadioAppController
{
    public $components = array(
        'RequestHandler'
    );

    public $uses = array(
        'Participant'
    );

    public function add()
    {
        if ($this->request->is('post')) {

            $this->Participant->set($this->request->data);

            if (!$this->Participant->save($this->Participant->data)) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível salvar suas informações'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => null,
                'message' => 'Suas informações foram salvas com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }
}