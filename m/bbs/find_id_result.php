<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

// 본인인증 여부 확인 _20240705_SY
if(empty($cert_no)) { 
    alert("잘못된 접근입니다.");
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

$cnt_sql = " SELECT COUNT(*) AS cnt FROM {$db_table} WHERE cellphone = '{$cellphone}' ";
$cnt_row = sql_fetch($cnt_sql);
if($cnt_row['cnt'] > 1) {
    alert('동일한 휴대전화가 2개 이상 존재합니다.\\n\\n관리자에게 문의하여 주십시오.');
  exit;
}


$find_sel = " SELECT * FROM {$db_table} WHERE `name` = '{$_POST['find_name']}' AND cellphone = '{$cellphone}' ";
$find_row = sql_fetch($find_sel);

if($find_row) {
  // id 뒤에 3자리 마스킹
  $id = $find_row['id'];
  $id_length = strlen($id);
  $masked_id = substr($id, 0, $id_length - 3);
  $masked_id .= '***';
  $find_message = "회원님의 아이디 찾기가 완료 되었습니다. <br>
                   회원님의 아이디는 <strong id='userId'>{$masked_id}</strong> 입니다.
                  ";
} else {
  $find_message = "<strong>가입된 정보가 없습니다</strong>";
}


$tb['title'] = '아이디 찾기 결과';
include_once("./_head.php");

include_once(BV_MTHEME_PATH.'/find_id_result.skin.php');

include_once("./_tail.php");
?>