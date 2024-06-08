<?php // 담당자 _20240527_SY
include_once("./_common.php");


/* POST 값
  [token] => fcd84f7e807272cc5c9af75bed9de507
  [q1] => code=manager_register_form
  [page] => 
  [w] => 
  [manager_id] => sss
  [manager_pw] => 1234
  [manager_name] => aaaaaa
  [kf_region1] => 1
  [kf_region2] => 성동구지회
  [kf_region3] => 
*/
 
 
// check_demo();

// check_admin_token();

$db_table = "shop_manager";

$id       = trim($_POST['manager_id']);
$name     = trim($_POST['manager_name']);
$region1  = $_POST['ju_region1'];
$region2  = $_POST['ju_region2'];
$region3  = $_POST['ju_region3'];
// $auth_idx = $_POST['auth_idx'];

$now = date('Y-m-d H:i:s');


// 지역 코드 
$region_sql = " SELECT kf_idx, kf_code, auth_idx FROM kfia_region
                WHERE (1)
                  AND kf_region1 = '{$region1}'
                  AND kf_region2 = '{$region2}'
                  AND kf_region3 = '{$region3}'
              ";
$region_res = sql_fetch($region_sql);

// 권한
$auth_sql = "SELECT * FROM authorization WHERE auth_idx = '{$region_res['auth_idx']}'";
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
  $ins_data['ju_region_code'] = $region_res['kf_code'];
  $ins_data['region_idx']     = $region_res['kf_idx'];
 
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
  $upd_data['ju_region_code'] = $region_res['kf_code'];
  $upd_data['region_idx']     = $region_res['kf_idx'];
  $upd_where = " WHERE index_no = '{$idx}' ";

  $UPDATE = new IUD_Model;
  $UPDATE->update($db_table, $upd_data, $upd_where);

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