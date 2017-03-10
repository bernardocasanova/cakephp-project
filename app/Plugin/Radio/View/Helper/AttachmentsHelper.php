<?php
App::uses('AppHelper', 'View/Helper');

class AttachmentsHelper extends AppHelper
{
    private $html = null;

    private $data = array();

    private $options = array();

    public function show($options = array())
    {
        $defaults = array(
            'debug'         => false,
            'noLink'        => false,
            'daBanner'      => false,
            'loggedIn'      => false,
            'alwaysShow'    => false,
            'thumbPrefix'   => 'web.',
            'uploadsFolder' => '/media/uploads/'
        );

        $this->options = array_merge($defaults, $options);
        $this->html    = '';
        $this->data    = isset($options['data']) ? $options['data'] : false;

        $attachmentSource = $this->getAttachmentSource();

        if ($attachmentSource === false) {
            return $this->html;
        }

        $this->startDiv();
            $this->addImage($attachmentSource);
        $this->endDiv();

        if ($this->options['debug']) {
            return debug($this->html);
        }

        return $this->html;
    }

    private function getAttachmentSource()
    {
        if ($this->data === false) {
            return 'http://placehold.it/' . $this->options['width'] . 'x' . $this->options['height'];
        }

        $attachmentLabel = $this->getAttachmentLabel();

        if (isset($this->data[$attachmentLabel]['filename']) && !empty($this->data[$attachmentLabel]['filename'])) {
            return $this->options['uploadsFolder'] . $this->getAttachmentFilename();
        }

        if ($this->options['loggedIn'] || $this->options['alwaysShow']) {
            return 'http://placehold.it/' . $this->options['width'] . 'x' . $this->options['height'];
        }

        return false;
    }

    private function getAttachmentLabel()
    {
        return 'Attachment' . Inflector::camelize($this->options['field']);
    }

    private function getAttachmentFilename()
    {
        $attachmentLabel = $this->getAttachmentLabel();

        if (strpos($this->data[$attachmentLabel]['filename'], 'templates/') !== false) {
            $dirname  = dirname($this->data[$attachmentLabel]['filename']);
            $basename = basename($this->data[$attachmentLabel]['filename']);

            if(pathinfo($this->data[$attachmentLabel]['filename'], PATHINFO_EXTENSION) == "gif"){
                return $dirname . '/' . $basename;
            }

            return $dirname . '/' . $this->options['thumbPrefix'] . $basename;
        }
        
        if(pathinfo($this->data[$attachmentLabel]['filename'], PATHINFO_EXTENSION) == "gif"){
            return $this->data[$attachmentLabel]['filename'];
        }

        return $this->options['thumbPrefix'] . $this->data[$attachmentLabel]['filename'];
    }

    public function fixFilename($attachment = array(), $prefix = null)
    {
        if (strpos($attachment, 'templates/') !== false) {
            $dirname  = dirname($attachment);
            $basename = basename($attachment);

            return $dirname . '/' . $prefix . $basename;
        }

        return $prefix . $attachment;
    }

    private function startDiv()
    {
        $this->html .= '<div class="dense d' . $this->options['width'] . '-' . $this->options['height'] . ' customColor';

        if ($this->options['noLink']) {
            $this->html .= ' no-link';
        }

        if ($this->options['daBanner']) {
            $this->html .= ' daBanner';
        }

        if ($this->options['loggedIn']) {
            $this->html .= '" data-adwidth="' . $this->options['width'];
            $this->html .= '" data-adheight="' . $this->options['height'];
            $this->html .= '" data-model="' . $this->options['model'];
            $this->html .= '" data-field="' . $this->options['field'];
            $this->html .= '" data-foreign-key="' . $this->options['foreignKey'];
        }

        $this->html .= '">';
    }

    private function addImage($source = null)
    {
        if (isset($this->options['link']) && !empty($this->options['link'])) {
            $this->html .= '<a href="' . $this->options['link'] . '" target="_blank">';
        }

        $this->html .= '<img src="' . $source . '" alt="">';

        if (isset($this->options['link']) && !empty($this->options['link'])) {
            $this->html .= '</a>';
        }
    }

    private function endDiv()
    {
        if ($this->options['field'] == 'block') {
            if($this->options['loggedIn']) {
                $this->html .= '<button class="deleteBlock customBG" data-model="Banner" data-foreign-key="16"><i class="fa fa-trash-o"></i></button>';
            }
        }
        $this->html .= '</div>';
    }
}
