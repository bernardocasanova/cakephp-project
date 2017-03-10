<?php
App::uses('AppModel', 'Model');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

App::uses('AclComponent', 'Controller/Component');

class Radio extends AppModel
{
    private $timezones = array(
        '-12:00', '-11:00', '-10:00', '-09:30', '-09:00', '-08:00', '-07:00', '-06:00',
        '-05:00', '-04:30', '-04:00', '-03:30', '-03:00', '-02:00', '-01:00', '+00:00',
        '+01:00', '+02:00', '+03:00', '+03:30', '+04:00', '+04:30', '+05:00', '+05:30',
        '+05:45', '+06:00', '+06:30', '+07:00', '+08:00', '+08:45', '+09:00', '+09:30',
        '+10:00', '+10:30', '+11:00', '+11:30', '+12:00', '+12:45', '+13:00', '+14:00'
    );

    private $states = array(
        "AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA",
        "PB", "PR", "PE", "PI", "RJ", "RN", "RO", "RS", "RR", "SC", "SE", "SP", "TO"
    );

    public $actsAs = array(
        'Quickblox',
        'Attach.Upload' => array(
            'Attach.type' => 'Imagick',
            'logo' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 300,
                        'h' => 170,
                        'crop' => true
                    )
                )
            ),
            'favicon' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 32,
                        'h' => 32,
                        'crop' => true
                    )
                )
            ),
            'about_image' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 350,
                        'h' => 350,
                        'crop' => true
                    )
                )
            ),
            'background' => array(
                'dir' => 'webroot{DS}media{DS}uploads',
                'thumbs' => array(
                    'web' => array(
                        'w' => 350,
                        'h' => 350,
                        'crop' => false
                    )
                )
            )
        )
    );

    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um nome para a rádio'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 100),
                'message' => 'O nome da rádio não pode conter mais de 100 caracteres'
            )
        ),
        'slug' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um slug para a rádio'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'O slug informado já está sendo utilizado por outra rádio'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 150),
                'message' => 'O nome da rádio não pode conter mais de 150 caracteres'
            )
        ),
        'domain' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'O domínio informado já está sendo utilizado por outra rádio',
                'allowEmpty' => true
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 200),
                'message' => 'O nome da rádio não pode conter mais de 200 caracteres'
            )
        )
    );

    public $belongsTo = array(
        'Owner' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        )
    );

    public $hasOne = array(
        'MonthArtist' => array(
            'dependent' => true
        ),
        'Poll' => array(
            'dependent' => true
        )
    );

    public $hasMany = array(
        'Streaming' => array(
            'dependent' => true
        ),
        'TopTen' => array(
            'dependent' => true
        ),
        'Slider' => array(
            'dependent' => true,
            'order' => array('Slider.id DESC')
        ),
        'Announcer' => array(
            'dependent' => true
        ),
        'Banner' => array(
            'dependent' => true
        ),
        'Event' => array(
            'dependent' => true
        ),
        'News' => array(
            'dependent' => true
        ),
        'Promotion' => array(
            'dependent' => true
        ),
        'Schedule' => array(
            'dependent' => true
        ),
        'Contact' => array(
            'dependent' => true
        ),
        'Script' => array(
            'dependent' => true
        ),
        'Video' => array(
            'dependent' => true,
            'order' => array('Video.id DESC')
        ),
        'Gallery' => array(
            'dependent' => true,
            'order' => array('Gallery.id DESC')
        ),
        'User'
    );

    public $hasAndBelongsToMany = array(
        'User'
    );

    protected $translatedModelName = 'Rádio';

    protected $acosInfo = array(
        'Criar' => array(
            'notAllowedMessage' => 'Você não possui permissão para criar as rádios',
            'actions' => array(
                'admin_create',
                'admin_store',
                'admin_streaming_html'
            )
        ),
        'Editar' => array(
            'notAllowedMessage' => 'Você não possui permissão para editar as rádios',
            'actions' => array(
                'admin_edit',
                'admin_update',
                'admin_activate',
                'admin_deactivate',
                'admin_streaming_html'
            )
        ),
        'Excluir' => array(
            'notAllowedMessage' => 'Você não possui permissão para excluir as rádios',
            'actions' => array('admin_destroy')
        ),
        'Visualizar' => array(
            'notAllowedMessage' => 'Você não possui permissão para visualizar as rádios',
            'actions' => array('admin_index')
        )
    );

    private $radioAliases = array(
        'banners', 'sliders', 'galleries', 'configurations'
    );

    public function parentNode()
    {
        return null;
    }

    public function afterSave($created, $options = array())
    {
        if ($created) {
            $this->createRadioAcos();
            $this->grantOwnerPermission();
            $this->createChatRoom();
        }

        $this->addModelIdToSession('radio_id');
    }

    public function beforeDelete($cascade = true)
    {
        if (!$this->deleteChatRoom()) {
            return false;
        }

        $Aco = $this->initModel('Aco');

        $result = $Aco->find('first', array(
            'conditions' => array(
                'alias' => 'radio-' . $this->id
            )
        ));

        if (empty($result)) {
            return true;
        }

        $conditions = array(
            'OR' => array(
                'AND' => array(
                    'alias'     => $this->radioAliases,
                    'parent_id' => $result['Aco']['id']
                ),
                'id' => $result['Aco']['id']
            )
        );

        if (!$Aco->deleteAll($conditions)) {
            return false;
        }

        return true;
    }

    public function beforeValidate($options = array())
    {
        if (isset($this->data['Radio']['template'])) {
            CakeSession::delete('Template');
            CakeSession::write('Template.create', true);

            $this->addTemplateData();

            if (!$this->createThemeFile()) {
                return false;
            }

            return true;
        }

        return true;
    }

/**
 * Add the data needed on the attachments table, after creating a Radio with a
 * template data. Also delete the Template Session.
 */
    public function addAttachments($template = null)
    {
        $templateData = $this->getTemplateData($template);

        $attachData   = $templateData['Attach'];
        $attachData   = $this->getForeignKeysOnSession($attachData);

        $Attach = $this->initModel('Attachment');
        $Attach->saveAll($attachData);

        CakeSession::delete('Template');
    }

/**
 * Delete all streamings removed on the admin panel.
 */
    public function deleteRemovedStreamings()
    {
        $notRemovedStreamings = array();

        foreach ($this->data['Streaming'] as $streaming) {
            if (!isset($streaming['id'])) continue;

            $notRemovedStreamings[] = $streaming['id'];
        }

        $this->Streaming->deleteAll(array(
            'Streaming.id !='    => $notRemovedStreamings,
            'Streaming.radio_id' => $this->data['Radio']['id']
        ), true);
    }

    public function getSlugByHost($host = null, $mainDomain = null)
    {
        if (strpos($host, $mainDomain) !== FALSE) {
            return $this->getBySubdomain($host, $mainDomain);
        }

        return $this->getByDomain($host, $mainDomain);
    }

    private function getBySubdomain($host = null, $mainDomain = null)
    {
        $subdomain = substr( env("HTTP_HOST"), 0, strpos(env("HTTP_HOST"), ".") );

        $result = $this->find('first', array(
            'fields'     => 'slug',
            'conditions' => array('slug' => $subdomain)
        ));

        if (empty($result)) {
            header("Location: http://" . $mainDomain);
            die;
        }

        return $result[$this->alias]['slug'];
    }

    private function getByDomain($host = null, $mainDomain = null)
    {
        if (strpos($host, 'www.') !== FALSE) {
            $host = str_replace('www.', '', $host);
        }

        $result = $this->find('first', array(
            'fields'     => 'slug',
            'conditions' => array('domain' => $host)
        ));

        if (empty($result)) {
            header("Location: http://" . $mainDomain);
            die;
        }

        return $result[$this->alias]['slug'];
    }

/**
 * Add the template data to populate the tables with some content.
 */
    private function addTemplateData()
    {
        $templateData = $this->getTemplateData($this->data['Radio']['template']);

        unset($templateData['Attach']);
        unset($templateData['Theme']);

        $this->data = array_merge_recursive($this->data, $templateData);
    }

/**
 * Returns the template data by its name.
 *
 * @param  string $templateName the template name
 *
 * @return array                the template data
 */
    private function getTemplateData($templateName = null)
    {
        $templateDir  = WWW_ROOT . DS . 'admin' . DS . 'templates' . DS;
        $templateFile = (is_null($templateName)) ? 'default.json' : $templateName . '.json';

        $file = new File($templateDir . $templateFile);

        return json_decode($file->read(), true);
    }

/**
 * Translate the foreign_key name to its correct ID previously saved on the Session.
 *
 * @param  array  $attachData the data on the template
 *
 * @return array              the attach data after translate the foreign keys
 */
    private function getForeignKeysOnSession($attachData = array())
    {
        foreach ($attachData as $key => $data) {
            $attachData[$key]['foreign_key'] = CakeSession::read('Template.' . $attachData[$key]['foreign_key']);
        }

        return $attachData;
    }

/**
 * This method will created all aliases needed for each radio created.
 */
    private function createRadioAcos()
    {
        $Aco = $this->initModel('Aco');

        $radioAco = array(
            'alias'     => 'radio-' . $this->id,
            'parent_id' => 1
        );

        $Aco->save($radioAco);

        $acos       = array();
        $radioAcoId = $Aco->id;

        foreach ($this->radioAliases as $key => $alias) {
            $acos[] = array(
                'alias'     => $alias,
                'parent_id' => $radioAcoId
            );
        }

        $Aco->saveAll($acos);
    }

/**
 * Grant Acl permissions to the owner of the radio so he can have full access to his radio.
 */
    private function grantOwnerPermission()
    {
        $Acl = new AclComponent(new ComponentCollection());
        $Acl->allow(array('model' => 'User', 'foreign_key' => $this->data['Radio']['user_id']), 'radio-' . $this->data['Radio']['id']);
    }

/**
 * Create the theme file using the theme.css as base file, changing its values
 * depending on the template data.
 *
 * @return boolean  true if successfull false if not
 */
    private function createThemeFile()
    {
        // read the theme
        $file  = new File(APP . WEBROOT_DIR . DS . 'admin/templates/theme.css');
        $theme = $file->read(true, 'r');

        // update the theme
        $theme = $this->setValues($theme);

        // save the new file
        $fileName = md5(uniqid(rand())) . '.css';
        $newTheme = new File($this->themeFolder() . $fileName, true);

        if (!$newTheme->write($theme)) {
            return false;
        }

        // may need this when updating values
        // if (!$this->deleteThemeFile($this->data[$this->alias]['id'])) {
        //     return false;
        // }

        $this->data[$this->alias]['theme_file'] = $fileName;

        return true;
    }

/**
 * Set the values for the theme css.
 *
 * @param string $theme  the update css theme
 */
    private function setValues($theme)
    {
        $templateData = $this->getTemplateData($this->data['Radio']['template']);

        $theme = str_replace('main_color', $templateData['Theme']['main_color'], $theme);

        return $theme;
    }

/**
 * Returns the path to the folder where the themes will be saved.
 *
 * @return  string  path to the folder
 */
    private function themeFolder()
    {
        return APP . WEBROOT_DIR . DS . 'css/radio/';
    }

/**
 * Update visitors count by a certain value and returns its updated value.
 *
 * @param  integer $radioId          the radio id
 * @param  integer $updateBy         the value to increment
 *
 * @return integer $updatedVisitors  the updated value
 */
    public function updateVisitors($radioId = null, $updateBy = 1)
    {
        if (!is_int($updateBy)) {
            $updateBy = 1;
        }

        $result = $this->find('first', array(
            'conditions' => array('id' => $radioId),
            'fields'     => array('visitors')
        ));

        $updatedVisitors = $result[$this->alias]['visitors'] + $updateBy;

        $this->id = $radioId;
        if (!$this->saveField('visitors', $updatedVisitors)) {
            return $result[$this->alias]['visitors'];
        }

        return $updatedVisitors;
    }

    public function getTimezones()
    {
        return $this->timezones;
    }

    public function getStates()
    {
        return $this->states;
    }

    public function updateMainColor($mainColor = null, $radioId = null)
    {
        // read the theme
        $file  = new File(APP . WEBROOT_DIR . DS . 'admin/templates/theme.css');
        $theme = $file->read(true, 'r');

        // update the theme
        $theme = str_replace('main_color', $mainColor, $theme);

        // saves the theme
        $fileName = md5(uniqid(rand())) . '.css';
        $newTheme = new File($this->themeFolder() . $fileName, true);

        if (!$newTheme->write($theme)) {
            return false;
        }

        if (!$this->deleteOldThemeFile($radioId)) {
            return false;
        }

        return $this->updateAll(
            array('Radio.theme_file' => "'$fileName'"),
            array('Radio.id' => $radioId)
        );
    }

    private function deleteOldThemeFile($radioId = null)
    {
        $result = $this->find('first', array(
            'conditions' => array(
                'Radio.id' => $radioId
            ),
            'fields' => array('theme_file')
        ));

        return unlink($this->themeFolder() . $result['Radio']['theme_file']);
    }
}
