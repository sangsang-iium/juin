<?php // 지부 Update Form _20240517_SY
include_once("./_common.php");


check_demo();

check_admin_token();

$db_table   = "kfia_region";
$kf_code    = preg_replace("/\s+/", "", $_POST['chapter_id']);
$kf_region1 = $_POST['kf_region1'];
$kf_region2 = $_POST['kf_region2'];;
$kf_region3 = preg_replace("/\s+/", "", $_POST['kf_region3']);

$duChk_sql = " SELECT kf_idx, COUNT(*) AS cnt FROM kfia_region 
                WHERE kf_region1 = '{$kf_region1}' 
                  AND kf_region2 = '{$kf_region2}' 
                  AND kf_region3 = '{$kf_region3}' 
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
    $db_insert['kf_region3'] = $kf_region3;
    $db_insert['kf_wdate']   = date('Y-m-d H:i:s');
    $db_insert['kf_udate']   = date('Y-m-d H:i:s');
    
    $INSERT = new IUD_Model;
    $INSERT->insert($db_table, $db_insert);
    
    alert("신규 지부 정보가 등록되었습니다.", BV_ADMIN_URL."/config.php?code=chapter");
  }

} else if ($w == 'u') {
  $idx = $_POST['idx'];

  if($duChk_row['cnt'] > 0 && $duChk_row['kf_idx'] != $idx) {
    alert("이미 등록되어 있는 정보입니다.", $_SERVER['HTTP_REFERER']);
    die();
  } else {
    $db_update['kf_region1'] = $kf_region1;
    $db_update['kf_region2'] = $kf_region2;
    $db_update['kf_region3'] = $kf_region3;
    $db_update['kf_udate']   = date('Y-m-d H:i:s');
    $db_where = " WHERE kf_idx = '{$idx}' ";

    $UPDATE = new IUD_Model;
    $UPDATE->update($db_table, $db_update, $db_where);

    alert("지부 정보가 수정되었습니다.", BV_ADMIN_URL."/config.php?$q1&w=u&idx=$idx");
  }
} 
