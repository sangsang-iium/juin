<?php // 사업자번호 중복체크 _20240227_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];


$res = [];

$msg = "DB 데이터 조회 작업 필요";

$du_sel = " SELECT * FROM shop_member WHERE ju_b_num = '{$b_no}' ";
$du_res = sql_query($du_sel);
$du_cnt = sql_num_rows($du_res);


echo json_encode(array("res" => $res, "msg" => $msg));