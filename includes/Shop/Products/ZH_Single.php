<?php

namespace Develtio\ZonesHewalex\Shop\Products;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Single
 */
class ZH_Single
{
    /**
     * Hooks product
     */
    public function __construct()
    {
        //Hook: Single image product
        add_action('single_product_image', array($this, 'single_image'), 10);
        //Hook: Summary product
        add_action('single_product_summary', array($this, 'product_title'), 5);
        add_action('single_product_summary', array($this, 'product_price'), 10);
        add_action('single_product_summary', array($this, 'product_excerpt'), 15);
        //Hook: Product actions
        add_action('single_product_actions', array($this, 'startFormAddToCart'), 5);
        add_action('single_product_actions', array($this, 'product_quantity'), 10);
        add_action('single_product_actions', array($this, 'product_add_to_cart'), 20);
        add_action('single_product_actions', array($this, 'selectSize'), 25);
        add_action('single_product_actions', array($this, 'endFormAddToCart'), 25);
        //Hook: Product meta
        add_action('single_product_meta', array($this, 'product_sku'), 10);
        //Hook: Product tabs
        add_action('single_product_tabs', array($this, 'product_content'), 10);

    }

    /**
     * Hook: Single image product
     * 10 - single_image
     * @param $id
     */
    public function single_image($id)
    {
        $image = get_field('product_image', $id);
        $title = get_field('product_model',$id);
        if($image['url']){
        echo '
            <a class="lightbox" href="#popup">
                <img src="'. $image['url'] .'"/>
              </a> 
             <div class="lightbox-target" id="popup">
                <img src="'. $image['url'] .'"/>
              <a class="lightbox-close" href="#"></a>
                <h5>'. $title .'<h5>
              </div>';
        }
        else{
            echo '<img class="empty_img" src="' . ZH_URL . 'assets/img/logo.svg">';
         }
    }

    /**
     * Hook: Summary product
     * 5 - product_title
     * 10 - product_price
     * 15 - product_excerpt
     * @param $id
     */
    public function product_title($id)
    {
        $title = get_field('product_model', $id);
        echo '<h3>' .$title . '</h3>';
    }

    public function product_price($id)
    {
        
        $currency = '<span class="currency">zł</span>';
        $price = get_field('price_brutto', $id);
        echo '<div class="price"><span>Cena:</span>&nbsp;<strong>' . $price . $currency . '</strong></div>';
    }




    public function product_excerpt($id)
    {
        $excerpt = get_field('product_desc', $id);
        echo  '<div class="short_description">' . $excerpt . '</div>';
    }

    /**
     * Hook - Product actions
     * 10 - product_quantity
     * 20 - product_add_to_cart
     * @param $id
     */
    public function startFormAddToCart($id) {
        echo '<form method="POST" action="?action=add&code='. trim(get_field('ref_number', $id)) .'">';
    }


     /**
     * Hook - Product size
     * 10 - product_size
     * 20 - product_id
     * @param $id
     */

    public function selectSize($id)
    {
        // Pass ID
        update_field('prod_id', $id);
        $gotID = get_field('prod_id', $id);
        echo '<input type="hidden" value="' . $gotID . '" name="product_the_id"/>';

        // Select size
        $additionalSize = get_field('additional_size', $id);

        if($additionalSize){
            $setSize = get_field('radio_size', $id);
            
            if ($setSize == 'textable') {
                echo '<div class="select-group" id="product_get_size">
                        <select name="product_get_size">
                        <option value="">Wybierz rozmiar</option>
                        <option value="xs">XS</option>
                        <option value="s">S</option>
                        <option value="m">M</option>
                        <option value="l">L</option>
                        <option value="xl">XL</option>
                        <option value="xxl">XXL</option>
                        <option value="xxxl">XXXL</option>
                    </select>
                </div>';
            }
        
             if ($setSize == 'numerical') {
                echo 
                    '<div class="select-group" id="product_get_size">
                        <select name="product_get_size">
                            <option value="">Wybierz rozmiar</option>
                            <option value="48">48</option>
                            <option value="50">50</option>
                            <option value="52">52</option>
                            <option value="54">54</option>
                            <option value="56">56</option>
                            <option value="58">58</option>
                            <option value="60">60</option>
                            <option value="62">62</option>
                        </select>
                    </div>';
             }   
        }
    }



    public function product_quantity($id)
    {
        $image = get_field('product_image', $id);
        echo '    
            <div class="input-group">
            <input type="button" value="-" class="button-minus" data-field="quantity">
            <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field">
            <input type="button" value="+" class="button-plus" data-field="quantity">
        </div>
        ';
        echo '<input type="hidden" value="' . get_field('ref_number', $id) . '" name="ref_number"/>';
        echo '<input type="hidden" value="' . $image['url'] . '" name="product_image"/>';
        echo '<input type="hidden" value="' . get_field('product_model', $id) . '" name="product_model"/>';
        echo '<input type="hidden" value="' . get_field('price_brutto', $id) . '" name="price_brutto"/>';
        echo '<input type="hidden" name="add-to-cart" value="add-to-cart">';
    }

    public function product_add_to_cart($id)
    {
        echo '<input class="add-to-cart" type="submit" value="Dodaj do koszyka"/>';
    }

    public function endFormAddToCart($id) {
        echo '</form>';
    }

    /**
     * Hook: Product meta
     * 10 - product_sku
     * @param $id
     */
    public function product_sku($id)
    {
        $sku = get_field('ref_number', $id);
        echo '<div class="sku-field"><span>Numer:</span>&nbsp;<span class="sku">' . $sku .'</span></div>';
    }

    /**
     * Hook: Product tabs
     * 10 - product_content
     * 20 - product_additional_information
     * @param $id
     */
    public function product_content($id)
    {
        $content = get_field('product_desc', $id);
        echo '<div class="full_description">
        <div class="nav-tabs">
            <a class="active">Opis nagrody</a>
        </div>
        <div class="full_description__content">' . $content . '</div></div>';
    }

}