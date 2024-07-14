<?php // manager용 로그인 신규 생성 _20240524_SY
include_once("./_common.php");

$url = $_GET['url'];


// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if($is_member) {
  $url = BV_URL."/admin/";
    if($url)
        goto_url($url);
    else
        goto_url(BV_MURL);
}

$tb['title'] = "로그인";
include_once("./_head.php");

$login_url        = login_url($url);
$login_action_url = BV_HTTPS_MBBS_URL."/login_check_mng.php";

include_once(BV_MTHEME_PATH.'/login_mng.skin.php');

include_once("./_tail.php");
?>