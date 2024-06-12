<?php //검색어 등록 _20240612_SY
include_once("./_common.php");

check_demo();

check_admin_token();

$url = BV_ADMIN_URL."/goods.php?$q1&page=$page";

if(empty(trim($_POST['pp_name']))) {
  alert("검색어를 1글자 이상 입력하여 주십시오.", $url);
}

$pp_word = trim($_POST['pp_name']);


$db_table = "shop_popular";

// 검색어 중목 체크
$du_chk = " SELECT COUNT(*) as cnt FROM {$db_table} WHERE pp_word = '{$pp_word}' ";
$du_row = sql_fetch($du_chk);

if($du_row['cnt'] > 0 ){
  alert("이미 등록된 검색어입니다.", $url);
  exit;
}


$ins_date['pt_id']   = $member['id'];
$ins_date['pp_word'] = $pp_word;
$ins_date['pp_date'] = date('Y-m-d');
$ins_date['pp_ip']   = $member['login_ip'];

$INSERT = new IUD_Model;
$INSERT->insert($db_table, $ins_date);

alert("신규 검색어 등록", $url);

?>