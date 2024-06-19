<?php // 지부 Update Form _20240517_SY
include_once("./_common.php");

check_demo();

// check_admin_token();

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

    // 권한 변경 _20240618_SY
    $auth_sql = "SELECT * FROM authorization WHERE auth_idx = '{$auth_idx}'";
    $auth_res = sql_fetch($auth_sql);

    $menuArr = str_replace(',', '', $auth_res['auth_menu']);
    $menuArr = explode("ADMIN_MENU", $menuArr);

    $menuArr = array_map('trim', $menuArr); // 배열 요소의 앞뒤 공백 제거

    // 기본값 설정
    $upd_data = [];
    foreach (range(1, 10) as $i) {
        $upd_data["auth_{$i}"] = 0;
    }

    // $menuArr의 값들에 대해 업데이트
    foreach ($menuArr as $val) {
      if (!empty($val) && is_numeric($val)) {
          $key = "auth_{$val}";
          if ($w == '') {
              $ins_data[$key] = 1;
          } else {
              $upd_data[$key] = 1;
          }
      }
  }
    // 매니저 검색
    $mn_sel = "SELECT * FROM shop_manager a
                 LEFT JOIN kfia_office b
                   ON a.ju_region3 = b.office_code
                WHERE b.office_idx = '{$idx}'";
    $mn_res = sql_query($mn_sel);
    if($mn_res){
      $MANAGER = new IUD_Model;
      while($mn_row = sql_fetch_array($mn_res)) {
        $mn_where = " WHERE index_no = '{$mn_row['index_no']}'";
        $MANAGER->update("shop_manager", $upd_data, $mn_where);
      }
    }

    $UPDATE = new IUD_Model;
    $UPDATE->update($db_table, $db_update, $db_where);

    // auth수정 시 담당자 권한 수정 필요 _20240618_SY

    alert("지부 정보가 수정되었습니다.", BV_ADMIN_URL."/config.php?$q1&w=u&idx=$idx");
  }
} 
