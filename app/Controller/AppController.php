<?php
App::uses('Controller', 'Controller');

class AppController extends Controller
{
    public $components = array(
        'Session',
        'Notification',
        'Acl',
        'Auth' => array(
            'authError'    => 'Você não possui permissão para acessar essa página',
            'loginError'   => 'Seu login e/ou senha estão incorretos',
            'authorize'    => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email'),
                    'scope'  => array('status' => 1, 'group_id' => 1)
                )
            )
        ),
        // 'DebugKit.Toolbar'
    );

    public $helpers = array(
        'Menu',
        'Buttons',
        'Status'
    );

    public function beforeFilter()
    {

        if (isset($this->request->params['admin'])) {
            $this->verifyAccess();

            $this->layout = 'admin';

            $this->set('authenticatedUser', $this->Session->read('Auth.Admin'));
        }

        $this->initAdminAuth();
    }

    private function verifyAccess()
    {
        if ($this->Session->read('Auth.Admin') && !$this->actionAllowed()) {
            $model    = Inflector::classify($this->params['controller']);
            ${$model} = $this->initModel($model);

            $this->Notification->flash('error', ${$model}->permissionMessage($this->request->params['action']));
            $this->redirect($this->referer());
        }
    }

    protected function actionAllowed()
    {
        return $this->Acl->check(
            array('model' => 'User', 'foreign_key' => $this->Session->read('Auth.Admin.id')),
            'controllers/' . $this->request->params['controller'] . '/' . $this->request->params['action']
        );
    }

    private function initAdminAuth()
    {
        if (isset($this->request->params['admin'])) {
            AuthComponent::$sessionKey = 'Auth.Admin';

            $this->Auth->loginAction = array(
                'controller' => 'users',
                'action'     => 'login',
                'admin'      => true
            );

            $this->Auth->loginRedirect = array(
                'controller' => 'users',
                'action'     => 'index',
                'admin'      => true
            );

            $this->Auth->allow(array(
                'admin_attempt'
            ));
        }
    }

/**
 * If the model validations has errors, use the Notification
 * component to show the messages.
 *
 * @param  Model  $model the model to be validated
 * @param  array  $url   the url to be redirected
 */
    protected function modelValidations(Model $model, $url = array())
    {
        if (!$model->validates()) {
            $this->notifyValidationErrors($model);
            $this->redirect($url);
        }
    }

/**
 * Use the Notification component to show the messages.
 *
 * @param  Model  $model the model that has errors
 */
    private function notifyValidationErrors(Model $model)
    {
        foreach ($model->validationErrors as $field => $messages) {
            foreach ($messages as $message) {
                $this->Notification->flash('error', $message, 5000);
            }
        }
    }

    protected function initModel($key = null)
    {
        if (!ClassRegistry::isKeySet($key)) {
            return ClassRegistry::init($key);
        }

        return ClassRegistry::getObject($key);
    }

}
