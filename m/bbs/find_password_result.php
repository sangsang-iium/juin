<?php
include_once("./_common.php");

if($is_member) {
    alert("이미 로그인중입니다.");
}

$token = md5(uniqid(rand(), true));

set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");
set_session("ss_hash_token", BV_HASH_TOKEN);

set_session("ss_token", $token);

// 본인인증 여부 확인 _20240705_SY
if(empty($cert_no)) { 
  alert("잘못된 접근입니다.");
}

// // 입력값과 본인인증 값 비교 _20240705_SY
$cellphone = implode("-",$find_hp);
if($chk_hp != $cellphone) { 
  alert("정보가 일치하지 않습니다."); 
exit; 
}


$db_table = "shop_member";
$login_link = BV_MBBS_URL."/login.php";

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

$find_sel = " SELECT * FROM {$db_table} WHERE id = '{$find_id}' AND cellphone = '{$cellphone}' AND `name` = '$find_name' ";
$find_row = sql_fetch($find_sel);

// find_row 조건문 추가 _20240805_SY
if($find_row) {

  // 임시비밀번호 발급
  $change_password = rand(100000, 999999);
  $lost_certify = get_encrypt_string($change_password);

  // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
  $mb_nonce = md5(pack('V*', rand(), rand(), rand(), rand()));

  // 임시비밀번호와 난수를 lost_certify 필드에 저장
  $sql = " UPDATE {$db_table} set lost_certify = '$mb_nonce $lost_certify' where id = '{$find_row['id']}' ";
  sql_query($sql);

  
  $form_action_url = BV_BBS_URL.'/password_lost_certify.php?type='.$type.'&mb_no='.$find_row['index_no'].'&mb_nonce='.$mb_nonce;
}


$tb['title'] = '비밀번호 찾기 결과';
include_once("./_head.php");

include_once(BV_MTHEME_PATH.'/find_password_result.skin.php');

include_once("./_tail.php");
?>