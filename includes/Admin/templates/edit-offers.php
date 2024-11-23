<?php
use \Develtio\ZonesHewalex\API\model\ZH_OfferForm;
use \Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPv;
use \Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPCWB;
use \Develtio\ZonesHewalex\CPT\ZH_InterestedListUsersPCCO;
use \Develtio\ZonesHewalex\API\model\ZH_OfferFormShop;

global $wpdb;

$offer_form_id = isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';
$category = "select offer_form_category from offer_forms where offer_form_id LIKE {$offer_form_id}";
$category_arr = $wpdb->get_results($category, 'ARRAY_A');
$category_result = $category_arr[0]['offer_form_category'];

$offerFormWithModelsTree = (new ZH_OfferForm())->getOfferFormWithModelsTree($category_result, $offer_form_id);

$formContent = '';

switch($category_result) {
    case 'calcpv':
        (new ZH_InterestedListUsersPv())->renderPrintableOfferForm($offerFormWithModelsTree, $formContent);
        echo '<div style="margin: 10px 20px 0 2px">';
        echo '<div id="poststuff">';
            echo '<div id="post-body" class="metabox-holder columns-2">';
                echo '<div id="postbox-container-1" class="postbox-container">';
                    echo '<div class="postbox">';
                       echo '<div class="postbox-header"><h2>Panel Hewalex</h2></div>';
                       echo '<div class="inside">';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=bc1xhzxu">PV Ankieta Klient</a>' . '</br>';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=8zc9av26">PV Oferta dla klienta</a>' . '</br>';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=o9ob73zd">PV Oferta instalatora</a>' . '</br>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<div id="postbox-container-2" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Dane doboru</h2></div>';
                        echo '<div class="inside">';
                            echo $formContent;
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
        echo '</div>';
        echo '</div>';
        break;
    case 'pcwb':
        (new ZH_InterestedListUsersPCWB())->renderPrintableOfferForm($offerFormWithModelsTree, $formContent);
        echo '<div style="margin: 10px 20px 0 2px">';
        echo '<div id="poststuff">';
            echo '<div id="post-body" class="metabox-holder columns-2">';
                echo '<div id="postbox-container-1" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Panel Hewalex</h2></div>';
                        echo '<div class="inside">';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=wp305b23">PCWB Oferta Klient</a>' . '</br>';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=54Kspw429r7">PCWB Ankieta Klient</a>' . '</br>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<div id="postbox-container-2" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Dane doboru</h2></div>';
                        echo '<div class="inside">';
                            echo $formContent;
                        echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '</div>';
        break;
    case 'pcco':
        (new ZH_InterestedListUsersPCCO())->renderPrintableOfferForm($offerFormWithModelsTree, $formContent);
        echo '<div style="margin: 10px 20px 0 2px">';
        echo '<div id="poststuff">';
            echo '<div id="post-body" class="metabox-holder columns-2">';
                echo '<div id="postbox-container-1" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Panel Hewalex</h2></div>';
                        echo '<div class="inside">';
                            echo '<a target="_blank" href="/wp-json/hewalex-zones/v2/offerFormPreviewHistory?offer_forms='.$offer_form_id.'&reportHash=r76swpv8">PCCO Ankieta Klient</a>' . '</br>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div id="postbox-container-2" class="postbox-container">';
                echo '<div class="postbox">';
                    echo '<div class="postbox-header"><h2>Dane doboru</h2></div>';
                    echo '<div class="inside">';
                        echo $formContent;
                    echo '</div>';
            echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '</div>';
        break;
    case 'shopOffer':
        $optionsArray = (new ZH_OfferForm)->getArrayFromFormOptionsHistoryOffer($offer_form_id, 'form_options', 'additional');
        $productsHtml = (new ZH_OfferFormShop())->getProductsHistoryForPrint();


        $id =  isset($_GET['offer_forms']) ? intval($_GET['offer_forms']) : '';
        $price = (new ZH_OfferForm())->searchArray('totalPrice', 'id', 'value', $optionsArray);
        $comment = (new ZH_OfferForm)->getValueFromColumnHistory($offer_form_id, 'comment');

        $dateCreated = date('d.m.Y', strtotime((new ZH_OfferForm)->getValueFromColumnHistory($offer_form_id, 'created_at')));

        $clientName = (new ZH_OfferForm)->getValueFromHistoryOffer($offer_form_id, 'contact', '', 'name', 'value');


        $html = '
               <table width="100%" style="margin-bottom:10px; padding-bottom:10px;">
                    <tr>
                        <td width="50%">
                            <h3>OFERTA NR ' . $id . '/'. $dateCreated .'</h3>
                        </td>
                        <td width="50%" valign="top" style="text-align: right;">
                            Data utworzenia: ' . $dateCreated . '
                        </td>
                    </tr>
                    <tr><td colspan="2" height="30"></td></tr>
                    <tr>
                        <td>
                            <p><strong>Oferta dla:</strong></p>
                            ' . $clientName . '
                        </td>
                        <td style="text-align: right; font-size:14px">
                            Wartość brutto: <strong style="font-size:16px;">' . $price . ' zł</strong>
                        </td>
                    </tr>
                </table>';

        $html .= $productsHtml;

        if ($comment) {
            $html .= '<p style="margin-top:40px;"><strong>UWAGI:</strong><br/>' . $comment . '</p>';
        }

        echo '<div style="margin: 10px 20px 0 2px">';
        echo '<div id="poststuff">';
            echo '<div id="post-body" class="metabox-holder columns-2">';
                echo '<div id="postbox-container-1" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Panel Hewalex</h2></div>';
                        echo '<div class="inside">';
                            echo '<a target="_blank" href="/strefa-instalatora/edycja-koszyka?hash='. (new ZH_OfferForm)->getValueFromColumnHistory($offer_form_id, 'hash') .'">Edytuj ofertę</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<div id="postbox-container-2" class="postbox-container">';
                    echo '<div class="postbox">';
                        echo '<div class="postbox-header"><h2>Dane doboru</h2></div>';
                        echo '<div class="inside">';
                            echo $html;
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
        echo '</div>';
        echo '</div>';

        break;
}