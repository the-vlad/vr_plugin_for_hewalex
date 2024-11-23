<?php

namespace Develtio\ZonesHewalex\Shop\Checkout;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_ThankYou
 */
class ZH_ThankYou
{
    public function __construct()
    {
        add_shortcode('hewalex_thankyou', array($this, 'displayThankYou'));
    }

    public function displayThankYou()
    {
        if($_SESSION['order_number']){
            echo '<a class="btn-primary-shop btn-thankyou" href="'. get_permalink($_SESSION['order_number']) .'?format=pdf&id='. $_SESSION['order_number'] .'">Drukuj zamówienie</a>';
        } else {
            echo 'nie znaleziono id';
        }
        session_destroy();
    }
}