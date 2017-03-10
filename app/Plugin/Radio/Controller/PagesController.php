<?php
App::uses('RadioAppController', 'Radio.Controller');

class PagesController extends RadioAppController
{
    public $uses = array(
        'Banner',
        'Radio',
        'Poll',
        'Schedule',
        'Gallery',
        'Video'
    );

    public $components = array(
        'RequestHandler',
        'Radio.Horoscope',
        'Radio.Rss',
        'Email'
    );

    public function home_mobile()
    {
        $uploadsFolder      = '/media/uploads/';

        // updated visitors count
        $this->viewVars['radio']['Radio']['visitors'] = $this->Radio->updateVisitors($this->getRadioId());

        $this->set(compact(
            'uploadsFolder'
        ));
    }

    public function home()
    {
        $rss                = $this->Rss->read($this->viewVars['radio']['Radio']['rss']);
        $states             = $this->Radio->getStates();
        $banners            = $this->Banner->getAllBanners($this->getRadioId());
        $loggedIn           = $this->Auth->loggedIn();
        $schedules          = $this->Schedule->getAllSchedules($this->getRadioId());
        $timezones          = $this->Radio->getTimezones();
        $horoscopes         = $this->Horoscope->getTodayHoroscopes($this->viewVars['radio']['Radio']['horoscope']);
        $uploadsFolder      = '/media/uploads/';
        $answersPercentages = $this->Poll->getAnswersPercentages($this->getRadioId());
        // updated visitors count
        $this->viewVars['radio']['Radio']['visitors'] = $this->Radio->updateVisitors($this->getRadioId());

        $this->set(compact(
            'rss',
            'states',
            'banners',
            'loggedIn',
            'schedules',
            'timezones',
            'horoscopes',
            'uploadsFolder',
            'answersPercentages'
        ));
    }

    public function createAlbum() {
        
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            try {

                $this->request->data['radio_id'] = $this->getRadioId();

                if(!$this->Gallery->save($this->request->data)) {
                    throw new RuntimeException(__('Erro ao criar album!'));
                }

                $response = array(
                    'status'  => 'success',
                    'data'    => null,
                    'message' => null,
                );

            } catch (RuntimeException $e) {
                
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $e->getMessage(),
                );
            }

            $this->set(compact('response'));
            return $this->set('_serialize', 'response');
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function editAlbum(){

        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            try {
            
                $this->request->data['radio_id'] = $this->getRadioId();

                if(!$this->Gallery->save($this->request->data)) {
                    throw new RuntimeException(__('Erro ao editar album!'));
                }

                $response = array(
                    'status'  => 'success',
                    'data'    => null,
                    'message' => null,
                );

            } catch (RuntimeException $e) {
                
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $e->getMessage(),
                );
            }

            $this->set(compact('response'));
            return $this->set('_serialize', 'response');
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function loadAlbum() {

        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            if(!$this->Gallery->loadAlbum($this->request->data, $this->getRadioId())){
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível realizar suas alterações'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => $this->Gallery->getResponseData(),
                'message' => 'Alterações realizadas com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function uploadImagesToAlbum() {

        if ($this->request->is('post') && $this->Auth->loggedIn()) {
            
            if (!empty($_FILES)) {
                $this->request->data['files'] = $_FILES['file'];
            }

            $lastId = $this->Gallery->find('first', array(
                'conditions' => array('Gallery.radio_id' => $this->getRadioId()),
                'order' => 'Gallery.id DESC'
            ));

            $this->request->data['foreignKey'] = $lastId['Gallery']['id'];
            $this->request->data['is_multiple'] = true;

            if (!$this->Gallery->saveChanges($this->request->data, $this->getRadioId())) {

                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível realizar suas alterações'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => array(
                    'response_data' => $this->Gallery->getResponseData(),
                    'albumName'     => $lastId['Gallery']['name'],
                    'albumId'       => $lastId['Gallery']['id']
                ),
                'message' => 'Alterações realizadas com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function saveVideo()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            try {
            
                $this->request->data['radio_id'] = $this->getRadioId();

                if(!$this->Video->save($this->request->data)) {
                    throw new RuntimeException(__('Erro ao editar album!'));
                }

                $response = array(
                    'status'  => 'success',
                    'data'    => null,
                    'message' => null,
                );

            } catch (RuntimeException $e) {
                
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $e->getMessage(),
                );
            }

            $this->set(compact('response'));
            return $this->set('_serialize', 'response');
        }
    }

    public function live_edit()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            if (!empty($_FILES)) {
                $this->request->data['files'] = $_FILES['file'];
            }

            $model    = $this->request->data['model'];
            ${$model} = $this->initModel($model);

            if (!${$model}->saveChanges($this->request->data, $this->getRadioId())) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível realizar suas alterações'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => ${$model}->getResponseData(),
                'message' => 'Alterações realizadas com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function update_main_color()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            if (!$this->Radio->updateMainColor($this->request->data['mainColor'], $this->getRadioId())) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível realizar suas alterações'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => null,
                'message' => 'Alterações realizadas com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function add_row()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            $model    = $this->request->data['model'];
            ${$model} = $this->initModel($model);

            ${$model}->set($this->request->data['fields']);
            ${$model}->set('radio_id', $this->getRadioId());

            if (!${$model}->save($this->request->data['fields'])) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível adicionar'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => array(
                    'foreignKey' => ${$model}->getLastInsertID()
                ),
                'message' => 'Adicionado com sucesso'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function delete_row()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            $model    = $this->request->data['model'];
            ${$model} = $this->initModel($model);

            if (!${$model}->delete($this->request->data['foreignKey'], true)) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível excluir'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => null,
                'message' => 'Excluído com sucesso'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function add_schedule()
    {
        if ($this->request->is('post') && $this->Auth->loggedIn()) {

            $saved = $this->Schedule->addSchedule($this->request->data['weekDay'], $this->getRadioId());

            if ($saved === false) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => 'Não foi possível inserir sua programação'
                );

                $this->set('response', $response);
                return $this->set('_serialize', array('response'));
            }

            $response = array(
                'status'  => 'success',
                'data'    => $saved,
                'message' => 'Programação inserida com sucesso!'
            );

            $this->set('response', $response);
            return $this->set('_serialize', array('response'));
        }

        throw new BadRequestException(__('Requisição inválida'));
    }

    public function sendMessage()
    {
        if ($this->request->is('post')) {
        
            try {

                $options = array(
                    'template'      => 'radio_top_ten',
                    'subject'       => 'Peça seu som!',
                    'template_vars' => array(
                        'name'  => $this->request->data['name'],
                        'music' => $this->request->data['music']
                    )
                );

                $response = $this->Radio->find('first', array(
                    "conditions" => array('Radio.id' => $this->getRadioId()),
                    "fields" => array("Radio.email")
                ));

                if (!$this->Email->send($response['Radio']['email'], $options)) {
                    throw new RuntimeException('Erro ao enviar email!');
                }

                $response = array(
                    'status'  => 'success',
                    'data'    => null,
                    'message' => 'Email enviado com sucesso!'
                );

            } catch (RuntimeException $e) {
                $response = array(
                    'status'  => 'error',
                    'data'    => null,
                    'message' => $e->getMessage()
                );
            }

            $this->set(compact('response'));
            return $this->set('_serialize', 'response');

        }

        throw new BadRequestException(__('Requisição inválida'));
    }
}
