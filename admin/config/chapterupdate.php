<?php // 지부 Update Form _20240517_SY
include_once("./_common.php");

check_demo();

check_admin_token();

$db_table    = "kfia_office";
$branch_code = $_POST['branch_code'];
$office_code = preg_replace("/\s+/", "", $_POST['office_code']);
$office_name = preg_replace("/\s+/", "", $_POST['office_name']);
$auth_idx    = $_POST['auth_idx'];

$duChk_sql = " SELECT office_code, COUNT(*) AS cnt FROM kfia_office
                WHERE branch_code = '{$branch_code}' 
                  AND office_code = '{$office_code}' 
             ";
$duChk_row = sql_fetch($duChk_sql);

if($w == '') {

  if($duChk_row['cnt'] > 0) {
    alert("이미 등록되어 있는 정보입니다.", BV_ADMIN_URL."/config.php?$q1");
    die();
  } else {
    $db_insert['branch_code']  = $branch_code;
    $db_insert['office_code']  = $office_code;
    $db_insert['office_name']  = $office_name;
    $db_insert['auth_idx']     = $auth_idx;
    $db_insert['office_wdate'] = date('Y-m-d H:i:s');
    $db_insert['office_udate'] = date('Y-m-d H:i:s');
    
    $INSERT = new IUD_Model;
    $INSERT->insert($db_table, $db_insert);
    
    alert("신규 지부 정보가 등록되었습니다.", BV_ADMIN_URL."/config.php?code=chapter");
  }

} else if ($w == 'u') {
  $idx = $_POST['idx'];

  if($duChk_row['cnt'] > 0 && $duChk_row['office_idx'] != $idx) {
    alert("이미 등록되어 있는 정보입니다.", $_SERVER['HTTP_REFERER']);
    die();
  } else {
    $db_update['branch_code']  = $branch_code;
    $db_update['office_name']  = $office_name;
    $db_update['auth_idx']     = $auth_idx;
    $db_update['office_udate'] = date('Y-m-d H:i:s');
    $db_where = " WHERE office_idx = '{$idx}' ";

    $UPDATE = new IUD_Model;
    $UPDATE->update($db_table, $db_update, $db_where);

    alert("지부 정보가 수정되었습니다.", BV_ADMIN_URL."/config.php?$q1&w=u&idx=$idx");
  }
} 
