<?php // 권한UPDATE _20240523_SY
include_once("./_common.php");

// check_demo();

// check_admin_token();

print_r2($_POST);

echo in_array('r', $_POST['auth']['TEST1_01']);

$db_table   = "authorization";

$auth_title = preg_replace("/\s+/", "", $_POST['auth_title']);
$auth       = $_POST['auth'];

$auth_str = array();
foreach ($auth as $key => $permissions) {
  $result[] = $key . '||' . implode('', $permissions);
}
$output = implode(',', $result);

// 일단 INSERT 하지 뭐
if($w == '') {

  $db_insert['auth_title'] = $auth_title;
  $db_insert['auth_menu']  = $output;
  
  $INSERT = new IUD_Model;
  $INSERT->insert($db_table, $db_insert);
  
  // alert("등록", BV_ADMIN_URL."/config.php?code=branch");

}