<?php

namespace Develtio\ZonesHewalex\Shop\Checkout;

use Develtio\ZonesHewalex\Ajax\Controller\Edenred\ZH_EdenredAddCredits;
use Develtio\ZonesHewalex\Shop\MyAccount\ZH_Points;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Checkout
 */
class ZH_Checkout
{
    public function __construct()
    {
        add_shortcode('hewalex_checkout', array($this, 'displayFormCheckout'));
        //Hook: Form checkout
        add_action('checkout', array($this, 'summaryCart'), 10);
        add_action('template_redirect', array($this, 'triggerForm'), 10);
        add_action('checkout', array($this, 'formStart'), 11);
        add_action('checkout', array($this, 'checkoutBilling'), 20);
        add_action('checkout', array($this, 'buttonsShipping'), 25);
        add_action('checkout', array($this, 'checkoutShipping'), 30);
        add_action('checkout', array($this, 'formEnd'), 31);
    }

    public function summaryCart()
    {
        echo '<div class="hewalex-single-product__cart checkout_section">';
        echo '<table class="checkout-table" style="width: 100%;">';
        echo '<thead>
        <tr>
        <th>&nbsp;</th>
        <th>Produkt</th>
        <th>Ilość</th>
        <th>Cena za szt.</th>
        <th>Kwota</th>
        <th>&nbsp;</th>
        </tr>
        </thead>';
        foreach ($_SESSION['shopping_cart'] as $key => $cart_item)
        {

            $currencyBrutto = '<span class="currency">zł brutto<span>';
            $currency = '<span class="currency">zł<span>';

            echo '<tr>';
            echo '<td><img src="' . $cart_item['product_image'] . '"/></td>';
            echo '<td>' . $cart_item['product_name'] . '</td>';
            echo '<td>' . $cart_item['product_quantity'] . '</td>';
            echo '<td class="prod_price">' . $cart_item['product_price'] . $currencyBrutto . '</td>';
            echo '<td class="prod_price_kwota">' . $cart_item['product_quantity'] * $cart_item['product_price'] . $currencyBrutto . '</td>';
            echo '<td><a class="cart-remove-btn" href="?action=remove&code='. $cart_item['sku'] .'">Usuń</a></td>';
            echo '</tr>';
        }
        echo '<tr class="sum-row">';
            echo '<td>Suma</td>';
            echo '<td colspan="3"></td>';
            echo '<td>'. $this->summaryCartPrice() . $currency . '</td>';
            echo '<td></td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';

        echo '<div class="point_box--checkout"> Ilość punktów na Twoim koncie: ' . (new ZH_Points)->calculateTotalsPoints() . '</div>';
    }

    public function triggerForm()
    {
        $status = false;
        
        foreach ($_SESSION['shopping_cart'] as $item){
            $productSize = $item['product_size'];
        }

        if (isset($_POST["checkout"]))
        {
            $products = json_encode($_SESSION['shopping_cart'], JSON_UNESCAPED_UNICODE);
            $count = $this->countPostByAuthor('ordered_awards');

            $args = array(
                'post_author' => $this->getIdInstaller(),
                'post_type' => 'ordered_awards',
                'post_title' => 'Zamówiona nagroda dla ' . $this->getIdInstaller(),
                'post_status' =>  'publish',
                'meta_input' => array(
                    'order_category' => 'avard',
                    'id_order' => $count + 1 . '/' . date('Y'),
                    'installator' => $this->getIdInstaller(),
                    'price' => $this->getPrice($products),
                    'paid_status' => 'Zapłacono',
                    'id_invoice' => '',
                    'status' => '',
                    'size_invoice' => $productSize,
                    'billing_company' => $_POST['name'],
                    'billing_nip' => $_POST['nip'],
                    'billing_address' => $_POST['address'],
                    'billing_postcode' => $_POST['postcode'],
                    'billing_city' => $_POST['city'],
                    'billing_province' => $_POST['province'],
                    'billing_country' => 'Polska',
                    'billing_email' => $_POST['email'],
                    'billing_phone' => $_POST['phone'],
                    'shipping_contact_person' => $_POST['person_contact'],
                    'shipping_address' => empty($_POST['shipping_address']) ? $_POST['address'] : $_POST['shipping_address'],
                    'shipping_postcode' => empty($_POST['shipping_postcode']) ? $_POST['postcode'] : $_POST['shipping_postcode'],
                    'shipping_city' => empty($_POST['shipping_city']) ? $_POST['city'] : $_POST['shipping_city'],
                    'shipping_province' => $_POST['shipping_province'],
                    'shipping_country' => $_POST['shipping_country'],
                    'shipping_phone' => empty($_POST['shipping_phone']) ? $_POST['phone'] : $_POST['shipping_phone'],
                    'products_array' => $products
                )
            );

            $insert = wp_insert_post($args);

            if((new ZH_Points())->prepareOldPoints() > 0) {
                (new ZH_EdenredAddCredits)->updatePointsPurchaseOldSystem($this->getPrice($products));
            } else {
                (new ZH_EdenredAddCredits)->updatePointsPurchase($this->getPrice($products));
            }

            if(!is_wp_error($insert)){
                $status = true;
            }
            else {
                echo $insert->get_error_message();
            }

            if($status === true) {
                $_SESSION['order_number'] = $insert;
                $url = home_url('/strefa-instalatora/podziekowanie');
                if ( wp_safe_redirect( $url ) ) {
                    exit;
                }
            }
        }
    }

    public function getPrice($products)
    {
        $price = 0;
        $products = json_decode($products, true);
        foreach ($products as $key => $product){
            $price += $product['product_price'] * $product['product_quantity'];
        }
        return $price;
    }

    public function formStart()
    {
        echo '
            <form class="checkout_form" method="POST">
        ';
    }

    public function checkoutBilling()
    {
        $user = wp_get_current_user();

        echo '
            <div class="checkout_billing">
              <div class="checkout_billing--col">
                <div class="input-group">
                <label for="nip">NIP</label>
                <input id="nip" name="nip" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_nip', true ) .'" >
                </div>
                <div class="input-group">
                <label for="phone">Telefon</label>
                <input id="phone" name="phone" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_phone_installer', true ) .'"/>
                </div>
                <div class="input-group">
                <label for="email">E-mail</label>
                <input id="email" name="email" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_email_installer', true ) .'"/>
               </div>
               <div class="input-group">
                <label for="name">Nazwa</label>
                <input id="name" name="name" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_name_installer', true ) .'">
               </div>
              </div>
              <div class="checkout_billing--col">
              <div class="input-group">
                <label for="city">Miasto</label>
                <input id="city" name="city" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_city_installer', true ) .'"/>
               </div>
               <div class="input-group">
                <label for="postcode">Kod pocztowy</label>
                <input id="postcode" name="postcode" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_post_code_installer', true ) .'"/>
               </div>
               <div class="input-group">
                <label for="address">Adres</label>
                <input id="address" name="address" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_address_installer', true ) .'"/>
               </div>
               <div class="input-group">
                <label for="province">Województwo</label>
                <input id="province" name="province" type="text" value="'. get_user_meta( $user->ID, 'installation_group1_installation_province_installer', true ) .'"/>
                </div>
                </div>
            </div>
        ';
    }

    public function buttonsShipping()
    {
        echo '
        <div class="other_address">
            <span class="heading-primary pr-xs"><strong>Wysłać na inny adres?</strong></span>
            <div class="btn-group">
                <button  id="toggleShippingNo" type="button">Nie</button>
                <button class="disabledState" id="toggleShippingYes" type="button">Tak</button>
            </div>  
          </div>      
        ';
    }

    public function checkoutShipping()
    {
        echo '
            <div class="checkout_billing" id="additional_address">
            <div class="checkout_billing--col">
             <div class="input-group">
                <label for="shipping_address">Adres</label>
                <input name="shipping_address" id="shipping_address" type="text"/>
              </div>
              <div class="input-group">
                <label for="person_contact">Osoba kontaktowa:</label>
                <input name="person_contact" id="person_contact" type="text"/>
              </div>
              <div class="input-group">
                <label for="shipping_postcode">Kod pocztowy</label>
                <input name="shipping_postcode" id="shipping_postcode" type="text"/>
              </div>
              <div class="input-group">
                <label for="shipping_phone">Telefon</label>
                <input name="shipping_phone" id="shipping_phone" type="text"/>
              </div>
              <div class="input-group">
                <label for="shipping_city">Miasto</label>
                <input name="shipping_city" id="shipping_city" type="text"/>
               </div>
             </div>
             <div class="checkout_billing--col">
               <div class="input-group">
                <label for="shipping_province">Województwo</label>
              <div class="select-group">
                <select name="shipping_province" id="shipping_province">
                   <option value="">Wybierz</option>
                   <option value="dolnoslaskie">dolnośląskie</option>
                   <option value="kujawsko-pomorskie">kujawsko-pomorskie</option>
                   <option value="lubelskie">lubelskie</option>
                   <option value="lubuskie">lubuskie</option>
                   <option value="mazowieckie">mazowieckie</option>
                   <option value="malopolskie">małopolskie</option>
                   <option value="opolskie">opolskie</option>
                   <option value="podkarpackie">podkarpackie</option>
                   <option value="podlaskie">podlaskie</option>
                   <option value="pomorskie">pomorskie</option>
                   <option value="slaskie">śląskie</option>
                   <option value="swietokrzyskie">świętokrzyskie</option>
                   <option value="warminskomazurskie">warmińsko-mazurskie</option>
                   <option value="wielkopolskie">wielkopolskie</option>
                   <option value="zachodniopomorskie">zachodniopomorskie</option>
                   <option value="lodzkie">łódzkie</option>
                </select>
                </div>
                </div>
                <div class="input-group">
                <label for="shipping_country">Kraj</label>
               <div class="select-group">
                <select name="shipping_country" id="shipping_country">
                   <option value="polska">Polska</option>
                </select>
                </div>
                </div>
                </div>
            </div>
        ';
    }

    public function formEnd()
    {
        if((new ZH_Points)->calculateTotalsPoints() >= $this->summaryCartPrice()){
            echo '
                <input class="checkout-btn btn-primary-shop" type="submit" name="checkout" id="checkout" value="Zamawiam" />
            ';
        }
        else {
            echo '<div class="notice-error notification-alert">Zamówienie nie może być zrealizowane, zbyt mało punktów na koncie.</div>';
        }
        echo '</form>';
    }

    public function summaryCartPrice()
    {
        $summaryCart = null;
        foreach($_SESSION['shopping_cart'] as $cart_item) {
            $summaryCart += $cart_item['product_price'] * $cart_item['product_quantity'];
        }

        return $summaryCart;
    }

    public function countPostByAuthor($post_type)
    {
        $args = array(
            'post_type' => $post_type,
            'post_author' => $this->getIdInstaller(),
            'posts_per_page' => -1
        );
        $result = get_posts($args);
        return count($result);
    }

    private function getIdInstaller()
    {
        $user = wp_get_current_user();
        return $user->ID;
    }

    public function displayFormCheckout()
    {
        /**
         * Hook: checkout
         * 10 - summaryCart
         * 10 - triggerForm
         * 11 - formStart
         * 20 - checkoutBilling
         * 25 - buttons
         * 30 - checkoutShipping
         * 31 - formEnd
         */
        if(!empty($_SESSION['shopping_cart'])) {
            do_action('checkout');
        }
        else {
            $cart_title_checkout = '<h3>Twój koszyk</h3>';
            echo '<div class="checkout-empty">';
            echo '<div class="point_box--checkout"> Ilość punktów na Twoim koncie: ' . (new ZH_Points)->calculateTotalsPoints() . '</div>';
            echo $cart_title_checkout;
            echo '<p>Nie masz żadnych produktów w koszyku</p>';
            echo '<p>Dodaj produkty do koszyka</p><a class="btn-primary-shop" href="'. home_url('/strefa-instalatora/zamow-nagrode/') .'">Przejdź do sklepu</a>';
            echo '</div>';
        }
    }
}