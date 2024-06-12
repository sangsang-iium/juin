<?php
include_once("./_common.php");

$tb['title'] = '제휴서비스';
include_once("./_head.php");

//카테고리 추가
// $sql_and = '';
// $qacate = $_GET['qacate'];
// if($qacate){
//   $sql_cate = " select catename from shop_qa_cate where index_no = '$qacate' ";
//   $sql_cate_row = sql_fetch($sql_cate);
//   $sql_and = " and catename = '$sql_cate_row[catename]' ";
// }

// $sql_common = " from shop_qa ";
// $sql_search = " where mb_id = '$member[id]' ";
// $sql_order  = " order by wdate desc ";

// $sql = " select count(*) as cnt $sql_common $sql_search $sql_and ";
// $row = sql_fetch($sql);
// $total_count = $row['cnt'];

// $rows = 10;
// $total_page = ceil($total_count / $rows); // 전체 페이지 계산
// if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
// $from_record = ($page - 1) * $rows; // 시작 열을 구함

// $sql = " select * $sql_common $sql_search $sql_and $sql_order limit $from_record, $rows ";
// $result = sql_query($sql);

include_once(BV_MTHEME_PATH.'/affservice_list.skin.php');

include_once("./_tail.php");
?>