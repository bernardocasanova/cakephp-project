<?php
App::uses('Component', 'Controller');

class NotificationComponent extends Component
{
    private $controller = null;

    public $components = array('Session');

    public static $ELEMENT_FLASH = 'notification/flash';

    public static $TYPE_INFO    = 'info';
    public static $TYPE_SUCCESS = 'success';
    public static $TYPE_ERROR   = 'error';
    public static $TYPE_WARNING = 'warning';

    private $schedule = array();

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings = array());

        $this->_initSession();
    }

    public function initialize(Controller $controller)
    {
        parent::initialize($controller);

        $this->controller = $controller;
    }

    public function startup(Controller $controller)
    {
        parent::startup($controller);

        // Clear the schedule before filter
        $this->schedule = array();
    }

    public function beforeRender(Controller $controller)
    {
        parent::beforeRender($controller);

        // Render all notifications
        $this->controller->Session->setFlash($this->_renderSchedule($this->_getSchedule()), self::$ELEMENT_FLASH);

        // Clear the schedule after render
        $this->_clearSchedule();
    }

    public function flash($type, $message, $timeOut = null)
    {
        switch ($type) {
            case self::$TYPE_INFO:
                $this->_pushNotification($this->_makeFlashScript(self::$TYPE_INFO, $message, $timeOut));
                break;

            case self::$TYPE_SUCCESS:
                $this->_pushNotification($this->_makeFlashScript(self::$TYPE_SUCCESS, $message, $timeOut));
                break;

            case self::$TYPE_ERROR:
                $this->_pushNotification($this->_makeFlashScript(self::$TYPE_ERROR, $message, $timeOut));
                break;

            case self::$TYPE_WARNING:
                $this->_pushNotification($this->_makeFlashScript(self::$TYPE_WARNING, $message, $timeOut));
                break;

            default:
                $this->_pushNotification($this->_makeFlashScript(self::$TYPE_INFO, $message, $timeOut));
        }
    }

    public function redirectAfterFlash($flashOptions = array(), $redirectOptions = array())
    {
        if (!isset($flashOptions['timeOut'])) {
            $flashOptions['timeOut'] = null;
        }

        $this->flash($flashOptions['type'], $flashOptions['message'], $flashOptions['timeOut']);

        $this->controller->redirect($redirectOptions);
    }

    private function _makeFlashScript($type, $message, $timeOut)
    {
        if ($timeOut == null) {
            return 'admin.utils.notification.flash("' . $type . '", "' . $message . '");';
        }

        return 'admin.utils.notification.flash("' . $type . '", "' . $message . '", ' . $timeOut . ');';
    }

    private function _renderSchedule($schedule)
    {
        $html  = '<script type="text/javascript">window.onload = function() {';
        $html .= implode('', $schedule);
        $html .= '};</script>';

        return $html;
    }

    private function _initSession()
    {
        if (!$this->Session->check('NotificationComponent')) {
            $this->Session->write('NotificationComponent.schedule', array());
        }
    }

    private function _pushNotification($notification)
    {
        $schedule = $this->_getSchedule();

        array_push($schedule, $notification);

        $this->Session->write('NotificationComponent.schedule', $schedule);
    }

    private function _getSchedule()
    {
        return $this->Session->read('NotificationComponent.schedule');
    }

    private function _clearSchedule()
    {
        $this->Session->write('NotificationComponent.schedule', array());
    }

}

