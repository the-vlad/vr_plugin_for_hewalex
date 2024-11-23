<?php

namespace Develtio\ZonesHewalex\Shop;

if (!defined('ABSPATH')) {
    die;
}

use Develtio\ZonesHewalex\Shop\Cart\ZH_Cart;
use Develtio\ZonesHewalex\Shop\Checkout\ZH_Checkout;
use Develtio\ZonesHewalex\Shop\Checkout\ZH_ThankYou;
use Develtio\ZonesHewalex\Shop\Products\ZH_Archive;
use Develtio\ZonesHewalex\Shop\MyAccount\ZH_Orders;
use Develtio\ZonesHewalex\Shop\MyAccount\ZH_Points;
use Develtio\ZonesHewalex\Shop\Products\ZH_Single;
use Develtio\ZonesHewalex\Shop\Products\ZH_IncludeMetaSearch;
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ZH_Shop
 */
class ZH_Shop
{
    public function __construct()
    {
        self::register();

        if(!isset($_SESSION)) {
            session_start();
        }
    }

    private static function init(): array
    {
        return [
            ZH_IncludeMetaSearch::class,
            ZH_Archive::class,
            ZH_Single::class,
            ZH_Cart::class,
            ZH_Checkout::class,
            ZH_Orders::class,
            ZH_Points::class,
            ZH_ThankYou::class,
        ];
    }

    public static function register() : void
    {
        foreach (self::init() as $class)
        {
            new $class();
        }
    }
}