<?php
include_once("./_common.php");

if(BV_IS_MOBILE) {
	goto_url(BV_MSHOP_URL.'/plan.php');
}

$tb['title'] = $default['de_pname_7'];
include_once("./_head.php");
include_once(BV_THEME_PATH.'/plan.skin.php');
include_once("./_tail.php");
?>