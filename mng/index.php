<?php
include_once('../common.php');

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}


if (empty($ca_id)) {
  // 카테고리 코드 데이터 조회 및 준비
  $sql_cate_sel = "SELECT * FROM shop_category WHERE LENGTH(catecode) = 3";
  $res_cate_sel = sql_query($sql_cate_sel);
  $cateCodeArr  = array();
  while ($row_cate_sel = sql_fetch_array($res_cate_sel)) {
    $cateCodeArr[] = $row_cate_sel['catecode'];
  }

  // 카테고리 코드 데이터를 쉼표로 구분된 문자열로 변환
  $ca_id  = implode(',', $cateCodeArr);
  $ca_ids = $cateCodeArr;
} else {
  // 주어진 $ca_id에 쉼표가 포함되어 있는지 확인
  if (strpos($ca_id, ',') !== false) {
    $ca_ids = explode(",", $ca_id);
  } else {
    $ca_ids = array($ca_id); // 쉼표가 포함되어 있지 않은 경우 배열로 변환
  }
}

// 검색 조건 생성
$conditions = array();
foreach ($ca_ids as $ca_idx) {
  $conditions[] = "ca_id LIKE '$ca_idx%'";
  $conditions[] = "ca_id2 LIKE '$ca_idx%'";
  $conditions[] = "ca_id3 LIKE '$ca_idx%'";
}

// 생성된 조건을 OR 연산자로 묶음
$condition_string = implode(" OR ", $conditions);

// 최종 SQL 검색 조건 설정
$sql_search = "AND (" . $condition_string . ")";
if(!$paytype){
  $paytype = 2;
}
$sql_search .= "AND reg_yn = '{$paytype}'";


$sql = " select *
		   from shop_category
		  where catecode in({$ca_id})
		    and cateuse = '0'
			and find_in_set('$pt_id', catehide) = '0' ";
$ca = sql_fetch($sql);
if(!$ca['catecode'])
    alert('등록된 분류가 없습니다.');

$tb['title'] = $ca['catename'];
include_once("../_head.php");


// 검색 _20240415_SY
if($stx) {
  $sql_search .= " AND gname LIKE '%{$stx}%' ";
}


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

$sqlCnt      = " select * $sql_common";

$resCnt      = sql_query($sqlCnt);
$total_count = 0;
$cntIdxArr = array();
// 기본배송지 추가 _20240712_SY
$b_address = "";
$ad_row = getBaddressFun();
if(isset($ad_row['mb_id'])){
  $b_address = $ad_row['b_addr1'];
} else {
  $b_address = $member['addr1'];
}

while ($rowCntData = sql_fetch_array($resCnt)) {
  if (!memberGoodsAble($b_address, $rowCntData['zone'])) {
    continue;
  }
	$cntIdxArr[] = $rowCntData['index_no'];

  $total_count++;
}
$cntIdx = implode(",", $cntIdxArr);
if (count($cntIdxArr) > 0) {
  $sql_search2 = "AND index_no in ($cntIdx)";
} else {
  $sql_search2 = "";
}


$mod = 4; // 가로 출력 수
$rows = $page_rows ? (int)$page_rows : ($mod*10);
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common $sql_search2 $sql_order limit $from_record, $rows ";

$result = sql_query($sql);

include_once(BV_PATH.'/mng/skin/list.skin.php');
include_once("../_tail.php");
?>