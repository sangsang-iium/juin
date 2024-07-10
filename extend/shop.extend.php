<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가

// 관리자페이지에서 사용
if(isset($_REQUEST['page_rows']) && $_REQUEST['page_rows']) {
	set_session('ss_page_rows', $_REQUEST['page_rows']);
}

//==============================================================================
// 가맹점 권한체크
//------------------------------------------------------------------------------
$pf_auth_good = false;
$pf_auth_pg   = false;

// 개별 상품판매
if($config['pf_auth_good'] == 2 || ($config['pf_auth_good'] == 3 && $member['use_good']))
	$pf_auth_good = true;

// 개별 결제연동
if($config['pf_auth_pg'] == 2 || ($config['pf_auth_pg'] == 3 && $member['use_pg']))
	$pf_auth_pg = true;

//==============================================================================
// 자주사용되는 선언
//------------------------------------------------------------------------------
// 게시판에서 사용되는 변수들
$gw_search_value = array("subject","writer_s","memo");
$gw_search_text = array("제목","작성자","내용");

// 상품 정렬탭
$gw_psort = array(
	array("readcount",  "desc", "인기상품순"),
	array("goods_price", "asc", "낮은가격순"),
	array("goods_price", "desc", "높은가격순"),
	// array("m_count", "desc", "후기많은순"),
	array("index_no", "desc", "최근등록순")
);

// 모바일 상품 정렬탭
$gw_msort = array(
	array("readcount",  "desc", "인기상품순"),
	array("goods_price", "asc", "낮은가격순"),
	array("goods_price", "desc", "높은가격순"),
	// array("m_count", "desc", "후기많은순"),
);

// 부관리자메뉴
$gw_auth = array(
	'회원관리',
	'가맹점관리',
	'공급사관리',
	'카테고리관리',
	'상품관리',
	'주문관리',
	'통계분석',
	'고객지원',
	'디자인관리',
	'환경설정'
);

// 상태
$gw_state = array(
	"0"=>"승인",
	"1"=>"대기",
	"2"=>"보류"
);

// 가맹점수수료 구분
$gw_ptype = array(
	"sale" => "판매수수료",
	"anew" => "추천수수료",
	"visit" => "접속수수료",
	"passive" => "본사적립",
	"payment" => "수수료정산"
);

// 상품진열상태
$gw_isopen = array(
	"1"=>"진열",
	"2"=>"품절",
	"3"=>"단종",
	"4"=>"중지"
);

// 주문단계
$gw_status = array(
	"1"=>"입금대기",
	"2"=>"입금완료",
	"3"=>"배송준비",
	"4"=>"배송중",
	"5"=>"배송완료",
	"6"=>"취소",
	"7"=>"반품",
	"18"=>"반품신청",
	"10"=>"반품완료",
	"8"=>"교환",
	"9"=>"취소신청",
	"17"=>"취소완료",   
	"11"=>"교환신청",
	"12"=>"교환완료",
	 "13"=>"강제입금",
	 "14"=>"강제입금완료",
	 "15"=>"강제출고",
	 "16"=>"강제출고완료",
	 "0"=>""
);

// 주문진행단계
/*
입금대기 => 입금완료, 취소
입금완료 => 배송준비, 환불
배송준비 => 배송중, 배송완료, 환불
배송중   => 배송완료
배송완료 => 반품, 교환
취소 => 단계변경 안됨(삭제만 가능)
환불 => 단계변경 안됨(삭제도 안됨)
반품 => 단계변경 안됨(삭제도 안됨)
교환 => 단계변경 안됨(삭제도 안됨)
*/
$gw_array_status = array(
	"1"=>array(2,6),
	"2"=>array(3,9),
	"3"=>array(4,5,9),
	"4"=>array(5),
	"5"=>array(7,8),
	"7"=>array(10),
	"8"=>array(12),
	"9"=>array(17),
	"18"=>array(10),
	"11"=>array(12),
);

// 쿠폰
$gw_usepart = array(
	"0"=>"전체상품에 사용가능",
	"1"=>"일부 상품만 사용가능",
	"2"=>"일부 카테고리만 사용가능",
	"3"=>"일부 상품에서는 사용불가",
	"4"=>"일부 카테고리에서는 사용불가"
);

$gw_star = array(
	"1"=>"매우불만족",
	"2"=>"불만족",
	"3"=>"보통",
	"4"=>"만족",
	"5"=>"매우만족"
);

// 메뉴바
// 메뉴바 주석 해제 함 _20240612_SY
$gw_menu = array(
	array($default['de_pname_1'],	"/" , $default['de_pname_use_1']),
	array($default['de_pname_2'],	"/shop/listtype.php?type=1&menu=sales", $default['de_pname_use_2']),
	// array($default['de_pname_2'],	"/shop/listtype.php?type=1", $default['de_pname_use_2']),
	// array($default['de_pname_3'],	"/shop/timesale.php?menu=timesale", $default['de_pname_use_3']),
	array($default['de_pname_3'],	"/shop/listtype.php?type=1", $default['de_pname_use_3']),
	array($default['de_pname_4'],		"/shop/listtype.php?type=3&menu=new", $default['de_pname_use_4']),
	array($default['de_pname_5'],	"/shop/listtype.php?type=4&menu=popular", $default['de_pname_use_5']),
	array($default['de_pname_6'],	"/shop/listtype.php?type=5&menu=recomm", $default['de_pname_use_6']),
	array($default['de_pname_7'],		"/shop/list.php?ca_id=005", $default['de_pname_use_7']),
	array($default['de_pname_8'],	"/shop/list.php?ca_id=006", $default['de_pname_use_8']),
	array($default['de_pname_9'],	"/shop/listtype.php?type=5", $default['de_pname_use_9']),
  array($default['de_pname_10'],	"/shop/listtype.php?type=3&menu=new", $default['de_pname_use_10']),
  array($default['de_pname_11'],	"/store/list.php?menu=store", $default['de_pname_use_11']),
  // 래플추가 _20240625_SY
  array($default['de_pname_12'],	"/raffle/list.php?menu=raffle", $default['de_pname_use_12']),
	// array($default['de_pname_1'],	"/" , $default['de_pname_use_1']),
	// array($default['de_pname_2'],	"/shop/listtype.php?type=1&menu=sales", $default['de_pname_use_2']),
	// array($default['de_pname_3'],	"/shop/listtype.php?type=2&menu=best", $default['de_pname_use_3']),
	// array($default['de_pname_4'],		"/shop/listtype.php?type=3&menu=new", $default['de_pname_use_4']),
	// array($default['de_pname_5'],	"/shop/listtype.php?type=4&menu=popular", $default['de_pname_use_5']),
	// array($default['de_pname_6'],	"/shop/listtype.php?type=5&menu=recomm", $default['de_pname_use_6']),
	// array($default['de_pname_7'],		"/shop/plan.php?menu=exhibition", $default['de_pname_use_7']),
	// array($default['de_pname_8'],	"/shop/timesale.php?menu=timesale", $default['de_pname_use_8']),
	// array($default['de_pname_9'],	"/raffle/list.php?menu=raffle", $default['de_pname_use_9']),
	// array($default['de_pname_10'],	"/used/list.php?menu=used", $default['de_pname_use_10']),
	// array($default['de_pname_11'],	"/store/list.php?menu=store", $default['de_pname_use_11']),
	// array($default['de_pname_12'],	"/service/list.php?menu=service", $default['de_pname_use_12']),
);


//==============================================================================
// 쇼핑몰 배너코드 정보
// array('코드', '가로사이즈',  '세로사이즈', '설명문구')
//------------------------------------------------------------------------------
// pc 배너코드
// 설정예시: $gw_pbanner['스킨명']
$gw_pbanner['basic'] = array(
	array('0',  '1000', '400', '[롤링] 메인 슬라이드'),
	array('1',  '1000',  '70', '[고정] 최상단 배너'),
	array('2',   '160',  '60', '[고정] 상단 > 로고좌측'),
	array('3',   '280', '400', '[고정] 메인 > 메인배너 하단 > 좌측'),
	array('4',   '420', '195', '[고정] 메인 > 메인배너 하단 > 가운데 상'),
	array('5',   '420', '195', '[고정] 메인 > 메인배너 하단 > 가운데 하'),
	array('6',  '1000', '200', '[고정] 메인 > 카테고리별 베스트 하단'),
	array('7',  '1920',    '', '[고정] 메인 > 신상품 하단 > 글자입력 배너 (배너 이미지 배경)'),
	array('8',   '480', '290', '[고정] 메인 > 인기상품 하단 > 상단 좌측'),
	array('9',   '200', '290', '[고정] 메인 > 인기상품 하단 > 상단 가운데'),
	array('10',  '690', '200', '[고정] 메인 > 인기상품 하단 > 하단 좌측'),
	array('11',  '300', '500', '[고정] 메인 > 인기상품 하단 > 우측'),
	array('90',   '80',    '', '[연속] 퀵메뉴 좌측'),
	array('100', '410', '410', '[롤링] 인트로 우측')
);

// 모바일 배너코드
// 설정예시: $gw_mbanner['스킨명']
$gw_mbanner['basic'] = array(
	array('0', '960', '120', '[고정] 최상단 배너'),
  array('1', '1392', '1055', '[롤링] 메인 상단 슬라이드'),
  array('2', '1392', '740', '[롤링/임시] 목록 상단 슬라이드')
);
?>