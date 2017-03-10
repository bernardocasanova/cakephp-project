<?php
App::uses('Model', 'Model');

class AppModel extends Model
{
    public $actsAs = array(
        'Containable'
    );

    public $recursive = -1;

    public $responseData = array();

    protected function getAcoLabels($aro = array())
    {
        $labels = array();
        foreach ($this->acosInfo as $label => $aco) {
            $labels[] = $label;
        }

        return $labels;
    }

    protected function getAcoParentName()
    {
        return $this->translatedModelName;
    }

    protected function getAcoActionsByLabel($label = null)
    {
        if (!array_key_exists($label, $this->acosInfo)) {
            return array();
        }

        return $this->acosInfo[$label]['actions'];
    }

    protected function getAcoAllowedLabels($id = null)
    {
        $Acl = new AclComponent(new ComponentCollection());
        $Aro = array('model' => 'Group', 'foreign_key' => $id);
        $allowedLabels = array();

        foreach ($this->acosInfo as $label => $aco) {
            $allowed = true;

            foreach ($aco['actions'] as $action) {
                if (!$Acl->check($Aro, 'controllers/' . Inflector::pluralize($this->alias) . '/' . $action)) {
                    $allowed = false;
                }
            }

            if ($allowed) {
                $allowedLabels[] = $label;
            }
        }

        return $allowedLabels;
    }

    protected function initModel($key = null)
    {
        if (!ClassRegistry::isKeySet($key)) {
            return ClassRegistry::init($key);
        }

        return ClassRegistry::getObject($key);
    }

    protected function addModelIdToSession($name = null)
    {
        if (CakeSession::read('Template.create')) {
            if (CakeSession::check('Template.' . $name)) {
                CakeSession::write('Template.' . $name, am(CakeSession::read('Template.' . $name), $this->id));
            } else {
                CakeSession::write('Template.' . $name, $this->id);
            }
        }
    }

/**
 * Returns custom messages to specific actions when the user has no acess to it.
 *
 * @param  string $action the action the user has no access
 *
 * @return string         custom message
 */
    public function permissionMessage($action = null)
    {
        foreach ($this->acosInfo as $label => $infos) {
            if (!in_array($action, $infos['actions'])) continue;

            return $infos['notAllowedMessage'];
        }

        return 'Você não possui permissão para acessar essa página';
    }

    protected function startsWith($haystack, $needle)
    {
        return (substr($haystack, 0, strlen($needle)) === $needle);
    }

/**
 * TODO: put all the code below in a behavior
 */
    public function saveChanges($data = array(), $radioId = null)
    {
        $this->responseData = array();

        if (isset($data['files'])) {
            return $this->changeFile($data, $radioId);
        }

        return $this->changeText($data, $radioId);
    }

    private function changeFile($data = array(), $radioId = null)
    {
        if ($data['action'] == 'delete') {
            return $this->deleteAttachment($data);
        }

        if (!isset($data['foreignKey'])) {
            return false;
        }

        $this->set('id', $data['foreignKey']);

        if(isset($data['is_multiple']) && $data['is_multiple'] == true){
            
            $data = $this->transformRequestDropzone($data);

            if (!$this->save($this->getSaveFileData($data), false)) {
                return false;
            }

        }else{

            if (!$this->save($this->getSaveFileData($data), false)) {
                return false;
            }

        }

        $this->setFileResponseData($data);

        return true;
    }

    public function loadAlbum($data = array(), $radioId = null)
    {
        $album = $this->find('first', array(
            "conditions" => array(
                'Gallery.id'       => $data['foreignKey'],
                'Gallery.radio_id' => $radioId
            ),
            "contain" => array(
                "AttachmentGallery"
            )
        ));
        $this->responseData = $album;
        return !empty($album);
    }

    private function transformRequestDropzone($request)
    {
        $Attachment = ClassRegistry::init('Attachment');

        $lastAttach = $Attachment->find('first', array(
            'conditions' => array(
                'Attachment.model' => $request['model'],
                'Attachment.foreign_key' => $request['foreignKey']
            ),
            'order' => 'Attachment.id DESC'
        ));

        if(!empty($lastAttach)){
            $lastAttach = explode('_', $lastAttach['Attachment']['filename']);
        }else{
            $lastAttach = 0;
        }

        foreach ($request['files']['name'] as $key => $name) {
            $lastAttachKey = intval($lastAttach[1]) + $key + 1;
            $request['files'][$lastAttachKey]['name'] = $name;
        }

        foreach ($request['files']['type'] as $key => $type) {
            $lastAttachKey = intval($lastAttach[1]) + $key + 1;
            $request['files'][$lastAttachKey]['type'] = $type;
        }

        foreach ($request['files']['tmp_name'] as $key => $tmp_name) {
            $lastAttachKey = intval($lastAttach[1]) + $key + 1;
            $request['files'][$lastAttachKey]['tmp_name'] = $tmp_name;
        }

        foreach ($request['files']['error'] as $key => $error) {
            $lastAttachKey = intval($lastAttach[1]) + $key + 1;
            $request['files'][$lastAttachKey]['error'] = $error;
        }

        foreach ($request['files']['size'] as $key => $size) {
            $lastAttachKey = intval($lastAttach[1]) + $key + 1;
            $request['files'][$lastAttachKey]['size'] = $size;
        }

        unset($request['files']['name']);
        unset($request['files']['type']);
        unset($request['files']['tmp_name']);
        unset($request['files']['error']);
        unset($request['files']['size']);

        return $request;
    }

    private function deleteAttachment($data = array())
    {
        $Attachment = ClassRegistry::init('Attachment');

        $result = $Attachment->find('first', array(
            'conditions' => array(
                'type'        => $data['field'],
                'model'       => $data['model'],
                'foreign_key' => $data['foreignKey'],
            )
        ));

        if (empty($result)) {
            return true;
        }

        if (!$Attachment->delete($result['Attachment']['id'])) {
            return false;
        }

        $this->deleteAllFiles($result);

        return true;
    }

    private function getSaveFileData($data = array())
    {
        return array(
            $data['model'] => array(
                $data['field'] => $data['files']
            )
        );
    }

    private function changeText($data = array(), $radioId = null)
    {

        if (isset($data['action']) && $data['action'] == 'update' && $this->exists($data['foreignKey'])) {
            return $this->updateAll(
                $this->getSaveTextData($data, $radioId),
                $this->getSaveTextConditions($data, $radioId)
            );
        }

        if (isset($data['action']) && $data['action'] == 'delete' && $this->exists($data['foreignKey'])) {
            return $this->delete($data['foreignKey']);
        }

        if (isset($data['action']) && $data['action'] == 'create' && isset($data['type']) && $data['type'] == 'fraction'){
            if($this->save($this->createFractionData($data, $radioId), false)){
                $this->responseData = array(
                    'id' => $this->getLastInsertID()
                );
                return true;
            }
        }

        if (isset($data['action']) && $data['action'] == 'create' && isset($data['type']) && $data['type'] == 'promotion'){
            if($this->save($this->createPromotionData($data, $radioId), false)){
                $this->responseData = array(
                    'id' => $this->getLastInsertID()
                );
                return true;
            }
        }

        if (isset($data['action']) && $data['action'] == 'create' && isset($data['type']) && $data['type'] == 'banner'){
            if($this->save($this->createBannerData($data, $radioId), false)){
                $this->responseData = array(
                    'id' => $this->getLastInsertID()
                );
                return true;
            }
        }

        if (isset($data['action']) && $data['action'] == 'create' && isset($data['type']) && $data['type'] == 'script'){
            if($this->save($this->getSaveTextData($data, $radioId), false)){
                $this->responseData = array(
                    'id' => $this->getLastInsertID()
                );
                return true;
            }
        }

        return $this->save($this->getSaveTextData($data, $radioId), false);
    }

    private function createBannerData($data = array(), $radioId = null){
        return array(
            $data['model'] => array(
                'type'     => 'block',
                'position' => $this->getPositionBanner($radioId),
                'radio_id' => $radioId
            ),
        );
    }

    private function getPositionBanner($radioId = null){
        $Banner = ClassRegistry::init('Banner');

        $result = $Banner->find('first', array(
            'conditions' => array(
                'radio_id' => $radioId,
                'type'     => 'block'
            ),
            'order' => 'position DESC'
        ));

        return intval($result['Banner']['position']) + 1;
    }

    private function createPromotionData($data = array(), $radioId = null){
        return array(
            $data['model'] => array(
                'name'         => $data['name'],
                'title'        => $data['title'],
                'description'  => $data['description'],
                'radio_id'     => $radioId
            ),
        );
    }

    private function createFractionData($data = array(), $radioId = null) {
        
        if($data['focus'] == 'eventos'){
            return array(
                $data['model'] => array(
                    'name'  => $data['name'],
                    'hour'  => $data['hour'],
                    'date'  => $data['date'],
                    'local' => $data['local'],
                    'radio_id' => $radioId
                ),
            );
        }

        if($data['focus'] == 'locutores'){
            return array(
                $data['model'] => array(
                    'name'  => $data['name'],
                    'radio_id' => $radioId
                ),
            );
        }

        if($data['focus'] == 'novidades'){
            return array(
                $data['model'] => array(
                    'title'        => $data['title'],
                    'description'  => $data['description'],
                    'radio_id'     => $radioId
                ),
            );
        }
    }

    private function getSaveTextData($data = array(), $radioId = null)
    {
        $saveData = array();

        if ($data['action'] == 'create' && $data['model'] != 'Radio') {
            $saveData['radio_id'] = $radioId;
        }

        if ($data['action'] == 'create') {
            $saveData[$data['field']] = $data['value'];
        }

        if ($data['action'] == 'update' && isset($data['type']) && $data['type'] == 'vote') {

            $Poll = ClassRegistry::init('Poll');

            if($data['field'] == 'question'){
                $db = $this->getDataSource();
                $saveData[$data['model'] . '.' . $data['field']] = $db->value(trim($data['value']), 'string');
                $saveData[$data['model'] . '.' . 'answers'] = $db->value('[0, 0, 0, 0, 0]', 'string');
            }else{
                $options = $Poll->getOptions($data['foreignKey']);
                $options[$data['position']] = str_replace(chr( 194 ) . chr( 160 ), "",$data['value']);
                $options = json_encode($options);

                $db = $this->getDataSource();
                $saveData[$data['model'] . '.' . $data['field']] = $db->value($options);
            }
            
        }elseif ($data['action'] == 'update' && isset($data['type']) && $data['type'] == 'date') {
            
            $Event = ClassRegistry::init('Event');
            
            $date = $Event->find('first', array(
                "conditions" => array("Event.id" => $data['foreignKey']),
            ));

            $date = explode('-', $date['Event']['date']);

            if($data['field'] == 'day'){
                $date[2] = trim($data['value']);
            }

            if($data['field'] == 'month'){
                $date[1] = trim($data['value']);
            }

            $dateFinal = $date[0] . '-' . $date[1] . '-' . $date[2];

            $db = $this->getDataSource();
            $saveData[$data['model'] . '.' . $data['type']] = $db->value($dateFinal, 'date');

        }elseif ($data['action'] == 'update') {
            $db = $this->getDataSource();
            $saveData[$data['model'] . '.' . $data['field']] = $db->value(trim($data['value']), 'string');
        }

        
        
        return $saveData;
    }

    private function getSaveTextConditions($data = array(), $radioId = null)
    {
        if ($data['model'] == 'Radio') {
            return array(
                'Radio.id' => $radioId
            );
        }

        return array(
            $data['model'] . '.id' => $data['foreignKey']
        );
    }

    private function setFileResponseData($data = array())
    {
        $this->responseData = array(
            'files' => array()
        );

        if(isset($data['is_multiple']) && $data['is_multiple'] == true){

            $filenames = $this->getResponseFilename($data['foreignKey'], $data['field'], $data['is_multiple']);
            $thumbs    = $this->getResponseThumbPrefixes($data['field']);

            foreach ($filenames as $keyFilename => $filename) {
                foreach ($thumbs as $keyThumb => $thumb) {
                    $this->responseData['files'][$keyFilename][$thumb] = $this->getResponseUploadsFolder() . $thumb . '.' . $filename['filename'];
                }
            }

        }else{

            $filename = $this->getResponseFilename($data['foreignKey'], $data['field']);
            $thumbs   = $this->getResponseThumbPrefixes($data['field']);

            foreach ($thumbs as $key => $thumb) {
                $this->responseData['files'][$thumb] = $this->getResponseUploadsFolder() . $thumb . '.' . $filename;
            }
        }
    }

    private function getResponseFilename($foreignKey = null, $field = null, $is_multiple = null)
    {
        $attachmentName = 'Attachment' . Inflector::camelize($field);

        $result = $this->find('first', array(
            'conditions' => array(
                $this->alias . '.id' => $foreignKey
            ),
            'contain' => array(
                $attachmentName
            )
        ));

        if(isset($is_multiple) && $is_multiple == true){
            return $result[$attachmentName];
        }else{
            return $result[$attachmentName]['filename'];
        }
        
    }

    private function getResponseThumbPrefixes($field = null)
    {
        $arrayThumbs = $this->actsAs['Attach.Upload'][$field]['thumbs'];

        return array_keys($arrayThumbs);
    }

    private function getResponseUploadsFolder()
    {
        return '/media/uploads/';
    }

    public function getResponseData()
    {
        return $this->responseData;
    }
/**
 * END OF TODO
 */
}
