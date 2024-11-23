<?php

namespace Develtio\ZonesHewalex\Shop\Cart;
use Develtio\ZonesHewalex\Shop\Checkout\ZH_Checkout;



if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Cart
 */
class ZH_Cart
{
    public function __construct()
    {
        add_action('init', array($this, 'addToCart'));
        add_action('cart', array($this, 'displayCart'));
    }

    public function addToCart()
    {
        if (!isset($_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'] = array();
        }

        if(!empty($_GET["action"])) {
            switch($_GET["action"]) {
                case "add":
                    if (!isset($_SESSION['shopping_cart'][$_POST['ref_number']])) {
                        $_SESSION['shopping_cart'][$_POST['ref_number']] = array(
                            'sku'              => $_POST['ref_number'],
                            'product_quantity' => $_POST['quantity'],
                            'product_name'     => $_POST['product_model'],
                            'product_image'    => $_POST['product_image'],
                            'product_price'    => $_POST['price_brutto'],
                            'product_size'    => $_POST['product_get_size'] ?? null,
                            'product_id'    => $_POST['product_the_id'],
                        );
                    }
                    else {
                        $_SESSION['shopping_cart'][$_POST['ref_number']]['product_quantity'] += $_POST['quantity'];
                    }
                    break;
                case "remove":
                    if(!empty($_SESSION['shopping_cart'])) {
                        foreach($_SESSION['shopping_cart'] as $key => $cart_item) {
                            if($_GET["code"] == $key)
                                unset($_SESSION["shopping_cart"][$key]);
                            if(empty($_SESSION["shopping_cart"]))
                                unset($_SESSION["shopping_cart"]);
                        }
                    }
                    break;
                case "empty":
                    unset($_SESSION["shopping_cart"]);
                    break;
            }
        }
    }

    public function displayCart()
    {
        $cart_count = $_SESSION['shopping_cart'];
        $cart_title_sidebar = '<h3>Twój koszyk</h3>';
        echo $cart_title_sidebar;

        if(sizeof($cart_count) == 0){
            echo '<p>Nie masz żadnych produktów w koszyku</p>';
        }
        
        if(sizeof($cart_count) > 0){
        echo '<div class="hewalex-single-product__cart cart_sidebar">';
        echo '<table>';
        echo '
        <thead>
        <tr>
        <th>&nbsp;</th>
        <th>Produkt</th>
        <th>Ilość</th>
        <th>&nbsp;</th>
        </tr>
        </thead>';
        }
        foreach ($_SESSION['shopping_cart'] as $key => $cart_item)
        {
            $currency = '<span class="currency">zł</span>';
            $summary = (new ZH_Checkout())->summaryCartPrice();

            echo '
            <tr>';
            echo '<td><img style="max-width: 50px; height: auto" src="' . $cart_item['product_image'] . '"/></td>';
            echo '<td><a href="'. get_permalink($cart_item['product_id']) .'">' . $cart_item['product_name'] . '</a></td>';
            echo '<td>' . $cart_item['product_quantity'] . '</td>';
            echo '<td><a class="cart-remove-btn" href="?action=remove&code='. $cart_item['sku'] .'">Usuń</a></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        if(!empty($_SESSION['shopping_cart'])) {
            echo '<div class="total_sidebar"><p>Suma zamówienia:</p><strong>'. $summary . $currency . '</strong></div>';
            echo '<a class="make-order-btn" href="' . home_url('/strefa-instalatora/strona-zamowienia') . '">Złóż zamówienie</a>';
        }
    }
}