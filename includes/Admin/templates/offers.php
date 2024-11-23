<?php
$registration = new \Develtio\ZonesHewalex\Admin\templates\OffersTable();
echo '<h1 class="wp-heading-inline">Oferty i koszyki (historyczne)</h1>';
echo '<form method="post">';
$registration->prepare_items();
$registration->search_box('Szukaj','search_record');
$registration->display();
echo '</form>';