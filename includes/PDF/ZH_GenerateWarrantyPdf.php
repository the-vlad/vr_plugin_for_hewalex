<?php
namespace Develtio\ZonesHewalex\PDF;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_GenerateWarrantyPdf
 */

class ZH_GenerateWarrantyPdf
{
    public function generatePdfFile($id_gwarancji, $id_number_set)
    {
        $mpdf = new \Mpdf\Mpdf();

        $dane = $this->prapareClientData($id_gwarancji);
        $daneProduktow = $this->prepareProductsData($id_gwarancji);
        $daneInstalatora = $this->prepareInstallatorData($id_gwarancji);
        $kolektor = $this->getCollectors($id_gwarancji);

        $type_set = get_field('type_set', $id_number_set);
        $type_set_id = $type_set->ID;
        $type_solar = get_field('type_solar', $type_set_id);
        $type_zps = get_field('type_zps', $type_set_id);

        $html = '<table width="100%"><tr><td><img src="' . ZH_DIR . '/public/logos/logo-hewalex-nowe.png" width="150"/></td></tr><tr><td>ul. Słowackiego 33, 43-502 Czechowice-Dziedzice <br>tel:(032) 214 17 10 fax:(032) 214 50 04<br>e-mail: hewalex@hewalex.pl</td></tr></table><hr><br>';
        $html .= '<table align="left" valign="top" width="100%"><tr><td valign="top" ><b>Dane klienta:</b><br>';
        $html .= $dane['installation_name'] . ' ' . $dane['installation_surname'] . '<br>';
        $html .= $dane['installation_address'] . '<br>';
        $html .= $dane['installation_zip'] . ', ' . $dane['installation_city'] . '<br>';
        $html .= $dane['installation_country'] . '<br>';
        $html .= 'tel.: ' . $dane['installation_phone'] . '<br>';
        $html .= 'email: ' . $dane['installation_email'] . '</td></tr></table><br><br>';
        $html .= '<center>ELEKTRONICZNA KARTA GWARANCYJNA<br> <br>';
        $html .= 'Zestaw solarny nr ' . $daneProduktow['code'] . ' (' . $daneProduktow['type'] . ')</center><br> <br>';

        $ksr_guarante_year = 5;
        if ($daneProduktow['date_warranty_start'] >= date('2013-01-01')) {
            $ksr_guarante_year = 10;
        }

        $datakonca = explode('-', $daneProduktow['date_warranty_start']);
        $datakonca = array_reverse($datakonca);
        $datakonca[2] += ($daneProduktow['type'] == 'KSR10' ? ($ksr_guarante_year + 1) : 11);
        $datakonca = implode('-', $datakonca);

        $html .= '<table width="100%"><tr><td>Produkt</td><td>Typ</td><td>Numer seryjny</td><td align="right">Data końca gwarancji</td></tr>';

        foreach ($kolektor as $value) {
            $html .= '<tr><td>Kolektor</td>
                <td>' . $value['type'] . '</td>
                <td>' . $value['collector'] . '</td>
                <td align="right">' . $datakonca . '</td>
                </tr>';
        }

        $module_waranty = 'Zespół pompowo-sterowniczy';

        $datakonca = explode('-', $daneProduktow['date_warranty_start']);
        $datakonca = array_reverse($datakonca);
        $datakonca[2] += 3;
        $datakonca = implode('-', $datakonca);
        $html .= '<tr><td>' . $module_waranty . '</td><td>' . $type_zps . '</td><td>' . $daneProduktow['number_pump_1'] . '<td align="right">' . $datakonca . '</td></tr>';

        $datakonca = explode('-', $daneProduktow['date_warranty_start']);
        $datakonca = array_reverse($datakonca);

        if (preg_match('/PWPC|PCWU/', $daneProduktow['number_heater_1'])) {
            $datakonca[2] += 3;
        } else {
            $datakonca[2] += 6;
        }

        if ($dane->typ == 162) {
            $datakonca[2] += 4;    //3+1 dla tego zestawu
        }

        $datakonca = implode('-', $datakonca);
        $html .= '<tr><td>Podgrzewacz</td><td>' .
            $type_solar . '</td>
			<td>' . $daneProduktow['number_heater_1'] . '</td>
			<!--td align="right">5 lat + 1</td-->
			<td align="right">' . $datakonca . '</td>
			</tr></table>';

        $html .= '<br>Data zakupu: ' . $daneProduktow['date_warranty_start'] . '<br><br>';

        if ($daneInstalatora['nip'] && $daneInstalatora['access'][0]) {
            $html .= 'Dane instalatora:<br>' .
                $daneInstalatora['name'] . '<br>' .
                'NIP: ' . $daneInstalatora['nip'] . '<br>' .
                $daneInstalatora['address'] . '<br>' .
                $daneInstalatora['zip'] . ' ' . $daneInstalatora['city'] . '<br>' .
                'tel. ' . $daneInstalatora['phone'] . '<br>' .
                'email: ' . $daneInstalatora['email'] . '<br><br>';
        }

        $html .= 'Oświadczam, iż zapoznałem się oraz akceptuję warunki gwarancji zawarte na kartach gwarancyjnych dołączonych do dostarczonych urządzeń.<br><br>';
        $html .= '<table><tr><td>' . $dane['installation_name'] . ' ' . $dane['installation_surname'] . '</td></tr></table>';
        $mpdf->WriteHTML($html);

        $path = ZH_DIR . 'generatedPdf';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $mpdf->Output(ZH_DIR . '/generatedPdf/gwarancja-' . $id_gwarancji . '.pdf','F');

        if($this->hasFile($id_gwarancji)){
            $file = $this->getFile($id_gwarancji);
        }

        $sendMail = $this->prepareEmail($id_gwarancji, $file);

        if(!empty($html) && $sendMail){
            wp_send_json('generated PDF and sent e-mail', 200);
        } else {
            wp_send_json('not generated PDF and not sent e-mail', 401);
        }

        exit;
    }

    public function prepareEmail($id_gwarancji, $file)
    {
        $numer_zestawu = get_field('installation_group2_installation_code_product', $id_gwarancji);
        $email_address = get_field('installation_email_step1', $id_gwarancji);

        $email = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]-->
    <!--[if mso]><style type="text/css">
        .mso-hide,
        .mso-hide tr,
        .mso-hide table,
        .mso-hide span,
        .mso-hide a,
        .mso-hide p,
        .mso-hide td {
            display: none;
        }
    </style><![endif]-->
    <style type="text/css">
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        td>p,
        td>ul,
        td>span {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }

        p,
        span {
            max-width: 100%;
        }

        a {
            text-decoration: none;
        }

        .preheader {
            visibility: hidden;
            opacity: 0;
            color: transparent;
            height: 0;
            width: 0;
            display: none !important;
            font-size: 0px;
        }

        img {
            width: auto !important;
            max-width: 100%;
        }

        @media(max-width: 610px) {
            .rwd {
                width: 100% !important;
                max-width: 100% !important;
            }

            .email-content-table {
                width: 100%;
            }
        }

        @media(min-width: 610px) {
            .email-content-table {
                width: 610px;
            }
        }
    </style>
    <style type="text/css">
        @media all and (max-width: 610px) {

            .rwd-600,
            .rwd-600>table {
                width: 100% !important;
                max-width: 100% !important;
            }

            .rwd-600 img {
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ffffff;"> <span class="preheader" style="visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;display: none !important; font-size: 0px;"></span>
<table class="email-content-table" style="background-color:#ffffff;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;width:5px;background-color: #ffffff; font-size: 0;" align="center">&nbsp;</td>
        <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;max-width:600px;" align="center">
            <center style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
                <div style="max-width:600px;background-color: #ffffff;">
                    <!--[if (gte mso 9)|(IE)]><table width="600" style="width:600px;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;max-width:600px;width:600px;background-color: #ffffff;"><![endif]-->
                    <table style="margin: 0px auto; width: 100%; max-width: 600px;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                        <tr>
                            <td style="background-color:transparent;padding-top:0px;padding-bottom:0px;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                <!--[if (gte mso 9)|(IE)]><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;"> <tbody> <tr> <td width="600" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size: 0;"><![endif]-->
                                <div class="rwd-600" style="width:100%;max-width:600px;display:inline-block;vertical-align:top;" align="center">
                                    <table style="border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="left" width="auto" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td class="rwd-600" align="center" width="600" valign="top">
                                                <table valign="top" style="width:auto;max-width:600px;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                    <tr width="100%" style="width: 100%">
                                                        <td style="width: 600px;" align="center" width="600" valign="top"> <a style="font-size: 10px" href="#" target="_blank">
                                                                <img src="/public/images/mailing/header_installer.jpg" border="0" alt="" style="width: 100%; border-radius: 0px; margin-left: 0px; margin-right: 0px; border: none; display: block;max-width: 600px" width="600" /></a> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
<!--[if (gte mso 9)|(IE)]></td></tr></tbody></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<table style="margin: 0px auto; width: 100%; max-width: 600px;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td style="background-color:transparent;padding-top:0px;padding-bottom:0px;padding-right:0;padding-left:0;text-align:center;font-size:0;">
            <!--[if (gte mso 9)|(IE)]><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;"> <tbody> <tr> <td width="600" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-size: 0;"><![endif]-->
            <div class="rwd-600" style="width:100%;max-width:600px;display:inline-block;vertical-align:top;" align="center">
                <table style="border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="left" width="auto" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr style="height:5px;width:100%;" height="5">
                        <td style="height:5px;width:100%;font-size:0;line-height: 1;-webkit-text-size-adjust:none;" height="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="rwd-600" align="center" width="600" valign="top">
                            <table valign="top" style="width:auto;max-width:600px;border-spacing:0;border-collapse: collapse;mso-cellspacing: 0;mso-padding-alt: 0 0 0 0;" align="center" width="600" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr width="100%" style="width: 100%">
                                    <td style="width: 600px;" align="center" width="600" valign="top">
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-weight:bold;font-family:Arial;font-size:14px;color:#000000;">Szanowny Kliencie,</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><br /></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-weight:bold;font-family:Arial;font-size:14px;color:#000000;">dzi&#281;kujemy za zarejestrowanie swojego zestawu. Gwarancja zosta&#322;a przed&#322;u&#380;ona.</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><br /></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Arial;font-size:14px;color:#000000;">W za&#322;&#261;czniku przesy&#322;amy e-gwarancj&#281;. Jest ona r&oacute;wnie&#380; dost&#281;pna po zalogowaniu w Strefie U&#380;ytkownika.</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><br /></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Arial;font-size:14px;color:#000000;">Twoje dane do logowania to:</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Arial;font-size:14px;color:#000000;">Numer zestawu: ' . $numer_zestawu . '</span><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;background-color:#ffffff;"></span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Arial;font-size:14px;color:#000000;">e-mail: ' . $email_address . '</span><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;background-color:#ffffff;"></span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><br /></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">W razie pyta&#324; lub w&#261;tpliwo&#347;ci prosimy o kontakt:</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-weight:bold;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">tel: 32&nbsp;214 17 10 w. 376</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-weight:bold;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">e-mail: </span><a href="mailto:marketing@hewalex.pl" alt="marketing@hewalex.pl"><span style="font-weight:bold;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">marketing@hewalex.pl</span></a></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;"> </span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><br /></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">Z pozdrowieniami,</span></p>
                                        <p style="margin:0;padding:0;width:100%;text-align:left"><span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#000000;">Hewalex</span></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr style="height:5px;width:100%;" height="5">
                        <td style="height:5px;width:100%;font-size:0;line-height: 1;-webkit-text-size-adjust:none;" height="5">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]></td></tr></tbody></table><![endif]-->
        </td>
    </tr>
    </tbody>
</table>

<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
</div>
</center>
</td>
<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;width:5px;background-color: #ffffff; font-size: 0;" align="center">&nbsp;</td>
</tr>
</tbody>
</table>
</body>

</html>';

        $headers = array('Content-Type: text/html; charset=UTF-8');
        $mail = wp_mail($email_address, 'Rejestracja zestawu w serwisie hewalex.pl' , $email, $headers, array($file));

        if($mail){
            return 1;
        } else {
            return 0;
        }
    }

    public function hasFile($id_gwarancji)
    {
        if (file_exists(ZH_DIR . 'generatedPdf/gwarancja-'. $id_gwarancji .'.pdf')) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function getFile($id_gwarancji)
    {
        return ZH_DIR . 'generatedPdf/gwarancja-'. $id_gwarancji .'.pdf';
    }

    public function getCollectors($installation_id)
    {
        return [
            0 => [
                'collector' => get_field('installation_group2_installation_number_collector1', $installation_id),
                'type' => get_field('installation_group2_installation_type', $installation_id),
            ],
            1 => [
                'collector' => get_field('installation_group2_installation_number_collector2', $installation_id),
                'type' => get_field('installation_group2_installation_type', $installation_id),
            ],
            2 => [
                'collector' => get_field('installation_group2_installation_number_driver', $installation_id),
                'type' => get_field('installation_group2_installation_type', $installation_id),
            ]
        ];
    }

    public function prapareClientData($installation_id)
    {
        return [
            'installation_name' => get_field('installation_group_installation_name', $installation_id),
            'installation_surname' => get_field('installation_group_installation_surname', $installation_id),
            'installation_address' => get_field('installation_group_installation_address', $installation_id),
            'installation_zip' => get_field('installation_group_installation_post_code', $installation_id),
            'installation_city' => get_field('installation_group_installation_city', $installation_id),
            'installation_country' => 'Polska',
            'installation_phone' => get_field('installation_group_installation_phone', $installation_id),
            'installation_email' => get_field('installation_group_installation_email', $installation_id),
        ];
    }

    public function prepareProductsData($installation_id)
    {
        return [
            'code' => get_field('installation_group2_installation_code_product', $installation_id),
            'type' => get_field('installation_group2_installation_type', $installation_id),
            'number_collector_1' => get_field('installation_group2_installation_number_collector1', $installation_id),
            'number_collector_2' => get_field('installation_group2_installation_number_collector2', $installation_id),
            'number_heater_1' => get_field('installation_group2_installation_number_heater', $installation_id),
            'number_pump_1' => get_field('installation_group2_installation_number_set', $installation_id),
            'number_driver_1' => get_field('installation_group2_installation_number_driver', $installation_id),
            'date_warranty_start' => get_field('installation_group2_installation_date', $installation_id),
            'date_warranty_end' => '',
        ];
    }

    public function prepareInstallatorData($installation_id)
    {
        return [
            'nip' => get_field('installation_group3_installation_nip_installer', $installation_id),
            'zip' => get_field('installation_group3_installation_post_code_installer', $installation_id),
            'phone' => get_field('installation_group3_installation_phone_installer', $installation_id),
            'email' => get_field('installation_group3_installation_email_installer', $installation_id),
            'address' => get_field('installation_group3_installation_address_installer', $installation_id),
            'city' => get_field('installation_group3_installation_city_installer', $installation_id),
            'name' => get_field('installation_group3_installation_name_installer', $installation_id),
            'access' => get_field('installation_group3_installation_connect', $installation_id),
        ];
    }

    public function render($url)
    {
        ob_start();
            include($url);
            $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}