<?php // 이메일 중복체크 _20240319_SY
include_once("./_common.php");


$mem_sel = " SELECT * FROM shop_member WHERE email = '{$email}'; ";
$mem_res = sql_query($mem_sel);
$mem_num = sql_num_rows($mem_res);

if($mem_num > 0) {
  $msg = "reject";
} else {
  $msg = "pass";
}

echo json_encode(array("res" => $msg));