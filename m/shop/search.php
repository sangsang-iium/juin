<?php
include_once("./_common.php");

$ss_tx = trim(strip_tags($ss_tx));
if(!$ss_tx) {
	alert('검색어가 넘어오지 않았습니다.');
}

$tb['title'] = '상품 검색 결과';
include_once("./_head.php");

$concat = array();
$concat[] = "a.gname";
$concat[] = "a.explan";
$concat[] = "a.gcode";
$concat_fields = "concat(".implode(",' ',",$concat).")";

// 인기검색어
if($_POST['hash_token'] && BV_HASH_TOKEN == $_POST['hash_token']) {
	insert_popular($pt_id, $ss_tx);
}

$sql_search = " and ( $concat_fields like '%$ss_tx%' or find_in_set('$ss_tx', a.keywords) >= 1 ) ";
$sql_common = sql_goods_search($sql_search);

// 상품 정렬
if($sort && $sortodr)
	$sql_order = " order by a.{$sort} {$sortodr}, a.index_no desc ";
else
	$sql_order = " order by a.index_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(a.index_no) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];


$sql_search2 = "";
$sqlCnt      = " select a.* $sql_common $sql_order";
$resCnt      = sql_query($sqlCnt);
$total_count = 0;
$cntIdxArr   = array();
while ($rowCntData = sql_fetch_array($resCnt)) {

	// 기본배송지 추가 _20240712_SY
	$b_address = "";
	$ad_row    = getBaddressFun();
	if (isset($ad_row['mb_id'])) {
		$b_address = $ad_row['b_addr1'];
	} else {
		$b_address = $member['addr1'];
	}

	if (!memberGoodsAble($b_address, $rowCntData['zone'])) {
		continue;
	}
	$cntIdxArr[] = $rowCntData['index_no'];

	$total_count++;
}
$cntIdx = implode(",", $cntIdxArr);

if (count($cntIdxArr) > 0) {
	$sql_search2 = "AND a.index_no in ($cntIdx)";
} else {
	$sql_search2 = "";
}

$mod = 2; // 가로 출력 수
$rows = ($mod*9);
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.* $sql_common $sql_search2 $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

include_once(BV_MTHEME_PATH.'/search.skin.php');

include_once("./_tail.php");
?>