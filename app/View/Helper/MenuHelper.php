<?php
App::uses('AppHelper', 'View/Helper');

class MenuHelper extends AppHelper
{
    public function isActive($controller = null)
    {
        if ($this->request->params['controller'] == $controller) {
            return true;
        }

        return false;
    }

    public function isOpened($controllers = array())
    {
        if (in_array($this->request->params['controller'], $controllers)) {
            return true;
        }

        return false;
    }

}
