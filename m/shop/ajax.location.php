<?php
include_once "./_common.php";

$lat = $_POST['lat'];
$lon = $_POST['lon'];

set_session('app_lat', $lat);
set_session('app_lng', $lon);

get_session('app_lat');
get_session('app_lng');

log_write($lat.'@@@'.get_session('app_lat') );
