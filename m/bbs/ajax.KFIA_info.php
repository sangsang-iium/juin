<?php // 외식산업중앙회 회원조회 _20240227_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];

// API 결과값이 2개 나온다는 가정하게 작업 _20240227_SY
$res = [];
for($i=0; $i<2; $i++) {
  $res[] = [
    "idx" => $i,
    "nm" => "회원이름영역_{$i}",
    "u_no" => "202402271423",
    "b_no" => "123-12-98765"
  ];
}

$msg = "외식업중앙회원 API 및 데이터 작업 필요";

echo json_encode(array("res" => $res, "msg" => $msg));