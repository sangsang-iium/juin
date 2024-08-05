<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$tb['title'] = '아이디 찾기';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

// type 추가 _20240705_SY
$type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : '2' ;

// $form_action_url = BV_HTTPS_MBBS_URL."/password_lost2.php"; // <- 변경 필요(기본코드임)
$form_action_url = BV_HTTPS_MBBS_URL."/find_id_result.php?type=".$type;
include_once(BV_MTHEME_PATH.'/find_id.skin.php');

// 본인인증 테스트용 _20240805_SY
// if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { 
//   include_once(BV_MTHEME_PATH.'/find_id.skin_forTest.php');
// } else {
//   include_once(BV_MTHEME_PATH.'/find_id.skin.php');
// }

include_once("./_tail.php");
?>