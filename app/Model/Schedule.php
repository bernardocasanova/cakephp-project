<?php
App::uses('AppModel', 'Model');

class Schedule extends AppModel
{
    public $belongsTo = array('Radio');

    public function getAllSchedules($radioId = null)
    {
        $results = $this->find('all', array(
            'conditions' => array(
                'radio_id' => $radioId
            )
        ));

        return $this->groupByWeekDay($results);
    }

    private function groupByWeekDay($results = array())
    {
        if (empty($results)) {
            return array();
        }

        $groups = array();

        foreach ($results as $key => $result) {
            $result['Schedule']['onAir'] = $this->isOnAir($result['Schedule']);

            $groups[$result['Schedule']['week_day']][] = $result['Schedule'];
        }

        return $groups;
    }

    private function isOnAir($schedule = array())
    {
        if (date('w') != $schedule['week_day']) {
            return false;
        }

        $nowTimestamp     = strtotime(date('H:i'));
        $initialTimestamp = strtotime($schedule['initial_hour']);
        $finalTimestamp   = strtotime($schedule['final_hour']);

        if ($nowTimestamp >= $initialTimestamp && $nowTimestamp <= $finalTimestamp) {
            return true;
        }

        return false;
    }

    public function addSchedule($weekDay = null, $radioId = null)
    {
        list($initialHour, $finalHour) = $this->getValidHours($weekDay, $radioId);

        $saveData = array(
            'name'         => 'Programação',
            'initial_hour' => $initialHour,
            'final_hour'   => $finalHour,
            'week_day'     => $weekDay,
            'radio_id'     => $radioId
        );

        if (!$this->save($saveData, false)) {
            return false;
        }

        return array(
            'foreignKey'  => $this->getLastInsertID(),
            'initialHour' => $initialHour,
            'finalHour'   => $finalHour
        );
    }

    private function getValidHours($weekDay = null, $radioId = null)
    {
        $results = $this->find('all', array(
            'order'      => array('initial_hour'),
            'conditions' => array(
                'radio_id' => $radioId,
                'week_day' => $weekDay
            )
        ));

        if (empty($results)) {
            return array('00:00', '01:00');
        }

        // get the final hour of the last schedule and transform it on timestamp
        $finalHourTimestamp = strtotime($results[count($results) - 1]['Schedule']['final_hour']);

        return array(
            date('H:i', $finalHourTimestamp + 60 * 1), // +1 minute
            date('H:i', $finalHourTimestamp + 60 * 60 * 1), // +1 hour
        );
    }
}
