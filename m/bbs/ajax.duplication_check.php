<?php // 사업자번호 중복체크 _20240227_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];
$b = substr($b_no,0,3).'-'.substr($b_no,3,2).'-'.substr($b_no,-5);


$du_sel = " SELECT * FROM shop_member WHERE ju_b_num = '{$b}' ";
$du_res = sql_query($du_sel);
$du_cnt = sql_num_rows($du_res);

$msg = "사업자등록번호 중복 확인";
$res = $du_cnt;


echo json_encode(array("res" => $res, "msg" => $msg));