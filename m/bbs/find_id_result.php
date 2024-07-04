<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$tb['title'] = '아이디 찾기 결과';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

include_once(BV_MTHEME_PATH.'/find_id_result.skin.php');

include_once("./_tail.php");
?>