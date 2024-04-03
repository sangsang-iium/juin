<?php // 중앙회 회원 엑셀 파일 비번 암호화 작업용 _240403_SY
include_once("./_common.php");


$db_table = "shop_member";
$sel_sql = "SELECT * FROM {$db_table} WHERE index_no > 25 ";
$sel_res = sql_query($sel_sql);

$PW_UPDATE = new IUD_Model;

while($row = sql_fetch_array($sel_res)) {
  $upd['passwd'] = $newPw = call_user_func(BV_STRING_ENCRYPT_FUNCTION, $row['passwd']) ;
  
  $upd_where = " WHERE id = '{$row['id']}'";
  $PW_UPDATE->update($db_table, $upd, $upd_where);
}