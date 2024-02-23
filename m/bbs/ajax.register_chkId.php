<?php // 회원가입 아이디 중복검사 _20240223_SY
include_once("./_common.php");

$mem_sel = " SELECT * FROM shop_member WHERE id = '{$id}'; ";
$mem_res = sql_query($mem_sel);
$mem_num = sql_num_rows($mem_res);

if($mem_num > 0) {
  $msg = "reject";
} else {
  $msg = "pass";
}

echo json_encode(array("res" => $msg));