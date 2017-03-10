<?php
App::uses('AppModel', 'Model');

class Banner extends AppModel
{
    public $actsAs = array(
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'block' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 300,
                        'h' => 300,
                        'crop' => true
                    )
                )
            ),
            'sidebar' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 250,
                        'h' => 250,
                        'crop' => true
                    )
                )
            ),
            'gallery' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 468,
                        'h' => 60,
                        'crop' => true
                    )
                )
            ),
            'footer' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 728,
                        'h' => 90,
                        'crop' => true
                    )
                )
            ),
            'header' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 468,
                        'h' => 60,
                        'crop' => true
                    )
                )
            )
        )
    );

    public $validate = array(
        'type' => array(
            'maxLength' => array(
                'rule' => array('maxLength', '20'),
                'message' => 'O tipo deve conter no máximo 20 caracteres'
            )
        ),
        'position' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'A posição não deve ser deixada em branco'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        if (isset($this->data[$this->alias]['type'])) {
            $this->addModelIdToSession('banner_id.' . $this->data[$this->alias]['type']);
        }
    }

    public function getAllBanners($radioId = null)
    {
        $results = $this->find('all', array(
            'conditions' => array(
                'Banner.radio_id' => $radioId
            ),
            'contain' => array(
                'AttachmentBlock',
                'AttachmentSidebar',
                'AttachmentGallery',
                'AttachmentFooter',
                'AttachmentHeader'
            ),
            'order' => array('Banner.id')
        ));

        $banners = $this->groupBannersByType($results);

        return $banners;
    }

    private function groupBannersByType($results = array())
    {
        $banners = array();

        foreach ($results as $key => $result) {
            if (in_array($result[$this->alias]['type'], array('sidebar', 'block'))) {
                $banners[$result[$this->alias]['type']][] = $result;
                continue;
            }

            $banners[$result[$this->alias]['type']] = $result;
        }

        return $banners;
    }
}
