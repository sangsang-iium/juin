<?php // 담당자 _20240527_SY
include_once("./_common.php");

// check_demo();

// check_admin_token();

print_r2($_POST);

// 권한 체크
$auth_sql = " SELECT * FROM authorization WHERE auth_idx = {$_POST['auth_idx']} ";
$auth_res = sql_query($auth_sql);




if($w == '') {


  

} else if ($w == 'u') {



} 
