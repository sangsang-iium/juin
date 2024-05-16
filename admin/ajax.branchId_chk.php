<?php //지회 ID 중복체크 _20240516_SY
include_once "./_common.php";

$id        = preg_replace("/\s+/", "", $_POST['id']);
$db_table  = "kfia_region";
$sql_where = " AND kf_code = '{$id}' ";

$duChk_sel = " SELECT COUNT(*) AS cnt FROM {$db_table} WHERE (1) {$sql_where} ";
$duChk_row = sql_fetch($duChk_sel);

if($duChk_row['cnt'] > 0 ){
  header('HTTP/1.0 403 Forbidden');
  die();
} else {
  header('HTTP/1.0 200 OK');
}