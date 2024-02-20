<?php
include_once("./_common.php");

$tb['title'] = get_text($board['boardname']);
include_once("./_head.php");

if(!$is_member) { $member['grade'] = 99; }

if($board['list_priv'] < 99) {
	if($member['grade'] > $board['list_priv']) {
		alert('권한이 없습니다.');
	}
}

$add_search = "";
if($default['de_board_wr_use']) {
	$add_search = " and pt_id = '$pt_id' ";
}

$sql_common = " from shop_board_{$boardid} ";
$sql_search = " where btype = '2' {$add_search} ";

if($ca_name)
	$sql_search .= " and ca_name = '{$ca_name}' ";

if($sfl && $stx)
	$sql_search .= " and ($sfl like '%$stx%') ";

$sql_order  = " order by fid desc, thread asc ";

$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 15;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$bo_reply_limit = 6;
$bo_imgurl = BV_BBS_URL.'/skin/'.$board['skin'];
$usecate = explode("|", $board['usecate']);

if($board['skin'] == 'gallery') {
	include_once(BV_MTHEME_PATH.'/board_gallery.skin.php');
} else {
	include_once(BV_MTHEME_PATH.'/board_list.skin.php');
}

include_once("./_tail.php");
?>