<?php // 지회 Update Form _20240516_SY
include_once("./_common.php");

// check_demo();

// check_admin_token();

$db_table   = "kfia_region";
$kf_code    = preg_replace("/\s+/", "", $_POST['branch_id']);
$kf_region1 = $_POST['kf_region1'];
$kf_region2 = preg_replace("/\s+/", "", $_POST['kf_region2']);
$now_date = date('Y-m-d H:i:s');

$duChk_sql = " SELECT kf_idx, COUNT(*) AS cnt FROM kfia_region 
                WHERE kf_region1 = '{$kf_region1}' 
                  AND kf_region2 = '{$kf_region2}' 
             ";
$duChk_row = sql_fetch($duChk_sql);

if($w == '') {

  if($duChk_row['cnt'] > 0) {
    alert("이미 등록되어 있는 정보입니다.", BV_ADMIN_URL."/config.php?$q1");
    die();
  } else {
    $db_insert['kf_code']    = $kf_code;
    $db_insert['kf_region1'] = $kf_region1;
    $db_insert['kf_region2'] = $kf_region2;
    $db_insert['kf_wdate']   = $now_date;
    $db_insert['kf_udate']   = $now_date;
    
    $INSERT = new IUD_Model;
    $INSERT->insert($db_table, $db_insert);
    
    alert("신규 지회 정보가 등록되었습니다.", BV_ADMIN_URL."/config.php?code=branch");
  }

} else if ($w == 'u') {
  $idx = $_POST['idx'];

  if($duChk_row['cnt'] > 0 && $duChk_row['kf_idx'] != $idx) {
    alert("이미 등록되어 있는 정보입니다.", $_SERVER['HTTP_REFERER']);
    die();
  } else {
    // 수정 _20240521_SY
    $db_where = " WHERE kf_idx = '{$idx}' ";
    $data_sel = " SELECT * FROM {$db_table} {$db_where}";
    $data_row = sql_fetch($data_sel);
    $upd_sql = " UPDATE {$db_table}
                    SET kf_region1 = '{$kf_region1}', 
                        kf_region2 = '{$kf_region2}',
                        kf_udate   = '{$now_date}'
                  WHERE kf_region1 = '{$data_row['kf_region1']}' 
                    AND kf_region2 = '{$data_row['kf_region2']}' 
               ";
    $upd_res = sql_query($upd_sql);

    alert("지회 정보가 수정되었습니다.", BV_ADMIN_URL."/config.php?$q1&w=u&idx=$idx");
  }
} 
