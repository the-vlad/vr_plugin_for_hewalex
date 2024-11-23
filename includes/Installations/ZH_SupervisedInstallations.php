<?php

namespace Develtio\ZonesHewalex\Installations;

use Hewalex\AlarmClient\Client;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_SupervisedInstallations
 */
class ZH_SupervisedInstallations
{
    public function __construct()
    {
        add_shortcode( 'supervised_installations', array($this, 'getSupervisedInstallations') );
    }

    public function getSupervisedInstallations()
    {
        global $wpdb;

        $nip = get_user_meta($this->getInstallatorObject()->ID, 'installation_group1_installation_nip', true);
        $email = $this->getInstallatorObject()->user_email;
        $user_id = get_user_meta($this->getInstallatorObject()->ID, 'installation_group1_installation_user_id', true);

        /* Import icons */
        $icon_bin = '<img class="ico-bin" alt="remove" src ="' . ZH_URL . 'assets/img/bin.svg' . '">';
        $icon_redirect = '<img class="ico-redirect" alt="redirect" src ="' . ZH_URL . 'assets/img/goright.svg' . '">';
        $icon_success = '<img class="ico-success" alt="success" src ="' . ZH_URL . 'assets/img/checkmark.svg' . '">';
        $icon_danger = '<img class="ico-danger" alt="danger" src ="' . ZH_URL . 'assets/img/checkmark.svg' . '">';
        $icon_warning = '<img class="ico-warning" alt="warning" src ="' . ZH_URL . 'assets/img/warning.svg' . '">';

        $supervisorDevices = $wpdb->get_results(
            $wpdb->prepare(
                "
                    SELECT *
                    FROM supervisor_devices
                    WHERE nip = %s
                ",
                array($nip)
            )
        );

        $installer_id = wp_get_current_user()->ID;

        $nip = get_user_meta($this->getInstallatorObject()->ID, 'installation_group1_installation_nip', true);
        $clientConfig = array(
            'AlarmClient' => array(
                'url' => 'https://diagnostic-api.hewalex.net/',
                'secret' => 'somesuperrandomstring',
                'timeout' => '10',
                'debug' => '2',
            )
        );

        $supervisorData = [];

        if(isset($clientConfig['AlarmClient'])) {
            $alarmClient = new Client($clientConfig['AlarmClient']);
            $supervisorData = $alarmClient->getSupervisionAll($nip);
        }

        $sHtml = '<div class="alert alert-danger"><span>' . $ico_danger . '</span>Nie posiadasz instalacji do nadzoru!</div>';

        if ($supervisorDevices) {
            $sHtml = '
                <div class="col-md-12">
                    <div class="table-responsive supervised-table">
                        <table class="table list-installer__table" style="width: 100%; text-align: left; border-collapse: collapse">
                            <thead>
                                <tr class="text-weight-bold">
                                    <th>Lp.</th>
                                    <th>Nazwa</th>
                                    <th>Numer seryjny</th>
                                    <th>Alarm</th>
                                    <th>Data</th>                     
                                    <th>Raport</th>
                                    <th style="text-align:center;">Akcja</th>    
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>';

            $i = 1;
            foreach ($supervisorDevices as $device) {
                $icoAlarm = data_get($supervisorData, 'alarms.' . $device->controller_serial, null) ?
                    '<span class="text-danger">' . $icon_warning . '</span>' : '<span class="text-color-green">' . $icon_success . '</span>';

                $alarmData =  data_get($supervisorData, 'alarms.' . $device->controller_serial, null) ?
                    '<span class="text-danger font-weight-bold">'.
                    date('Y-m-d', strtotime(data_get($supervisorData, 'alarms.' . $device->controller_serial . '.0.date'))) . '</span>' :
                    '-';

                $pdf = '-';
                if (data_get($supervisorData, 'diagnostics.' . $device->controller_serial, null)) {
                    $state = data_get($supervisorData, 'diagnostics.' . $device->controller_serial . '.state', null);
                    $pdf = '<i onclick="tempAccessReport('. $device->user_id .', '. $installer_id .' ,'. $device->controller_serial .')" class="fa fa-file-pdf-o '.($state=='ok' ? 'text-dark' : 'text-danger') .' font-size-lg"></i>';
                }

      
                /* Go table */
                $sHtml .= '<tr>';
                $sHtml .= '<td>'. $i .'.</td>';
                $sHtml .= '<td><div class="edit-block"><img class="action_edit" src ="' . ZH_URL . 'assets/img/edit.svg' . '" style="cursor: pointer" onclick="renameAccess(this,'. $device->id .',\''. $device->name .'\')"/><span>'. $device->name .'</span></div></td>';
                $sHtml .= '<td>'. $device->controller_serial .'</td>';
                $sHtml .= '<td>'. $icoAlarm .'</td>';
                $sHtml .= '<td>'. $alarmData .'</td>';
                $sHtml .= '<td>'. $pdf .'</td>';
                $sHtml .= '<td>' . '<a onclick="removeTempAccess(this,' . $device->id . ')" class="action_remove">' . $icon_bin . '</span></td>';
                $sHtml .= '<td style="text-align: center" width="30">' .
                    '<a style="cursor: pointer" class="action_temp_access" onclick="tempAccess('. $device->user_id .', '. $installer_id .')">' . $icon_redirect . '</a>' .
                    '</td>';
                $sHtml .= '</tr>';
                $i++;
            }
            $sHtml .= '</tbody></table></div>';
        }
        echo $sHtml;

    }


    public function getInstallatorObject()
    {
        $installator = wp_get_current_user();
        return $installator;
    }
}
