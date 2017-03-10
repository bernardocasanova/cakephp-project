<?php
App::uses('AppModel', 'Model');

class Poll extends AppModel
{
    public $belongsTo = array('Radio');

    public function computeAnswer($option = array(), $radioId = null)
    {
        $answers = $this->getAnswers($radioId);
        $answers[$option]++;

        return $this->updateAll(
            array($this->alias . '.answers' => "'" . json_encode($answers) . "'"),
            array($this->alias . '.radio_id' => $radioId)
        );
    }

    public function getOptions($radioId = null)
    {
        $result = $this->find('first', array(
            'conditions' => array('radio_id' => $radioId)
        ));

        return json_decode($result['Poll']['options'], true);
    }

    public function getAnswers($radioId = null)
    {
        $result = $this->find('first', array(
            'conditions' => array('radio_id' => $radioId)
        ));

        return json_decode($result['Poll']['answers'], true);
    }

    public function getAnswersPercentageHtml($radioId = null)
    {
        $options     = $this->getOptions($radioId);
        $answers     = $this->getAnswers($radioId);
        $percentages = $this->getAnswersPercentages($radioId, $answers);

        $html = '';

        foreach ($percentages as $key => $percentage) {
            $html .= '<div>';
            $html .= '    <span>' . $options[$key] . ' - <b>'. $answers[$key] . ' </b> (' . $percentage . '%)</span>';
            $html .= '    <div style="height: 10px;width:100%;background: #DBDADA;">';
            $html .= '        <div style="height: 10px; width: ' . $percentage . '%;" class="customBG"></div>';
            $html .= '    </div>';
            $html .= '</div>';
        }

        return $html;
    }

    public function getAnswersPercentages($radioId = null, $answers = array())
    {
        if (empty($answers)) {
            $answers = $this->getAnswers($radioId);
        }

        $total       = $this->getTotalAnswers($answers);
        $percentages = array();

        foreach ($answers as $key => $votes) {
            $percentages[$key] = $this->getPercetage($votes, $total);
        }

        return $percentages;
    }

    private function getTotalAnswers($answers = array())
    {
        $total = 0;

        foreach ($answers as $quantity) {
            $total += $quantity;
        }

        return $total;
    }

    private function getPercetage($votes = null, $total = null)
    {
        if ($total == 0) {
            return (float) 0;
        }

        return (float) number_format($votes * 100 / $total, 2);
    }
}
