<?php

namespace Develtio\ZonesHewalex\Shop\MyAccount;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Points
 */
class ZH_Points
{
    public function __construct()
    {
        add_shortcode('hewalex_points', array($this, 'displayPoints'));
    }

    public function displayPoints()
    {
        $points = $this->prepareDataToDisplay();
        usort($points, array($this, 'sortArrayByDate'));

        echo '<div class="hewalex-my-account">';
        echo '<div class="hewalex-my-account__orders">';
            echo '
                <div class="hewalex-my-account__points_row">
                    <div class="hewalex-my-account__points-col">
                    <h4>' . $this->calculateTotalsEffect() . 'kg CO<sup>2</sup></h4>
                    <p>Efekt ekologiczny</p>
                </div>';
            echo '
                <div class="hewalex-my-account__points-col">
                    <h4>' . $this->calculateTotalsPoints() . ' zł</h4>
                    <p>Premia punktowa</p>
                </div>
        </div>';

        echo '
            <div class="points_data">
                <table class="points_data__table table">
               
                    <thead>
                        <th>Lp.</th>
                        <th>Data</th>
                        <th>Opis</th>
                        <th>Efekt ekologiczny</th>
                        <th>Premia</th>
                    </thead>
                ';

                foreach($points as $key => $point) {
                    $desc = isset($point['description']) ? $point['description'] : '';
                    $date = isset($point['date']) ? $point['date'] : '';
                    $effect = isset($point['effect']) ? $point['effect'] : null;
                    $points_single = isset($point['points']) ? $point['points'] : null;

                    switch($desc){
                        case 'Zakupy':
                            $color = '#eee';
                            $color2 = '#1d1d1b';
                            break;
                        case 'Instalacja':
                            $color = '#47a447';
                            $color2 = '#fff';
                            break;
                        case 'Zasilenie karty płatniczej':
                            $color = '#ed9c28';
                            break;
                        default:
                            $color = '#efefe9';
                            $color2 = '#1d1d1b';
                            break;
                    }

                    if(get_current_user_id() === (int)$point['author']) {
                        echo '
                             <tr style="background-color: ' . $color . '">
                                 <td>' . ($key + 1) . '</td>
                                 <td>' . $point['date'] . '</td>
                                 <td>' . $point['description'] . '</td>
                                 <td>' . $point['effect'] . ' kg CO<sup>2</sup></td>
                                 <td>' . $point['points'] . ' zł</td>
                             </tr>           
                        ';
                    }
            }
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }

    public function prepareDataToDisplay()
    {
        $ordered_awards = $this->prepareDataFromOrderedAwards();
        $awards_products = $this->prepareDataFromInstallations();
        $ordered_credits = $this->prepareDataFromOrderedCredits();
        $merged_arrays = array_merge($ordered_awards, $ordered_credits, $awards_products);

        return $merged_arrays;
    }

    private static function sortArrayByDate( $a, $b ) {
        return strtotime($a['date']) < strtotime($b['date']);
    }

    public function prepareDataFromOrderedAwards()
    {
        $args = array(
            'author' => $this->getIdInstallator(),
            'posts_per_page' => -1,
            'post_type'      => 'ordered_awards',
        );
        $ordered_awards = get_posts($args);

        $ordered_awards_array = array();

        foreach($ordered_awards as $key => $item){
            $price = get_field('price', $item->ID);
            $date = $item->post_date;

            $ordered_awards_array[$key] = array(
                'date' => $date,
                'description' => 'Zakupy',
                'effect' => '',
                'points' => '-' . $price,
                'author' => (int)$item->post_author,
            );
        }

        return $ordered_awards_array;
    }

    public function prepareDataFromOrderedCredits()
    {
        $args = array(
            'author' => $this->getIdInstallator(),
            'posts_per_page' => -1,
            'post_type'      => 'ordered_credits',
        );
        $ordered_credits = get_posts($args);

        $ordered_credits_array = array();

        foreach($ordered_credits as $key => $item){
            $price = get_field('credits', $item->ID);
            $date = $item->post_date;

            $ordered_credits_array[$key] = array(
                'date' => $date,
                'description' => 'Zasilenie karty płatniczej',
                'points' => '-' . $price,
                'author' => (int)$item->post_author
            );
        }

        return $ordered_credits_array;
    }

    public function prepareDataFromInstallations()
    {
        $args = array(
            'author' => $this->getIdInstallator(),
            'posts_per_page' => -1,
            'post_type'      => 'installation',
        );
        $installations = get_posts($args);

        $installations_array = array();

        foreach ($installations as $key => $item) {
            $id_installations = $item->ID;
            $number_solar = get_field('installation_code', $id_installations);
            $type_solar = $this->getTypeByNumberSolar($number_solar);
            $type_solar_id = $type_solar->ID;

            $installations_array[$key] = array(
                'date' => $item->post_date,
                'description' => 'Instalacja',
                'effect' => get_field('ecology_effect', $type_solar_id),
                'points' => get_field('points', $type_solar_id),
                'author' => (int)$item->post_author,
            );
        }

        return $installations_array;
    }

    public function getTypeByNumberSolar($number)
    {
        $args = [
            'post_status'=> 'publish',
            'post_type'=>'solar_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'number_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];
        $args2 = [
            'post_status'=> 'publish',
            'post_type'=>'pump_numbers_set',
            'meta_query' => array(
                array(
                    'key' => 'pump_set',
                    'value' => $number,
                    'compare' => '='
                )
            )
        ];
        $number_set = get_posts($args);
        $pump_set = get_posts($args2);

        if(empty($number_set)){
            foreach($pump_set as $item){
                $type = get_field('type_set', $item->ID);
            }
        } else {
            foreach($number_set as $item){
                $type = get_field('type_set', $item->ID);
            }
        }

        return $type ?? null;
    }

    public function getIdInstallator()
    {
        $user = wp_get_current_user();
        return $user->ID;
    }


    public function calculateTotalsEffect()
    {
        $data = $this->prepareDataToDisplay();

        $effectPoints = 0;
        foreach($data as $item)
        {
            if(get_current_user_id() === (int)$item['author']){
                $effectPoints += $item['effect'];
            }
        }

        return $effectPoints;
    }

    public function calculateTotalsPoints()
    {
        $old_points = $this->prepareOldPoints();
        $result = (float)$this->preparePointsPlus() - (float)$this->preparePointsMinus() + $old_points;

        return $result;
    }

    public function preparePointsPlus()
    {
        $data = $this->getActiveInstallationsFromInstallator();

        foreach($data as $item) {
            $points += get_field('installation_group4_installation_points_active', $item->ID);
        }

        return $points;
    }

    public function preparePointsMinus()
    {
        $data = $this->getActiveInstallationsFromInstallator();

        foreach($data as $item) {
            $points += get_field('installation_group4_installation_points_purchase', $item->ID);
        }

        return $points;
    }

    public function prepareOldPoints()
    {
        global $wpdb;

        $user_id = get_current_user_id();
        $nip = get_user_meta($user_id, 'installation_group1_installation_nip', true);

        $data = $wpdb->get_results("SELECT * FROM points_installer_old WHERE `nip` = {$nip} AND `archive` = 0 LIMIT 1");

        $old_points_plus = floatval(str_replace(',', '.', $data[0]->results));
        $old_points_minus = floatval(str_replace(',', '.', $data[0]->purchase));

        return $old_points_plus - $old_points_minus;
    }

    public function getActiveInstallationsFromInstallator()
    {
        $args = [
            'post_type' => 'installation',
            'author' =>  $this->getIdInstallator(),
            'post_per_page' => -1,
            'post_status' =>  'publish',
            'meta_query'    => array(
                array(
                    'key' => 'installation_group4_installation_status',
                    'value'     =>  0,
                    'compare'   => '=',
                ),
            )
        ];

        return get_posts($args);
    }
}