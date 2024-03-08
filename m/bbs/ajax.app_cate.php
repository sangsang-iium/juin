<?php // 앱 전송용 카페고리 _20240307_SY
// 안씀 _20240307_SY
include_once("./_common.php");

$data       = $_POST['data'];
$data_arr   = explode("=",$data);
$cate_table = $data_arr[0];
$idx        = $data_arr[1];

if($cate_table == "ca_id") {
  $cate_1st_depth = category_depth('1');
  // 1뎁스
  foreach($cate_1st_depth['cateArr'] as $key => $val ) {
    if($val == $idx) {
      $res = $cate_1st_depth['cateNameArr'][$key];
    }
  }
  
  // 2뎁스
  for($c=0; $c<count($cate_1st_depth['cateArr']); $c++) {
    $cate_2nd_depth[] = category_depth('2', $cate_1st_depth['cateArr'][$c]);
    foreach($cate_2nd_depth[$c]['cateArr'] as $key => $val) {
      if($val == $idx) {
        $res = $cate_2nd_depth[$c]['cateNameArr'][$key];
      }
    }
  }
  
} else if($cate_table == "gs_id") {
  $sel_sql = "SELECT * FROM shop_goods WHERE index_no = '{$idx}' ";
  $sel_row = sql_fetch($sel_sql);
  $res = $sel_row['gname'];
}
$msg = "카테고리";

// echo json_encode(array("res" => $res, "msg" => $msg));