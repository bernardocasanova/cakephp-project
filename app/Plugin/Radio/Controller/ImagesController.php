<?php
App::uses('RadioAppController', 'Radio.Controller');

class ImagesController extends RadioAppController
{
    public function resize()
    {

        // $file = $this->params['size']
        // $path = $this->params['path']
        // $size = $this->params['size'];

        $file = 'sidebar_20.gif';
        $path = 'media/uploads';
        $size = '50x50';

        $aspect = false;
        $resizedHeight = $resizedWidth = 0;

        // $size = 100; (Proportional - 100 as height or width whichever is longer)
        if (ereg('^([1-9]+[0-9]*)$', $size))
        {
            $aspect = 'p';
            $resizedHeight = $resizedWidth = $size;
        }
        /**
         * $size = 100:h; (Proportional - 100 as height)
         * $size = 100:s; (Square/crop - 100 as height and width)
         * $size = 100:w; (Proportional - 100 as width)
         */
        else if (ereg('^([1-9]+[0-9]*:[h|s|w]+)$', $size))
        {
            list($dimension, $aspect) = explode(':', $size);

            if ('w' == $aspect)
            {
                $resizedHeight = $dimension;
            }
            else if ('h' == $aspect)
            {
                $resizedWidth = $dimension;
            }
        }
        // $size = 100x150; (Exact [not proportional and no cropping] - 100 as width and 150 as height)
        else if (ereg('^([1-9]+[0-9]*x[1-9]+[0-9]*)$', $size))
        {
            list($resizedWidth, $resizedHeight) = explode('x', $size);
        }

        $original = WWW_ROOT . $path . DS . $file;
        $resized = WWW_ROOT . $path . DS . $size . DS . $file;

        list($originalWidth, $originalHeight, $originalType) = getimagesize($original);

        $clipX = $clipY = 0;

        if (false !== $aspect)
        {
            if ('h' == $aspect)
            {
                $ratio = ($originalHeight / $resizedHeight);
            }
            else if ('p' == $aspect)
            {
                $ratio = (max($originalWidth, $originalHeight) / $resizedWidth);
            }
            else if ('s' == $aspect)
            {
                $ratio = (min($originalWidth, $originalHeight) / $resizedWidth);
            }
            else if ('w' == $aspect)
            {
                $ratio = ($originalWidth / $resizedWidth);
            }

            $ratio = max($ratio, 1);

            if ('s' == $aspect)
            {
                $resizedHeight = $resizedWidth = (int)(min($originalWidth, $originalHeight) / $ratio);

                if ($originalHeight > $originalWidth)
                {
                    $clipY = (int)(($originalHeight - $originalWidth) / 2);
                    $originalHeight = $originalWidth;
                }
                else if ($originalWidth > $originalHeight)
                {
                    $clipX = (int)(($originalWidth - $originalHeight) / 2);
                    $originalWidth = $originalHeight;
                }
            }
            else
            {
                $resizedWidth = (int)($originalWidth / $ratio);
                $resizedHeight = (int)($originalHeight / $ratio);
            }
        }
        else
        {
            if ($resizedWidth > $originalWidth)
            {
                $resizedWidth = $originalWidth;
            }

            if ($resizedHeight > $originalHeight)
            {
                $resizedHeight = $originalHeight;
            }
        }

        // If both width and height are same as original width and original height
        if ($resizedWidth == $originalWidth && $resizedHeight == $originalHeight)
        {
            copy($original, $resized);
        }
        else
        {
            $types = array(1 => 'gif', 'jpeg', 'png');
            $image = call_user_func('imagecreatefrom' . $types[$originalType], $original);

            if (function_exists('imagecreatetruecolor') && ($temp = imagecreatetruecolor($resizedWidth, $resizedHeight)))
            {
                debug(imagecreatetruecolor($resizedWidth, $resizedHeight));
                debug($temp);
                debug($image);
                debug($clipX);
                debug($clipY);
                debug($resizedWidth);
                debug($resizedHeight);
                debug($originalHeight);
                debug($originalWidth);
                imagecopyresampled($temp, $image, 0, 0, $clipX, $clipY, $resizedWidth, $resizedHeight, $originalWidth, $originalHeight);
            }
            else
            {
                $temp = imagecreate($resizedWidth, $resizedHeight);
                imagecopyresized($temp, $image, 0, 0, $clipX, $clipY, $resizedWidth, $resizedHeight, $originalWidth, $originalHeight);
            }

            call_user_func('image' . $types[$originalType], $temp, $resized);
        }
    }
}