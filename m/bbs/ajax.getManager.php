<?php // 담당자 조회 _20240603_SY
include_once("./_common.php");


$mn_id = $_POST['mcode'];

// 쿼리 수정 _20240611_SY
$mn_sel = " SELECT sm.*, b.branch_idx, b.branch_code, b.branch_name, c.areacode, c.areaname, a.office_code, a.office_name, a.auth_idx
              FROM shop_manager sm
              LEFT JOIN kfia_branch b ON sm.ju_region2 = b.branch_code
              LEFT JOIN area c ON sm.ju_region1 = c.areacode
              LEFT JOIN kfia_office a ON sm.ju_region3 = a.office_code
              WHERE sm.id LIKE '%{$mn_id}%' GROUP BY index_no ";
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