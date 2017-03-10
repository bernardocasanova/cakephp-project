<?php
App::uses('AppHelper', 'View/Helper');

class VideoHelper extends AppHelper
{
    private $html = null;

    private $video = array();

    public function show($video = array())
    {
        $this->html  = '';
        $this->video = $video;

        $this->showLink();

        return $this->html;
    }

    private function showLink()
    {
        $this->html .= '<li style="background: url(' . $this->video['thumbnail'] . ') center center; background-size: cover;" class="videoItem" data-foreign-key="'. $this->video['id'] .'">';
        $this->html .= '<a href="' . $this->video['video_id'] . '" data-kind="' . $this->video['type'] . '">';
        $this->html .=     '<img src="' . $this->video['thumbnail'] . '" width="190" height="190" alt="" data-smoothzoom="' . $this->video['video_id'] . '" class="galleryImage" style="opacity: 0;"/>';
        $this->html .= '</a>';
        $this->html .= '<div class="playButton">';
        $this->html .=     '<div>';
        $this->html .=         '<i class="fa fa-play-circle-o fa-3x customColor"></i>';
        $this->html .=     '</div>';
        $this->html .= '</div>';
        $this->html .= '<button class="removeVideo galleryActions customBG"><i class="fa fa-trash-o"></i></button>';
        $this->html .= '</li>';
    }

}