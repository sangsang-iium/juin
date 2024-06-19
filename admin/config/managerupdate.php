<?php // 담당자 _20240527_SY
include_once("./_common.php");
 
check_demo();

check_admin_token();

$db_table = "shop_manager";

$id       = trim($_POST['manager_id']);
$name     = trim($_POST['manager_name']);
$region1  = $_POST['ju_region1'];
$region2  = $_POST['ju_region2'];
$region3  = $_POST['ju_region3'];
// $auth_idx = $_POST['auth_idx'];

$now = date('Y-m-d H:i:s');


// 지회/지부 SELECT 수정 _20240608_SY
if(!empty($region3)) {
  $sql_where .= " WHERE b.branch_code = '{$region2}' 
                  AND a.office_code = '{$region3}' 
                ";
  $type = "office";
} else {
  $sql_where .= " WHERE b.branch_code = '{$region2}' ";
  $type = "branch";
}

$region_res = getRegionFunc($type, $sql_where);

// 권한
$auth_sql = "SELECT * FROM authorization WHERE auth_idx = '{$region_res[0]['auth_idx']}'";
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

if($w == '') {

/** INSERT 항목
 * 1. 담당자 ID
 * 2. 담당자 PW
 * 3. 담당자 Name
 * 4. 담당자 권한
 * -> auth_1~10 같이 체크하면서 value 넣어 줘야 함
 * 5. 지역
 */

  $pw = trim($_POST['manager_pw']);

  $ins_data['id']              = $id;
  $ins_data['name']            = $name;
  $ins_data['passwd']          = get_encrypt_string($pw);
  $ins_data['grade']           = 2;
  $ins_data['reg_time']       = $now;
  $ins_data['ju_region1']     = $region1;
  $ins_data['ju_region2']     = $region2;
  $ins_data['ju_region3']     = $region3;
 
  $INSERT = new IUD_Model;
  $INSERT->insert($db_table, $ins_data);
  
  $ins_idx = sql_insert_id();
  $msg  = "신규 담당자가 등록되었습니다.";
  $link = "/config.php?$q1&w=u&idx=$ins_idx";

} else if ($w == 'u') {

  $pw = trim($_POST['manager_pw']);

  if(!empty($pw)) {
    $upd_data['passwd'] = get_encrypt_string($pw);
  }

  $upd_data['name']           = $name;
  $upd_data['ju_region1']     = $region1;
  $upd_data['ju_region2']     = $region2;
  $upd_data['ju_region3']     = $region3;
  $upd_where = " WHERE index_no = '{$idx}' ";

  $UPDATE = new IUD_Model;
  $UPDATE->update($db_table, $upd_data, $upd_where);

  // 회원 검색 _20240618_SY
  $mm_sel = "SELECT * FROM shop_member WHERE ju_manager = '{$idx}'";
  $mm_res = sql_query($mm_sel);
  if($mm_res){
    $mm_upd['ju_region1'] = $region1;
    $mm_upd['ju_region2'] = $region2;
    $mm_upd['ju_region3'] = $region3;

    $MANAGER = new IUD_Model;
    while($mm_row = sql_fetch_array($mm_res)) {
      $mm_where = " WHERE index_no = '{$mm_row['index_no']}'";
      $MANAGER->update("shop_member", $mm_upd, $mm_where);
    }
  }

  $msg  = "담당자 정보가 수정되었습니다.";
  $link = "/config.php?$q1&w=u&idx=$idx";

} else if($w == 'd') {

  $idx = $_GET['idx'];

  // 회원 체크 
  $mem_chk_sql = " SELECT COUNT(*) AS cnt FROM shop_member WHERE ju_manager = '{$idx}' ";
  $mem_chk_row = sql_fetch($mem_chk_sql);

  if($mem_chk_row['cnt'] > 0) {
    $msg = "해당 담당자가 배정된 회원이 있으면 삭제할 수 없습니다.";
  } else {
    $del_where = " WHERE index_no = '{$idx}' ";
    
    $DELETE = new IUD_Model;
    $DELETE->delete($db_table, $del_where);
    $msg = "담당자 삭제 완료";

  }

  $link = "/config.php?code=manager_list";

}

alert($msg, BV_ADMIN_URL.$link);