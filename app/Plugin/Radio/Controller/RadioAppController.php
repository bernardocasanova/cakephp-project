<?php
App::uses('AppController', 'Controller');

class RadioAppController extends AppController
{
    public $components = array(
        'Auth' => array(
            'authError'    => 'Você não possui permissão para acessar essa página',
            'loginError'   => 'Seu login e/ou senha estão incorretos',
            'authorize'    => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email'),
                    'scope'  => array('status' => 1, 'group_id' => array(1, 3))
                )
            )
        )
    );

    private $radioId = null;

    public function beforeFilter()
    {
        $this->setRadioConfigurationsBySlug($this->params['radioSlug']);

        // // HTTPS Redirect
        // $result = $this->HttpsRedirect->check($this->request);

        // if (!is_bool($result)) {
        //     return $this->redirect($this->checkForStage($result));
        // }
        
        $this->initManagerAuth();
    }   

    private function setRadioConfigurationsBySlug($slug = null)
    {
        $Radio  = $this->initModel('Radio');
        $Banner = $this->initModel('Banner');

        $radio = $Radio->find('first', array(
            'conditions' => array(
                'Radio.slug' => $slug
            ),
            'contain' => array(
                'AttachmentLogo',
                'AttachmentFavicon',
                'AttachmentBackground',
                'AttachmentAboutImage',
                'Slider' => array(
                    'AttachmentSlider'
                ),
                'MonthArtist' => array(
                    'AttachmentMonthArtist'
                ),
                'Announcer' => array(
                    'AttachmentAnnouncer'
                ),
                'Event' => array(
                    'AttachmentEvent'
                ),
                'News' => array(
                    'AttachmentNew',
                    'order' => 'id DESC'
                ),
                'Promotion' => array(
                    'AttachmentPromotion',
                    'order' => 'id DESC'
                ),
                'Gallery' => array(
                    'AttachmentGallery'
                ),
                'Owner',
                'Poll',
                'Streaming',
                'TopTen',
                'Video',
                'Script'
            )
        ));

        if (!$radio['Owner']['status'] || !$radio['Radio']['status']) {
            throw new CakeException(__('A rádio ' . $radio['Radio']['name'] . ' está desativada'));
        }
        
        $this->set('radio', $radio);
        $this->setRadioId($radio['Radio']['id']);
    }

    private function initManagerAuth()
    {
        AuthComponent::$sessionKey = 'Auth.Manager.' . $this->getRadioId();

        $this->Auth->loginAction = array(
            'controller' => 'users',
            'action'     => 'login',
            'plugin'     => 'radio',
            'radioSlug'  => $this->params['radioSlug']
        );

        $this->Auth->logoutRedirect = array(
            'controller' => 'pages',
            'action'     => 'home',
            'plugin'     => 'radio',
            'radioSlug'  => $this->params['radioSlug']
        );

        $this->Auth->loginRedirect = array(
            'controller' => 'pages',
            'action'     => 'home',
            'plugin'     => 'radio',
            'radioSlug'  => $this->params['radioSlug']
        );

        $this->Auth->allow();
    }

    private function setRadioId($id)
    {
        $this->radioId = $id;
    }

    protected function getRadioId()
    {
        return $this->radioId;
    }

    protected function isProduction()
    {
        return Configure::read('debug') == 2 ? false : true;
    }

}
