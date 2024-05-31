<?php // 권한 UPDATE _20240523_SY
include_once("./_common.php");

check_demo();

check_admin_token();

$db_table   = "authorization";

$auth_title = preg_replace("/\s+/", "", $_POST['auth_title']);
$count      = count($_POST['auth']);

for($i=0; $i<$count; $i++) {
  $k = $_POST['auth'][$i];
  $cate[] = trim($_POST['auth_cate'][$k]);
}

$output = implode(',', $cate);


if($w == '') {

  $db_insert['auth_title'] = $auth_title;
  $db_insert['auth_menu']  = $output;
  
  $INSERT = new IUD_Model;
  $INSERT->insert($db_table, $db_insert);

  $msg = "{$auth_title} 권한이 등록되었습니다.";

} else if($w == 'u') {

  $auth_idx = $_POST['idx'];
  $auth_where = " WHERE auth_idx = {$auth_idx} ";

  $db_update['auth_title'] = $auth_title;
  $db_update['auth_menu']  = $output;

  $UPDATE = new IUD_Model;
  $UPDATE->update($db_table, $db_update, $auth_where);

  $msg = "{$auth_title} 권한이 수정되었습니다.";

} else if($w == 'd') {

  $auth_idx = $_GET['idx'];

  // 사용중인 담당자 여부 체크
  $mng_chk_sql = " SELECT COUNT(*) as cnt FROM shop_manager WHERE auth_idx = '{$auth_idx}' ";
  $mng_chk_row = sql_fetch($mng_chk_sql);

  if($mng_chk_row['cnt'] > 0) {
    $msg = "해당 권한을 부여 받은 담당자가 있으면 삭제할 수 없습니다.";
  } else {
    $auth_where = " WHERE auth_idx = {$auth_idx} ";

    $DELETE = new IUD_Model;
    $DELETE->delete($db_table, $auth_where);
    $msg = "권한 삭제 완료";
  }

}

alert($msg, BV_ADMIN_URL."/config.php?code=authorization_list");