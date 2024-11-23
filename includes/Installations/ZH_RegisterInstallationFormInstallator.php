<?php

namespace Develtio\ZonesHewalex\Installations;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_RegisterInstallationFormInstallator
 */
class ZH_RegisterInstallationFormInstallator
{
    public function __construct()
    {
        add_shortcode( 'installations_installer', array($this, 'getRegisterInstalation') );
        add_shortcode( 'history_installations_installer', array($this, 'displayRegisterHistoryInstalation') );
        add_shortcode('oze_form_points', array($this, 'oze_home_points'));

    }

    public function getRegisterInstalation() {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'installation',
            'meta_query' => array(
                array(
                    'key' => 'installation_group4_installation_instalator',
                    'value' => true,
                    'compare' => 'LIKE'
                )
            ),
            'author'         => $this->getIdInstallator()
        );
        $installations = get_posts($args);

        echo '<div class="list-installer">
        <h2>Instalacje aktualne</h2>
        <table class="list-installer__table" style="width: 100%;border-collapse: collapse; margin-bottom: 30px;">';
        echo '<thead>';
            echo '<th>ID</th>';
            echo '<th>Data instalacji</th>';
            echo '<th>Dane użytkownika</th>';
            echo '<th>Rodzaj</th>';
            echo '<th>Numer</th>';
            echo '<th>Premia punktowa</th>';
            echo '<th>Efekt ekologiczny</th>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($installations as $key => $installation) {
            $id = $installation->ID;
            $key++;

            $args = array(
                'post_type' => 'solar_types_set',
                'title'     => get_field('installation_group2_installation_type', $id) ,
                'post_per_page' => 1
            );
            $types = get_posts($args);

            foreach($types as $type) {
                $id_type = $type->ID;
                $premia = get_field('points', $id_type);
                $efekt = get_field('ecology_effect', $id_type);
            }

                echo '<tr>';
                echo '<td>' . $key . '</td>';
                echo '<td>' . $installation->post_date . '</td>';
                echo '<td>' . (get_field('installation_group3_installation_connect', $id) ?
                        get_field('installation_group_installation_name', $id) .
                        get_field('installation_group_installation_surname', $id) .
                        get_field('installation_group_installation_address', $id) .
                        get_field('installation_group_installation_post_code', $id) .
                        get_field('installation_group_installation_city', $id) : "") . '</td>';
                echo '<td>' . get_field('installation_group2_installation_type', $id) . '</td>';
                echo '<td>' . get_field('installation_code', $id) . '</td>';

                if(get_field('installation_group2_installation_type', $id)) {
                    echo '<td>' . $premia . '</td>';
                    echo '<td>' . $efekt . '</td>';
                }
                else {
                    echo '<td>---</td>';
                    echo '<td>---</td>';
                }

                echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>
        </div>';
    }

    public function displayRegisterHistoryInstalation()
    {
        $installation_history = $this->getRegisterHistoryInstallation($this->getIdInstallator());

        echo '<div class="list-installer">
        <h2>Instalacje historyczne</h2>
        <table class="list-installer__table" style="width: 100%;border-collapse: collapse; margin-bottom: 30px;">';
        echo '<thead>';
            echo '<th>ID</th>';
            echo '<th>Data instalacji</th>';
            echo '<th>Dane użytkownika</th>';
            echo '<th>Rodzaj</th>';
            echo '<th>Numer</th>';
            echo '<th>Premia punktowa</th>';
            echo '<th>Efekt ekologiczny</th>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($installation_history as $key => $installation) {
            $id = $installation->ID;
            $key++;

            echo '<tr>';

                echo '<td>' . $key . '</td>';
                echo '<td>' . $installation->instalation_date_ins . '</td>';
                echo '<td>';
                    echo ($installation->instalation_access === '1') ? $installation->installation_name . ' ' . $installation->installation_surname : 'klient nie wyraził zgody';
                echo '</td>';
                echo '<td>';
                    echo $installation->kit_type_nazwa ? $installation->kit_type_nazwa : $installation->pump_type_nazwa;
                echo '</td>';
                echo '<td>';
                    echo $installation->installation_kit_nr ? $installation->installation_kit_nr : $installation->installation_pump_nr;
                echo '</td>';
                echo '<td>';
                    echo $installation->kit_type_punkty ? $installation->kit_type_punkty : $installation->pump_type_punkty;
                echo '</td>';
                echo '<td>brak danych</td>';

            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>
        </div>';
    }

    private function getRegisterHistoryInstallation($user_id)
    {
        global $wpdb;
        $nip = get_user_meta($user_id, 'installation_group1_installation_nip')[0];

        $sql = "SELECT * FROM installation WHERE installation_installator_nip LIKE {$nip}";
        $data = $wpdb->get_results($sql);

        return $data;
    }

    private function getIdInstallator()
    {
        if(!is_user_logged_in()){
            return;
        }

        $user = wp_get_current_user();
        return $user->ID;
    }

    public function oze_home_points() { ?>
        <div class="point_box">
            <h4>Numer zestawu</h4>
            <form id="number_set_form" action="#" method="POST" data-url="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                     
                        <input type="text" class="form-control" name="number_set" id="number_set" placeholder="Numer zestawu" />
                    </div>
                    <div class="form-group submit-group">
                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>Dodaj</button>
                    </div>
                </form>

            </div>
    <?php 

    }
}