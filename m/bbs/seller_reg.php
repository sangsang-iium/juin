<?php
include_once("./_common.php");

if(!$config['seller_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', BV_MURL);
}

$tb['title'] = '온라인 입점안내';
include_once("./_head.php");
include_once(BV_MTHEME_PATH.'/seller_reg.skin.php');
include_once("./_tail.php");
?>