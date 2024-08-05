<?php
include_once("./_common.php");

// mng > member GET으로 받도록 수정 _20240802_SY
if(isset($_GET['mb_id']) && !empty($_GET['mb_id'])) {
  $member['id'] = $_GET['mb_id'];
}

if(!$is_member) {
	alert_close("회원 전용 서비스입니다.");
}

// $tb['title'] = '배송지 찾기';
// include_once(BV_MPATH."/head.sub.php");

$sql_common = " from shop_order ";
$sql_search = " where mb_id = '{$member['id']}' ";
$sql_order  = " group by od_id order by od_time desc ";

$sql = " select COUNT(DISTINCT od_id) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * $sql_common $sql_search $sql_order ";
$result = sql_query($sql);

///home/juin/www/m/theme/basic/orderaddress.skin.php

include_once(BV_MTHEME_PATH.'/orderaddress.skin.php');

// include_once(BV_MPATH."/tail.sub.php");
?>