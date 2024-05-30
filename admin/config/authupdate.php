<?php // 권한UPDATE _20240523_SY
include_once("./_common.php");

// check_demo();

// check_admin_token();

$db_table   = "authorization";

$auth_title = preg_replace("/\s+/", "", $_POST['auth_title']);
$count      = count($_POST['auth']);

for($i=0; $i<$count; $i++) {
  $k = $_POST['auth'][$i];
  $cate[] = trim($_POST['auth_cate'][$k]);
}

$output = implode(',', $cate);
exit;

// $auth_str = array();
// foreach ($auth as $key => $permissions) {
//   $result[] = $key . '||' . implode('', $permissions);
// }
// $output = implode(',', $result);


// 일단 INSERT 하지 뭐
if($w == '') {

  $db_insert['auth_title'] = $auth_title;
  $db_insert['auth_menu']  = $output;
  
  $INSERT = new IUD_Model;
  $INSERT->insert($db_table, $db_insert);
  
  // alert("등록", BV_ADMIN_URL."/config.php?code=branch");

}