<?php
$registration = new \Develtio\ZonesHewalex\Admin\templates\InstallationsTable();
echo '<h1 class="wp-heading-inline">Instalacje historyczne</h1>';
echo '<form method="post">';
$registration->prepare_items();
$registration->search_box('Szukaj','search_record');
$registration->display();
echo '</form>';