<?php
App::uses('RadioAppController', 'Radio.Controller');

class PollsController extends RadioAppController
{
    public $components = array(
        'RequestHandler'
    );

    public function submit()
    {
        if ($this->request->is('post')) {
            if (!$this->Poll->computeAnswer($this->request->data['vote'], $this->getRadioId())) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível computar seu voto'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => array(
                    'results' => $this->Poll->getAnswersPercentageHtml($this->getRadioId())
                ),
                'message' => 'Seu voto foi computado com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }
}
