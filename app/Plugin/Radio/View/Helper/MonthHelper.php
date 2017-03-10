<?php
App::uses('AppHelper', 'View/Helper');

class MonthHelper extends AppHelper
{
    public $helpers = array('Time');

    public function short($date = null)
    {
        $shortMonth = strtoupper($this->Time->format('M', $date));

        return $this->translateShortMonth($shortMonth);
    }

    private function translateShortMonth($shortMonth = null)
    {
        switch ($shortMonth) {
            case 'FEB':
                return 'FEV';

            case 'APR':
                return 'ABR';

            case 'MAY':
                return 'MAI';

            case 'AUG':
                return 'AGO';

            case 'SEP':
                return 'SET';

            case 'OCT':
                return 'OUT';

            case 'DEC':
                return 'DEZ';

            default:
                return $shortMonth;
        }
    }
}
