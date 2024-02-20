<?php
include_once("./_common.php");

$url = $_GET['url'];

// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if($is_member) {
    if($url)
        goto_url($url);
    else
        goto_url(BV_URL);
}

$tb['title'] = '로그인';
include_once("./_head.php"); 

$login_url        = login_url($url);
$login_action_url = BV_HTTPS_BBS_URL."/login_check.php";

include_once(BV_THEME_PATH.'/login.skin.php');

include_once("./_tail.php");
?>