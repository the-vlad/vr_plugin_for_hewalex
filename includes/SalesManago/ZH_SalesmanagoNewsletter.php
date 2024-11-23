<?php 

namespace Develtio\ZonesHewalex\SalesManago;

use Develtio\ZonesHewalex\SalesManago\ZH_Salesmanago;


if (!defined('ABSPATH')) {
    die;
}


 /**
 * Class ZH_SalesmanagoNewsletter
 */

 class ZH_SalesmanagoNewsletter {
    
    public function __construct() {
        add_shortcode( 'sm_newsletter', array($this, 'newsletter_form' ));
      
    }

    public function newsletter_form() {
        // echo "
       ?>
        <a class='newsletter_title_footer'><?php  pll_e('ZAPISZ SIĘ DO NEWSLETTERA'); ?></a>
            <p class='small-text'>
               <?php pll_e('Śledź na bieżąco nowości i informacje dotyczące naszych produktów. Wprowadź swój adres e-mail i zapisz się do listy mailingowej'); ?>
            </p>
            <div id='success-message'></div>
            <form id='sm-newsletter' action='". esc_url( admin_url('admin-ajax.php') ) . "'  method='post'>
                <input type='email' name='email' id='email' required>
                <input type='hidden' name='action' value='newsletter'>
                <input type='submit' id='sm-submit' name='sm-submit' value=''>
                <label class='submit-btn'></label>
                <label class='sm-gdpr' for='sm-gdpr'>
                <input name='sm-terms' type='checkbox' value='1' id='sm-terms' required>
                <span class='small-text'><?php pll_e('Wyrażam zgodę na otrzymanie informacji od Hewalex Sp. z o.o. Sp.k. za pośrednictwem maila. Mam prawo cofnąć zgodę w każdym czasie'); ?>
                </span>
              </label>
            </form>
            <?php
    }
}
