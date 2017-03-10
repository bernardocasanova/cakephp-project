<?php
App::uses('AppHelper', 'View/Helper');

class ButtonsHelper extends AppHelper
{
    public $helpers = array('Html');

    private $modelName;
    private $useModelName;
    private $record;
    private $id;

    public function add($options = array())
    {
        $html = '';

        if (empty($options) || !is_array($options)) {
            return $html;
        }

        $html .= '<div class="add-new-model row">';
        $html .=    '<div class="col-sm-12">';

        foreach ($options as $label => $opt) {
            $url = Router::url(array(
                'controller' => $opt['controller'],
                'action'     => $opt['action'],
                'prefix'     => $this->params['prefix'],
                'tenantSlug' => $this->params['tenantSlug']
            ), true);

            $btnClass  = (isset($opt['btnClass'])) ? $opt['btnClass'] : 'btn-green';
            $iconClass = (isset($opt['iconClass'])) ? $opt['iconClass'] : 'entypo-plus';

            $html .= '<a href="' . $url . '" class="btn btn-icon icon-left ' . $btnClass . '">';
            $html .=    '<i class="' . $iconClass . '"></i> ' . $label;
            $html .= '</a> '; // this blank space is important indeed
        }

        $html .=    '</div>';
        $html .= '</div>';

        return $html;
    }

/**
 * Build the action buttons based on the array passed.
 *
 * @param   array   $record        the record data
 * @param   array   $buttons       a multidimensional array with the types of buttons and its options
 * @param   boolean $useModelName  use or not the model name to get record data
 *
 * @return  string  return the html for the buttons
 */
    public function actions($record, $buttons = array(), $useModelName = true)
    {
        if (empty($buttons)) {
            return '';
        }

        $models = $this->params['models'];
        $this->modelName    = key($models); // get the first model name
        $this->useModelName = $useModelName;
        $this->id           = ($this->useModelName) ? $record[$this->modelName]['id'] : $record['id'];

        return $this->createButtons($buttons);
    }

/**
 * Handle with the creation of buttons, calling the correct function for
 * each button and setting its options.
 *
 * @param  array  $buttons the array with the buttons and its options
 *
 * @return string $html    the html with the buttons
 */
    private function createButtons($buttons = array())
    {
        $html = '';

        foreach ($buttons as $key => $value) {

            if (is_array($value)) {
                $call  = '_' . $key . 'Button';
                $html .= ' ' . $this->$call($value);
            } else {
                $call  = '_' . $value . 'Button';
                $html .= ' ' . $this->$call();
            }
        }

        return $html;
    }

/**
 * Build the profile button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _profileButton($options = array())
    {
        $action = $this->setAction('show', $options);

        return $this->Html->link(
            // Title
            '<i class="entypo-info"></i>',

            // URL
            Router::url(array(
                'controller' => $this->params['controller'],
                'action'     => $action,
                'prefix'     => $this->params['prefix'],
                'tenantSlug' => $this->params['tenantSlug'],
                $this->id
            ), true),

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-info btn-xs'
            )
        );
    }

/**
 * Build the view button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _viewButton($options = array())
    {
        $action = $this->setAction('view', $options);

        return $this->Html->link(
            // Title
            '<i class="entypo-eye"></i>',

            // URL
            Router::url(array(
                'controller' => $this->params['controller'],
                'action'     => $action,
                'prefix'     => $this->params['prefix'],
                'tenantSlug' => $this->params['tenantSlug'],
                $this->id
            ), true),

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-info btn-xs'
            )
        );
    }

/**
 * Build the edit button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _editButton($options = array())
    {
        $action = $this->setAction('edit', $options);

        return $this->Html->link(
            // Title
            '<i class="entypo-pencil"></i>',

            // URL
            Router::url(array(
                'controller' => $this->params['controller'],
                'action'     => $action,
                'prefix'     => $this->params['prefix'],
                'tenantSlug' => $this->params['tenantSlug'],
                $this->id
            ), true),

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-default btn-xs'
            )
        );
    }

/**
 * Build the delete button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _deleteButton($options = array())
    {
        $action = $this->setAction('destroy', $options);

        $url = Router::url(array(
            'controller' => $this->params['controller'],
            'action'     => $action,
            'prefix'     => $this->params['prefix'],
            'tenantSlug' => $this->params['tenantSlug'],
            $this->id
        ), true);

        return $this->Html->link(
            // Title
            '<i class="entypo-trash"></i>',

            // URL
            '#',

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-danger btn-xs btn-delete-' . str_replace('_', '-', $this->params['controller']),
                'data-action-uri' => $url
            )
        );
    }

/**
 * Build the activate button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _activateButton($options = array())
    {
        $action = $this->setAction('activate', $options);

        $url = Router::url(array(
            'controller' => $this->params['controller'],
            'action'     => $action,
            'prefix'     => $this->params['prefix'],
            'tenantSlug' => $this->params['tenantSlug'],
            $this->id
        ), true);

        return $this->Html->link(
            // Title
            '<i class="entypo-check"></i>',

            // URL
            '#',

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-success btn-xs btn-activate-' . str_replace('_', '-', $this->params['controller']),
                'data-action-uri' => $url
            )
        );
    }

/**
 * Build the deactivate button.
 *
 * @param   array   $options  options to build the button
 *
 * @return  string  the html for the button
 */
    private function _deactivateButton($options = array())
    {
        $action = $this->setAction('deactivate', $options);

        $url = Router::url(array(
            'controller' => $this->params['controller'],
            'action'     => $action,
            'prefix'     => $this->params['prefix'],
            'tenantSlug' => $this->params['tenantSlug'],
            $this->id
        ), true);

        return $this->Html->link(
            // Title
            '<i class="entypo-block"></i>',

            // URL
            '#',

            // Options
            array(
                'escape' => false,
                'class'  => 'btn btn-warning btn-xs btn-deactivate-' . str_replace('_', '-', $this->params['controller']),
                'data-action-uri' => $url
            )
        );
    }

/**
 * Generate the new name for the action based on the suffix and prefix set.
 *
 * @param   string  $action  the inital value for the action
 * @param   array   $options the array with the prefix and suffix
 *
 * @return  string  $action  the action for the button
 */
    private function setAction($action, $options = array())
    {
        if (isset($options['actionPrefix']) && !empty($options['actionPrefix'])) {
            $action = $options['actionPrefix'] . $action;
        }

        if (isset($options['actionSuffix']) && !empty($options['actionSuffix'])) {
            $action = $action . $options['actionSuffix'];
        }

        return $action;
    }
}
