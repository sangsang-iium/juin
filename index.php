<?php
include_once('./common.php');

// 모바일접속인가?
if(BV_IS_MOBILE) {
	goto_url(BV_MURL);
}

define('_INDEX_', true);

// 인트로를 사용중인가?
if(!$is_member && $config['shop_intro_yes']) {
	include_once(BV_THEME_PATH.'/intro.skin.php');
    return;
}

include_once(BV_PATH.'/head.php'); // 상단
include_once(BV_THEME_PATH.'/main.skin.php'); // 메인
include_once(BV_PATH.'/tail.php'); // 하단
?>