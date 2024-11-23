<?php

namespace Develtio\ZonesHewalex\Shop\MyAccount;

if (!defined('ABSPATH')) {
    die;
}

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_Orders
 */
class ZH_Orders
{
    /**
     * Hooks archive
     */
    public function __construct()
    {
        add_shortcode('hewalex_orders', array($this, 'displayOrders'));
        add_action('init', array($this, 'orderGet'));
    }

    public function displayOrders()
    {
        $orders = $this->prepareDataToDisplay();

        echo '<div class="hewalex-my-account">';
        echo '<div class="hewalex-my-account__orders">';
       

        echo '
            <table class="table your-order-table">
               
                    <tr>
                        <th>Lp.</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Typ</th>
                    </tr>
                ';
                    foreach($orders as $key => $order) {
                        if(get_current_user_id() === (int)$order->post_author) {
                            echo '
                                <tr>
                                    <td>' . ($key + 1) . '</td>
                                    <td>' . $order->post_date . '</td>
                                    <td>' . get_field('installator', $order->ID) . '</td>
                                    <td><a href="' . get_permalink($order->ID) . '?format=pdf&id=' . $order->ID . '">Drukuj zamówienie</a></td>
                                </tr>
                            ';
                        }
                    }
            echo '
            </table>';
        echo '</div>';
        echo '</div>';
    }

    public function prepareDataToDisplay()
    {
        $args = [
            'post_type' => 'ordered_awards',
            'author' =>  $this->getIdInstallator(),
            'post_per_page' => -1,
            'post_status' =>  'publish'
        ];

        return get_posts($args);
    }

    public function getIdInstallator()
    {
        $user = wp_get_current_user();
        return $user->ID;
    }

    public function prepareStatus()
    {
        /**
         * @TODO
         * return status
         * switch / case
         */
    }

    public function orderGet()
    {
        $order = $_GET['id'] ?? null;
        $format = $_GET['format'] ?? '';

        if ($format === 'pdf') {
            $this->generateOrderPdf($order);
            exit;
        }
    }

    private function generateOrderPdf($order)
    {
        $order_category = get_field('order_category', $order);
        switch ($order_category) {
            case 'ppCardApplication':
                $this->orderPpCardApplicationToPdf($order);
                break;
            case 'avard':
                $this->orderAvardToPdf($order);
                break;
            case 'credits':
                $this->orderCreditsToPdf($order);
                break;
            default:
//                $this->sendJsonResponse(['message' => 'Order pdf template not defined'], 404);
        }
    }

    private function orderAvardToPdf($order)
    {
        $mpdf = new \Mpdf\Mpdf();
        $url = ZH_DIR . 'public/docs/templates/WymianaPremiiNaProdukty.pdf';
        $pagecount = $mpdf->SetSourceFile($url);
        $tplId = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplId);

        $config = [
            'basicFields' => [
                'cellSize' => [75, 3],
                'fields' => [
                    ['id' => 'order_number',    'position' => [24, 42],     'cellSize' => [25, 3]],
                    ['id' => 'created_at',      'position' => [74, 42],     'type' => 'date', 'format' => 'd-m-Y'],
                    ['id' => 'name',            'position' => [24, 67],     'src' => 'billing'],
                    ['id' => 'nip',             'position' => [24, 81],     'src' => 'billing'],
                    ['id' => 'address',         'position' => [24, 89],     'src' => 'billing'],
                    ['id' => 'city',            'position' => [24, 93],     'src' => 'billing'],
                    ['id' => 'zip',             'position' => [24, 97],     'src' => 'billing'],
                    ['id' => 'email',           'position' => [24, 101],    'src' => 'billing'],
                    ['id' => 'phone',           'position' => [24, 105],    'src' => 'billing'],
                    ['id' => 'name',            'position' => [124, 67],    'src' => 'billing'],
                    ['id' => 'contact_person',  'position' => [124, 81],    'src' => 'shipping'],
                    ['id' => 'address',         'position' => [124, 90],    'src' => 'shipping'],
                    ['id' => 'city',            'position' => [124, 94],    'src' => 'shipping'],
                    ['id' => 'zip',             'position' => [124, 98],    'src' => 'shipping'],
                    ['id' => 'email',           'position' => [124, 101.5], 'src' => 'billing'],
                    ['id' => 'phone',           'position' => [124, 105.5], 'src' => 'shipping'],
                    ['id' => 'price_total',     'position' => [186, 212.5], 'cellSize' => [12, 3]]
                ],
            ],
            'basketFields' => [
                'cellSize' => [75, 3],
                'nextBasketFieldPadding' => 12.4,
                'fields' => [
                    ['id' => 'lp',              'position' => [14, 140],    'cellSize' => [4, 3],   'align' => 'C'],
                    ['id' => ['name', 'no'],    'position' => [22, 137.2],  'cellSize' => [107, 3], 'maxLength' => 141],
                    ['id' => 'ref',             'position' => [132, 140],   'cellSize' => [25, 3],  'align' => 'C'],
                    ['id' => 'count',           'position' => [161, 140],   'cellSize' => [15, 3],  'align' => 'C'],
                    ['id' => 'price',           'position' => [181, 140],   'cellSize' => [20, 3],  'align' => 'C'],
                ]
            ]
        ];

        $this->generateOrderPdfByConfig($mpdf, $order, $config);
        $mpdf->Output('WymianaPremiiNaProdukty.pdf', 'I');
        exit;
    }

    private function orderCreditsToPdf($order)
    {
        $mpdf = new \Mpdf\Mpdf();
        $url = ZH_DIR . 'public/docs/templates/ZasilenieKartyPlatniczej.pdf';
        $pagecount = $mpdf->SetSourceFile($url);
        $tplId = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplId);

        $config = [
            'basicFields' => [
                'cellSize' => [75, 3],
                'fields' => [
                    ['id' => 'order_number',    'position' => [24, 39],     'cellSize' => [25, 3]],
                    ['id' => 'created_at',      'position' => [74, 39],     'type' => 'date',   'format' => 'Y-m-d'],
                    ['id' => 'name',            'position' => [24, 67.5],   'src' => 'billing', 'cellSize' => [100, 3]],
                    ['id' => 'nip',             'position' => [24, 77.5],   'src' => 'billing'],
                    ['id' => 'address',         'position' => [24, 85.5],   'src' => 'billing'],
                    ['id' => 'city',            'position' => [24, 89.5],   'src' => 'billing'],
                    ['id' => 'zip',             'position' => [24, 93.5],   'src' => 'billing'],
                    ['id' => 'email',           'position' => [24, 97.5],   'src' => 'billing'],
                    ['id' => 'phone',           'position' => [24, 101.5],  'src' => 'billing'],
                    ['id' => 'validDate',       'position' => [154, 178.5], 'src' => 'billing', 'cellSize' => [25, 3]],
                    ['id' => 'number',          'position' => [154, 67.8],  'src' => 'shipping', 'cellSize' => [25, 3]],
                    ['id' => 'validDate',       'position' => [154, 72],    'src' => 'shipping', 'cellSize' => [25, 3]],
                    ['id' => 'price_total',     'position' => [164, 126.5], 'unit' => 'zł', 'cellSize' => [25, 3]]
                ],
            ]
        ];

        $this->generateOrderPdfByConfig($mpdf, $order, $config);
        $mpdf->Output('ZasilenieKartyPlatniczej.pdf', 'I');
        exit;
    }

    /**
     * @param $order
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @TODO
     * Zapisać do CPT ordered cards wszystkie dane tak jak przy Credits
     */
    private function orderPpCardApplicationToPdf($order)
    {
        $mpdf = new \Mpdf\Mpdf();
        $url = ZH_DIR . 'public/docs/templates/KartaPrepaidWniosek.pdf';
        $pagecount = $mpdf->SetSourceFile($url);
        $tplId = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplId);

        $config = [
            'basicFields' => [
                'cellSize' => [75, 3],
                'fields' => [
                    ['id' => 'order_number',    'position' => [24, 37],     'cellSize' => [25, 3]],
                    ['id' => 'created_at',      'position' => [74, 37],     'type' => 'date', 'format' => 'd-m-Y'],
                    ['id' => 'name',            'position' => [24, 58],     'src' => 'billing'],
                    ['id' => 'nip',             'position' => [24, 68],     'src' => 'billing'],
                    ['id' => 'address',         'position' => [24, 76],     'src' => 'billing'],
                    ['id' => 'city',            'position' => [24, 80],     'src' => 'billing'],
                    ['id' => 'zip',             'position' => [24, 84],     'src' => 'billing'],
                    ['id' => 'email',           'position' => [24, 88],     'src' => 'billing'],
                    ['id' => 'phone',           'position' => [24, 92],     'src' => 'billing'],
                    ['id' => 'name',            'position' => [124, 58],    'src' => 'billing'],
                    ['id' => 'contact_person',  'position' => [124, 68],    'src' => 'shipping'],
                    ['id' => 'address',         'position' => [124, 77],    'src' => 'shipping'],
                    ['id' => 'city',            'position' => [124, 81],    'src' => 'shipping'],
                    ['id' => 'zip',             'position' => [124, 85],    'src' => 'shipping'],
                    ['id' => 'email',           'position' => [124, 89],    'src' => 'billing'],
                    ['id' => 'phone',           'position' => [124, 93],    'src' => 'shipping'],
                ]
            ]
        ];

        $this->generateOrderPdfByConfig($mpdf, $order, $config);
        $mpdf->Output('KartaPrepaidWniosek.pdf', 'I');
        exit;
    }

    private function prepareDataById($order_id)
    {
        $cart_data = json_decode(get_field('products_array', $order_id), true);
        $basket = $this->prepareBasketToOrder($cart_data);
        $date_updated = get_post($order_id)->post_modified;
        $date_created = get_post($order_id)->post_date;
        $order = array(
            'order_id' => $order_id,
            'order_number' => get_field('id_order', $order_id),
            'order_category' => get_field('order_category', $order_id),
            'installer_id' => get_field('installator', $order_id),
            'basket' => $basket,
            'billing' => array(
                array(
                    'name' => 'company',
                    'value' => get_field('installator', $order_id),
                ),
                array(
                    'name' => 'name',
                    'value' => get_field('billing_company', $order_id),
                ),
                array(
                    'name' => 'nip',
                    'value' => get_field('billing_nip', $order_id),
                ),
                array(
                    'name' => 'email',
                    'value' => get_field('billing_email', $order_id),
                ),
                array(
                    'name' => 'phone',
                    'value' => get_field('billing_phone', $order_id),
                ),
                array(
                    'name' => 'address',
                    'value' => get_field('billing_address', $order_id),
                ),
                array(
                    'name' => 'zip',
                    'value' => get_field('billing_postcode', $order_id),
                ),
                array(
                    'name' => 'city',
                    'value' => get_field('billing_city', $order_id),
                ),
                array(
                    'name' => 'region',
                    'value' => get_field('billing_province', $order_id),
                ),
                array(
                    'name' => 'country',
                    'value' => get_field('billing_country', $order_id),
                ),
                array(
                    'name' => 'validDate',
                    'value' => get_field('shipping_validDate', $order_id),
                ),
            ),
            'shipping' => array(
                array(
                    'name' => 'company',
                    'value' => get_field('installator', $order_id),
                ),
                array(
                    'name' => 'name',
                    'value' => get_field('billing_company', $order_id),
                ),
                array(
                    'name' => 'nip',
                    'value' => get_field('billing_nip', $order_id),
                ),
                array(
                    'name' => 'email',
                    'value' => get_field('shipping_email', $order_id),
                ),
                array(
                    'name' => 'phone',
                    'value' => get_field('shipping_phone', $order_id),
                ),
                array(
                    'name' => 'address',
                    'value' => get_field('shipping_address', $order_id),
                ),
                array(
                    'name' => 'zip',
                    'value' => get_field('shipping_postcode', $order_id),
                ),
                array(
                    'name' => 'city',
                    'value' => get_field('shipping_city', $order_id),
                ),
                array(
                    'name' => 'region',
                    'value' => get_field('shipping_province', $order_id),
                ),
                array(
                    'name' => 'country',
                    'value' => get_field('shipping_country', $order_id),
                ),
                array(
                    'name' => 'contact_person',
                    'value' => get_field('shipping_contact_person', $order_id),
                ),
                array(
                    'name' => 'validDate',
                    'value' => get_field('shipping_validDate', $order_id),
                ),
                array(
                    'name' => 'number',
                    'value' => get_field('shipping_number', $order_id),
                ),
            ),
            'price_total' => get_field('price', $order_id) ? get_field('price', $order_id) : get_field('credits', $order_id),
            'paid' => get_field('paid_status', $order_id),
            'status' => get_field('paid_status', $order_id),
            'invoice' => get_field('id_invoice', $order_id),
            'created_at' => $date_created,
            'updated_at' => $date_updated,
        );

        return $order;
    }

    private function prepareBasketToOrder($cart_items)
    {
        $key = 0;
        foreach ($cart_items as $item) {
            $basket[$key] = array(
                'ref' => $item['sku'],
                'name' => $item['product_name'],
                'count' => $item['product_quantity'],
                'photo' => $item['product_image'],
                'price' => $item['product_price'],
                'no' => '',
                'type' => 0,
            );
            $key++;
        }

        return $basket;
    }

    private function generateOrderPdfByConfig($mpdf, $order, $config)
    {
        $prepareOrder = $this->prepareDataById($order);

//        print_r($prepareOrder);
//        die();
        /* basic fields rendering */
        foreach ($config['basicFields']['fields'] ?? [] as $field) {
            //name fields (array)
            $initXPos = $field['position'][0] ?? 0;
            $initYPos = $field['position'][1] ?? 0;
            $cellWith = $field['cellSize'][0] ?? $config['basicFields']['cellSize'][0] ?? 10;
            $cellHeight = $field['cellSize'][1] ?? $config['basicFields']['cellSize'][1] ?? 4;

            if ($field['src'] ?? null) {
                $item = array_first($prepareOrder[$field['src']], function ($item) use ($field) {
                    return $item['name'] === $field['id'];
                });
                $value = $item['value'] ?? null;
            } else {
                $value = $prepareOrder[$field['id']] ?? null;
            }
//            if ($value && $field['type'] ?? null === 'date') {
//                $value = \Carbon\Carbon::createFromTimeString($value)->format($field['format'] ?? 'd-m-Y');
//            }
            if ($value && $field['unit']) {
                $value .= " {$field['unit']}";
            }

            $mpdf->SetXY($initXPos, $initYPos);
            $value = $value ? (string)$value : '(brak danych)';
            $mpdf->MultiCell($cellWith, $cellHeight, $value);
        }

        /* basket rendering */
        foreach ($prepareOrder['basket'] ?? [] as $k => $basketItem) {
            $rowPadding = $k * $config['basketFields']['nextBasketFieldPadding'];
            foreach ($config['basketFields']['fields'] as $field) {
                $mpdf->SetFontSize($mpdf->default_font_size);
                $initXPos = $field['position'][0] ?? 0;
                $initYPos = ($field['position'][1] ?? 0) + $rowPadding;
                $cellWith = $field['cellSize'][0] ?? $config['basicFields']['cellSize'][0] ?? 10;
                $cellHeight = $field['cellSize'][1] ?? $config['basicFields']['cellSize'][1] ?? 4;

                if ($field['id'] == 'lp') {
                    $value = $k + 1;
                } elseif (is_array($field['id'])) {
                    $mpdf->SetFontSize(8);
                    $value = "";
                    foreach ($field['id'] as $field) {
                        $text = ($field == 'no') ? strip_tags($this->prepareItemNo($basketItem)) : $basketItem[$field];
                        $value .= $text . "\n";
                    }
                } elseif ($field['id'] == 'price') {
                    $value = $basketItem[$field['id']] * $basketItem['count'];
                } else {
                    $value = $basketItem[$field['id']];
                }

                $maxFieldLength = $field['maxLength'] ?? null;
                if ($maxFieldLength && strlen($value) > $maxFieldLength) {
                    $value = str_limit($value, $maxFieldLength);
                }

                $mpdf->SetXY($initXPos, $initYPos);
                $value = $value ? (string)$value : '(brak danych)';
                $mpdf->MultiCell($cellWith, $cellHeight, $value, 0, $field['align'] ?? 'L');
            }
        }
    }

    /**
     * @param $data
     * @return string
     */
    public static function prepareItemNo($data)
    {
        $data['no'] = str_replace('size_no', '<br/>rozmiar', $data['no']);
        $data['no'] = str_replace('|', '<br/> ', $data['no']);
        $data['no'] = str_replace(':', ': ', $data['no']);
        if ($data['ref']=='HEWAL13' || $data['ref']=='HEWAL14') {
            $no = '(data '.$data['no'].')';
        } else {
            $no = ''.$data['no'].'';
        }

        return $no;
    }
}