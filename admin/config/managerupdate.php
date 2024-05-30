<?php // 담당자 _20240527_SY
include_once("./_common.php");


/* POST 값
  [token] => fcd84f7e807272cc5c9af75bed9de507
  [q1] => code=manager_register_form
  [page] => 
  [w] => 
  [manager_id] => sss
  [manager_pw] => 1234
  [auth_idx] => 1
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
$auth_idx = $_POST['auth_idx'];

$now = date('Y-m-d H:i:s');

// 권한
$auth_sql = " SELECT * FROM authorization WHERE auth_idx = '$auth_idx' ";
$auth_res = sql_fetch($auth_sql);

$menuArr  = str_replace(',','',$auth_res['auth_menu']);
$menuArr  = explode("ADMIN_MENU", $menuArr);

foreach($menuArr as $key => $val) {
  if(!empty($val)) {
    $ins_data["auth_{$val}"] = 1;
  }
}

// 지역 코드 
$region_sql = " SELECT * FROM kfia_region
                WHERE (1)
                  AND kf_region1 = '{$region1}'
                  AND kf_region2 = '{$region2}'
                  AND kf_region3 = '{$region3}'
              ";
$region_res = sql_fetch($region_sql);

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
  $ins_data['auth_idx']       = $auth_idx;
 
  $INSERT = new IUD_Model;
  $INSERT->insert($db_table, $ins_data);
  
  $ins_idx = sql_insert_id();
  $msg  = "신규 담당자가 등록되었습니다.";
  $link = "/config.php?$q1&w=u&idx=$ins_idx";

} else if ($w == 'u') {

  $msg  = "지금은 이용하실 수 없습니다.";
  $link = "/config.php?$q1&w=u&idx=$idx";

} 

alert($msg, BV_ADMIN_URL.$link);