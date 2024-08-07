<?php
include_once("./_common.php");

if(!$is_member) {
    if(get_session('ss_orderview_uid') != $_GET['uid'])
        alert("직접 링크로는 주문서 조회가 불가합니다.\\n\\n주문조회 화면을 통하여 조회하시기 바랍니다.", BV_URL);
}

if ($reg_yn == 1 ) {
	if(strpos($od_id, '_') !== false){
 	 $shop_table = "shop_order";
	} else {
		$shop_table = "shop_order_reg";
	}
} else {
  $shop_table = "shop_order";
}
// 가상계좌 불러오기위함 jjh 20240521
$od1 = sql_fetch("select * from {$shop_table} where od_id = '$od_id'");

if($od1['paymethod'] == '무통장'){
	$JOIN = "left JOIN toss_virtual_account b";
} else {
	$JOIN = "left JOIN toss_transactions b";
}

$sqlOd = "SELECT * FROM {$shop_table} a
					$JOIN
					ON ( a.od_id = b.orderId )
					WHERE a.od_id = '{$od_id}'";
$od = sql_fetch($sqlOd);
if(!$od['od_id'] || (!$is_member && md5($od['od_id'].$od['od_time'].$od['od_ip']) != get_session('ss_orderview_uid'))) {
    alert("조회하실 주문서가 없습니다.");
}

$tb['title'] = '주문상세내역';
include_once("./_head.php");

// LG 현금영수증 JS
if($od['od_pg'] == 'lg') {
    if($default['de_card_test']) {
		echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    } else {
        echo '<script language="JavaScript" src="http://pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js"></script>'.PHP_EOL;
    }
}

if ($reg_yn == 1) {
	if (strpos($od_id, '_') !== false) {
		$stotal = get_order_spay($od_id); // 총계
		$sql = " select SUM(goods_price) as price,
					SUM(baesong_price) as baesong,
					SUM(goods_price + baesong_price) as buyprice,
					SUM(supply_price) as supply,
					SUM(cancel_price) as cancel,
					SUM(refund_price) as refund,
					SUM(coupon_price) as coupon,
					SUM(use_point) as usepoint,
					SUM(use_price) as useprice,
					SUM(sum_qty) as qty,
					SUM(sum_point) as point
			   from shop_order
			  where od_id like '%$od_id%'
				";
			$row = sql_fetch($sql);
	} else {
		$stotal = get_order_spay2($od_id); // 총계
	}
} else if ($reg_yn == 2) {
	$stotal = get_order_spay($od_id); // 총계
}
// 결제정보처리
$app_no_subj = '';
$disp_bank = true;
$disp_receipt = false;
$easy_pay_name = '';
if($od['paymethod'] == '신용카드' || $od['paymethod'] == 'KAKAOPAY' || $od['paymethod'] == '삼성페이') {
	$app_no_subj = '승인번호';
	$app_no = $od['od_app_no'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($od['paymethod'] == '간편결제') {
	$app_no_subj = '승인번호';
	$app_no = $od['od_app_no'];
	$disp_bank = false;
	switch($od['od_pg']) {
		case 'lg':
			$easy_pay_name = 'PAYNOW';
			break;
		case 'inicis':
			$easy_pay_name = 'KPAY';
			break;
		case 'kcp':
			$easy_pay_name = 'PAYCO';
			break;
		default:
			break;
	}
} else if($od['paymethod'] == '휴대폰') {
	$app_no_subj = '휴대폰번호';
	$app_no = $od['bank'];
	$disp_bank = false;
	$disp_receipt = true;
} else if($od['paymethod'] == '가상계좌' || $od['paymethod'] == '계좌이체') {
	$app_no_subj = '거래번호';
	$app_no = $od['od_tno'];
}

// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

include_once(BV_MTHEME_PATH.'/orderinquiryview.skin.php');

include_once("./_tail.php");
?>