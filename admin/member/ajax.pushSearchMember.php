<?php
include_once "./_common.php";

$type  = $_POST['type'];
$words = $_POST['words'];

if($type == "key_name") {
  $allColumns = array("name");
} else if($type == "key_id") {
  $allColumns = array("id");
}

if(!empty(trim($words))) {
  $sql_search = allSearchSql($allColumns, $words);
  $sql_select = " index_no, name, id, grade, ju_region2, ju_region3, branch_name, office_name  ";

  $search_sel = " SELECT {$sql_select} FROM shop_member AS mm
               LEFT JOIN kfia_office AS ko
                      ON (mm.ju_region3 = ko.office_code)
               LEFT JOIN kfia_branch AS kb
                      ON (ko.branch_code = kb.branch_code)
                   WHERE (1) 
                         {$sql_search} 
                ORDER BY ju_region2, ju_region3, `name` ";
  $search_res = sql_query($search_sel);
  $search_cnt = sql_num_rows($search_res);

  $data = [];
  if($search_cnt > 0) {
    for($i=0; $search_row = sql_fetch_array($search_res); $i++) {
      $data[$i] = $search_row;
    }
    $msg = "";
  } else {
    $msg = "데이터 없음";
  }
} else {
  $data = null;
  $msg = "검색어를 입력하십시오.";
}

$res = $data;

echo json_encode(array("res" => $res, "msg" => $msg));