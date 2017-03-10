<?php // app/Controller/Component/EmailComponent.php

App::uses('Component', 'Controller');

// Component dependecies
App::uses('CakeEmail', 'Network/Email');

/**
 * EmailComponent is a shortcut to send emails with CakeEmail.
 * Will be a reusable code who needs less options to send an email.
 *
 * @version 1.0
 * @author Bernardo Casanova <bernardocasanova@gmail.com>
 * @project Sua Radio na Net
 */
class EmailComponent extends Component {

    public static $DEFAULT_EMAIL_CONFIG = 'EmailComponent';
    public static $DEFAULT_TEMPLATE     = 'radios_default';
    public static $DEFAULT_LAYOUT       = 'radios';
    public static $DEFAULT_SUBJECT      = 'Sua Radio na Net';

    private $controller = null;

    /**
     * Send email to a user.
     *
     * @param string    $to         Email address to send
     * @param array     $options    Send configuration
     *   $options = array(
     *       'subject' => '__ABOUT__',
     *       'template' => '__TEMPLATE__',
     *       'template_layout' => '__TMPL_LAYOUT',
     *       'template_vars' => array(
     *           'content' = '__EMAIL_CONTENT__'
     *       ),
     *       'message' => '__MESSAGE_HTML__'
     *   );
     * @return bool     Success response
     */
    public function send($to, $options = array()) {
        // Validates the email before anything. If it's invalid theres no reason to continue!
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return 'INVALID_EMAIL';
        }

        // Check if the `template` options is set. If it's not set it to default.
        if (!isset($options['template']) || empty($options['template'])) {
            $options['template'] = self::$DEFAULT_TEMPLATE;
        }

        // Check if the `config` options is set. If it's not set it to default.
        if (!isset($options['config']) || empty($options['config'])) {
            $options['config'] = self::$DEFAULT_EMAIL_CONFIG;
        }

        // Check if the `subject` options is set. If it's not set it to default.
        if (!isset($options['subject'])) {
            $options['subject'] = self::$DEFAULT_SUBJECT;
        }

        // Check if the `template_layout` options is set. If it's not set it to default.
        if (!isset($options['template_layout']) || empty($options['template_layout'])) {
            $options['template_layout'] = self::$DEFAULT_LAYOUT;
        }

        // Check if the `template_vars` options is set. If it's not create it.
        if (!isset($options['template_vars']) || empty($options['template_vars'])) {
            $options['template_vars'] = array('content' => '');
        } else {
            if (!isset($options['template_vars']['content'])) {
                $options['template_vars']['content'] = '';
            }
        }

        // Check if the `message` options is set. If it's not create it.
        if (!isset($options['message'])) {
            $options['message'] = '';
        }

        // Contact the message with the content
        $options['template_vars']['content'] .= $options['message'];

        /*--------------------------------------------
        |            Required options
         --------------------------------------------*/

        $Email = new CakeEmail($options['config']);

        $Email->emailFormat('html');
        $Email->template($options['template'], $options['template_layout']);
        $Email->viewVars($options['template_vars']);
        $Email->subject($options['subject']);
        $Email->to($to);

        /*--------------------------------------------
        |            Not required options
         --------------------------------------------*/

        // If carbon copy aka cc is set
        if (isset($options['cc']) && !empty($options['cc'])) {
            $Email->cc($options['cc']);
        }

        return $Email->send();
    }

}
