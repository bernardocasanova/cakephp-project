<?php
App::uses('AppModel', 'Model');

App::uses('HttpSocket', 'Network/Http');

class Video extends AppModel
{
    public $validate = array(
        'url' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe uma url para o vídeo'
            )
        ),
        'type' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um tipo para o vídeo'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $result) {
            $results[$key]['Video']['video_id']  = $this->getVideoId($results[$key]['Video']);
            $results[$key]['Video']['thumbnail'] = $this->getVideoThumbnail($results[$key]['Video']);
        }

        return $results;
    }

    private function getVideoId($result = array())
    {
        if (isset($result['type'])) {
            if ($result['type'] == 'youtube') {
                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $result['url'], $matches);
                return $matches[1];
            }

            if ($result['type'] == 'vimeo') {
                preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $result['url'], $matches);
                return $matches[5];
            }

            return false;
        }

        return false;
    }

    private function getVideoThumbnail($result = array())
    {
        if (isset($result['type'])) {
            if ($result['type'] == 'youtube') {
                return 'http://img.youtube.com/vi/' . $result['video_id'] . '/maxresdefault.jpg';
            }

            if ($result['type'] == 'vimeo') {
                $HttpSocket = new HttpSocket();
                $response   = $HttpSocket->get('http://vimeo.com/api/v2/video/' . $result['video_id'] . '.json')->body;
                $response   = json_decode($response);

                if (empty($response)) {
                    return 'http://placehold.it/125x125';
                }

                return $response[0]->thumbnail_large;
            }

            return 'http://placehold.it/125x125';
        }

        return 'http://placehold.it/125x125';
    }
}
