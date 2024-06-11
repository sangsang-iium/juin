<?php
include_once("./_common.php");

$od_pwd = get_encrypt_string($od_pwd);

// 회원인 경우
if($is_member)
    $sql_common = " rl.*, rf.* from shop_goods_raffle_log as rl JOIN shop_goods_raffle as rf on rl.raffle_index = rf.index_no where rl.mb_id = '{$member['id']}' ";
else // 그렇지 않다면 로그인으로 가기
    goto_url(BV_MBBS_URL.'/login.php');

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt FROM shop_goods_raffle_log WHERE mb_id = '{$member['id']}' ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];


$rows = 10;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if($from_record < 0) {
  $from_record = 0;
}

$sql_order = " order by rf.index_no desc ";

$sql = " select $sql_common $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$tb['title'] = '레플조회';
include_once("./_head.php");

include_once(BV_MTHEME_PATH."/raffleList.skin.php");
include_once("./_tail.php");
?>