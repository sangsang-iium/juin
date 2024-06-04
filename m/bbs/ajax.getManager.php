<?php // 담당자 조회 _20240603_SY
include_once("./_common.php");


$mn_id = $_POST['mcode'];


$mn_sel = " SELECT * FROM shop_manager WHERE id LIKE '%{$mn_id}%' ";
$mn_res = sql_query($mn_sel);
$mn_cnt = sql_num_rows($mn_res);

$data = [];
if($mn_cnt > 0) {
  for($i=0; $mn_row = sql_fetch_array($mn_res); $i++) {
    $data[$i] = $mn_row;
  }
  $msg = "";
} else {
  $msg = "데이터 없음";
}

$res = $data;


echo json_encode(array("res" => $res, "msg" => $msg));