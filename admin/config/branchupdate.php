<?php // 지회 Update Form _20240516_SY
include_once("./_common.php");

check_demo();

check_admin_token();

$db_table    = "kfia_branch";
$branch_code = preg_replace("/\s+/", "", $_POST['branch_code']);
$area_idx    = $_POST['area_idx'];
$branch_name = preg_replace("/\s+/", "", $_POST['branch_name']);
$now_date = date('Y-m-d H:i:s');

$duChk_sql = " SELECT branch_code, COUNT(*) AS cnt FROM kfia_branch 
                WHERE area_idx    = '{$area_idx}' 
                  AND branch_name = '{$branch_name}' 
             ";
$duChk_row = sql_fetch($duChk_sql);

if($w == '') {

  if($duChk_row['cnt'] > 0) {
    alert("이미 등록되어 있는 정보입니다.", BV_ADMIN_URL."/config.php?$q1");
    die();
  } else {
    $db_insert['branch_code']  = $branch_code;
    $db_insert['area_idx']     = $area_idx;
    $db_insert['branch_name']  = $branch_name;
    $db_insert['branch_wdate'] = $now_date;
    $db_insert['branch_udate'] = $now_date;
    
    $INSERT = new IUD_Model;
    $INSERT->insert($db_table, $db_insert);
    
    alert("신규 지회 정보가 등록되었습니다.", BV_ADMIN_URL."/config.php?code=branch");
  }

} else if ($w == 'u') {
  $idx = $_POST['idx'];

  if($duChk_row['cnt'] > 0 && $duChk_row['branch_idx'] != $idx) {
    alert("이미 등록되어 있는 정보입니다.", $_SERVER['HTTP_REFERER']);
    die();
  } else {
    // 수정 _20240610_SY
    $db_where = " WHERE branch_idx = '{$idx}' ";
    $data_sel = " SELECT * FROM {$db_table} {$db_where}";
    $data_row = sql_fetch($data_sel);
    $db_update['area_idx']     = $area_idx;
    $db_update['branch_name']  = $branch_name;
    $db_update['branch_udate'] = $now_date;
    
    $UPDATE = new IUD_Model;
    $UPDATE->update($db_table, $db_update, $db_where);

    alert("지회 정보가 수정되었습니다.", BV_ADMIN_URL."/config.php?$q1&w=u&idx=$idx");
  }
} 
