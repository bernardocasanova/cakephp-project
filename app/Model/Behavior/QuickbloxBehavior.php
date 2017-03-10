<?php
App::uses('ModelBehavior', 'Model');

App::uses('HttpSocket', 'Network/Http');

/**
 * Behavior used to create a room inside our application of
 * Quickblox for the newly created Radio.
 */
class QuickbloxBehavior extends ModelBehavior
{
    private $applicationId       = 24496;
    private $authorizationKey    = 'p4J4HJjAS9cxXwx';
    private $authorizationSecret = 'QNyQDsdx6GH3jZa';

    private $userLogin    = 'w8sdevs';
    private $userPassword = 'w8s79000';

    private $apiEndpoint = 'https://api.quickblox.com';

    private $nonce     = null;
    private $timestamp = null;

    private $roomName = null;

    public function createChatRoom(Model $Model)
    {
        // set up need variables
        $this->nonce     = rand();
        $this->timestamp = time();
        $this->roomName  = 'Sala ' . $Model->data['Radio']['name'];

        // creates the room using the quickblox api
        $response = $this->postRequest('/chat/Dialog.json', $this->buildPostData('room'), $this->getSessionToken());

        // updates the column on the database with the room_jid
        $Model->id = $Model->data['Radio']['id'];

        return $Model->saveField(
            'room_jid',
            $response->xmpp_room_jid,
            array('callbacks' => false, 'validate' => false)
        );
    }

    public function deleteChatRoom(Model $Model)
    {
        // set up need variables
        $this->nonce     = rand();
        $this->timestamp = time();

        // removes the room using the quickblox api
        $response = $this->deleteRequest('/chat/Dialog/' . $this->getRoomId($Model) . '.json', $this->getSessionToken());

        return true;
    }

    private function buildPostData($type = null)
    {
        if ($type == 'room') {
            return http_build_query(
                array(
                    'type' => 1,
                    'name' => $this->roomName
                )
            );
        }

        return http_build_query(
            array(
                'application_id' => $this->applicationId,
                'auth_key'       => $this->authorizationKey,
                'timestamp'      => $this->timestamp,
                'nonce'          => $this->nonce,
                'signature'      => $this->generateSignature(),
                'user[login]'    => $this->userLogin,
                'user[password]' => $this->userPassword
            )
        );
    }

    private function generateSignature()
    {
        return hash_hmac('sha1', $this->generateSignatureString(), $this->authorizationSecret);
    }

    private function generateSignatureString()
    {
        return 'application_id=' . $this->applicationId
             . '&auth_key=' . $this->authorizationKey
             . '&nonce=' . $this->nonce
             . '&timestamp=' . $this->timestamp
             . '&user[login]=' . $this->userLogin
             . '&user[password]=' . $this->userPassword;
    }

    private function getRoomId(Model $Model)
    {
        $result = $Model->find('first', array(
            'conditions' => array('id' => $Model->id)
        ));

        $roomId = $result['Radio']['room_jid'];
        $roomId = str_replace($this->applicationId . '_', '', $roomId);
        $roomId = str_replace('@muc.chat.quickblox.com', '', $roomId);

        return $roomId;
    }

    private function getSessionToken()
    {
        $response = $this->postRequest('/session.json', $this->buildPostData('session'));

        return $response->session->token;
    }

    private function deleteRequest($path = null, $sessionToken = null)
    {
        $HttpSocket = new HttpSocket();

        $response = $HttpSocket->delete(
            $this->apiEndpoint . $path,
            array(),
            array(
                'header' => array(
                    'QB-Token' => $sessionToken
                )
            )
        );

        return json_decode($response->body());
    }

    private function postRequest($path = null, $postData = null, $sessionToken = null)
    {
        $request = array();

        if ($sessionToken !== null) {
            $request['header'] = array(
                'QB-Token' => $sessionToken
            );
        }

        $HttpSocket = new HttpSocket();

        $response = $HttpSocket->post(
            $this->apiEndpoint . $path,
            $postData,
            $request
        );

        return json_decode($response->body());
    }

    public function sendMessage()
    {
        $token = $this->getSessionToken();
        $roomId = $this->getRoomId();

        $attachment = array( array(
            type => 'image', 
            url => 'https://qbprod.s3.amazonaws.com/70a9a896466f44b2b70ee79386e86f3e00', 
            id => 580795
        ));

        $data = array(
            'chat_dialog_id' => $chat_dialog_id,
            'message'        => 'This is a message',
            'attachments'    => (object) $attachment,
        );

        $request = json_encode($data);
    }
}
