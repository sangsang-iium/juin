<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$tb['title'] = '아이디 찾기';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$form_action_url = BV_HTTPS_MBBS_URL."/password_lost2.php"; // <- 변경 필요(기본코드임)
include_once(BV_MTHEME_PATH.'/find_id.skin.php');

include_once("./_tail.php");
?>