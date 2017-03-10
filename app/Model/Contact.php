<?php
App::uses('AppModel', 'Model');

class Contact extends AppModel
{
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um nome para contato'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 30),
                'message' => 'O nome para contato não pode conter mais de 30 caracteres'
            )
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe um e-mail para contato'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'O e-mail para contato não pode conter mais de 255 caracteres'
            )
        ),
        'message' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe seu comentário'
            )
        )
    );

    public $belongsTo = array('Radio');

    public function afterSave($created, $options = array())
    {
        $this->sendEmail();
    }

    private function sendEmail()
    {

        $sendTo   = $this->getRadioContactEmail();

        $viewVars = array(
            'contactName'    => $this->data['Contact']['name'],
            'contactEmail'   => $this->data['Contact']['email'],
            'contactMessage' => $this->data['Contact']['message']
        );

        $Email = new CakeEmail('EmailComponent');
        $Email->from($sendTo)
            ->to($sendTo)
            ->subject('Contato via formulário')
            ->template('contact', null)
            ->emailFormat('html')
            ->viewVars($viewVars);
          
        return $Email->send();
    }

    private function getRadioContactEmail()
    {
        $result = $this->Radio->find('first', array(
            'conditions' => array(
                'Radio.id' => $this->data['Contact']['radio_id']
            ),
            'contain' => array(
                'Owner'
            )
        ));

        if (!isset($result['Radio']['email']) || empty($result['Radio']['email'])) {
            return $result['Owner']['email'];
        }

        return $result['Radio']['email'];
    }
}
