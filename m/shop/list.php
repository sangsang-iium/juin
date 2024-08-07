<?php
include_once("./_common.php");

$sql = " select *
		   from shop_category
		  where catecode = '$ca_id'
		    and cateuse = '0'
			and find_in_set('$pt_id', catehide) = '0' ";
$ca = sql_fetch($sql);
if(!$ca['catecode'])
    alert('등록된 분류가 없습니다.');

// 회원 등급에 따른 카테고리 노출 처리
if($ca['exposure'] < $member['grade'] && $ca['exposure'] != 0){
	alert("외식업중앙회 회원 전용 서비스 입니다.");
}

$tb['title'] = $ca['catename'];
include_once("./_head.php");

$sql_search = " and (ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%') ";
// $sql_search .= "AND reg_yn = '2'";
$sql_common = sql_goods_list($sql_search);

// 상품 정렬
if($sort && $sortodr)
	$sql_order = " order by {$sort} {$sortodr}, rank desc, index_no desc ";
else
	$sql_order = " order by rank desc, index_no desc ";

// 테이블의 전체 레코드수만 얻음
// $sql = " select count(*) as cnt $sql_common ";
// $row = sql_fetch($sql);
// $total_count = $row['cnt'];

$sqlCnt = " select * $sql_common $sql_order";
$resCnt = sql_query($sqlCnt);
$total_count = 0;
$cntIdxArr = array();

// 기본배송지 추가 _20240712_SY
$b_address = "";
$ad_row = getBaddressFun();

while($rowCntData = sql_fetch_array($resCnt)){

	if(isset($ad_row['mb_id'])){
    $b_address = $ad_row['b_addr1'];
  } else {
    $b_address = $member['addr1'];
  }

	if(!memberGoodsAble($b_address, $rowCntData['zone'])){
		continue;
	}
	$cntIdxArr[] = $rowCntData['index_no'];

	$total_count++;
}

$cntIdx = implode(",", $cntIdxArr);
if(count($cntIdxArr) > 0){
	$sql_search2 = "AND index_no in ($cntIdx)";
}else {
	$sql_search2 = "";
}


$mod = 2; // 가로 출력 수
$rows = ($mod*9);
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common $sql_search2 $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

include_once(BV_MTHEME_PATH.'/list.skin.php');

include_once("./_tail.php");
?>
