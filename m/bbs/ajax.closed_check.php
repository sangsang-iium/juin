<?php // 휴/폐업조회 _20240227_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];

// API 예시 결과값 기준으로 임시 작업 _20240227_SY
/** 휴/폐업 조회 API Response Data
 * b_no     : ( string ) 사업자등록번호
 * s_stt    : ( string ) 납세자상태_명칭(01:계속사업자, 02:휴업자, 03:폐업자)
 * b_stt_cd : ( string ) 납세자상태_코드(01:계속사업자, 02:휴업자, 03:폐업자)
 * end_dt   : ( string ) 폐업일 (YYYYMMDD)
 */
$res = [
  "b_bo"     => $b_no,
  "b_stt"    => "계속사업자",
  "b_stt_cd" => "01",
  "end_dt"   => "20240301"
];

$msg = "API 및 데이터 작업 필요";

echo json_encode(array("res" => $res, "msg" => $msg));