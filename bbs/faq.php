<?php
include_once("./_common.php");

if(BV_IS_MOBILE) {
	goto_url(BV_MBBS_URL.'/faq.php');
}

$tb['title'] = '자주묻는 질문';
include_once("./_head.php"); 
include_once(BV_THEME_PATH.'/faq.skin.php');
include_once("./_tail.php");
?>