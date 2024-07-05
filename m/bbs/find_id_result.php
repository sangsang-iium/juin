<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$tb['title'] = '아이디 찾기 결과';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

// 본인인증 여부 확인 _20240705_SY
if(empty($cert_no))  {
  alert("잘못된 접근 입니다.");
	exit;
}

// 입력값과 본인인증 값 비교 _20240705_SY
$cellphone = implode("-",$find_hp);
if($chk_hp != $cellphone) {
  alert("정보가 일치하지 않습니다.");
  exit;
}


// type == 1:담당직원 / 2:일반 / 3:공급사 
switch($type) {
  case '1':
    $db_table = "shop_manager";
    $login_link = BV_MBBS_URL."/login_mng.php";
    break;
  case '3':
    $db_table = "shop_manager";
    $login_link = BV_MBBS_URL."/login_seller.php";
    break;
  default:
    $db_table = "shop_member";
    $login_link = BV_MBBS_URL."/login.php";
    break;
}

$find_sel = " SELECT * FROM {$db_table} WHERE `name` = '{$_POST['find_name']}' AND cellphone = '{$cellphone}' ";
$find_row = sql_fetch($find_sel);
if($find_row) {
  $find_message = "회원님의 아이디 찾기가 완료 되었습니다.";
} else {
  $find_message = "가입되지 않은 아이디입니다.";
}


include_once(BV_MTHEME_PATH.'/find_id_result.skin.php');

include_once("./_tail.php");
?>