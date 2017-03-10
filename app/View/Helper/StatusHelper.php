<?php
App::uses('AppHelper', 'View/Helper');

class StatusHelper extends AppHelper
{
    public function status($status)
    {
        switch ($status) {
            case 1:
                return sprintf('<span class="badge badge-success badge-roundless">%s</span>', __('Ativo'));

            case 0:
                return sprintf('<span class="badge badge-warning badge-roundless">%s</span>', __('Inativo'));
        }
    }
}
