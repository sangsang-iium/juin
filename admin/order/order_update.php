<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if($_POST['act_button'] == "입금완료" || $_POST['act_button'] == "결제완료" )
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];

		$od = get_order($od_id);
		if($od['dan'] != 1) continue;
		if(!in_array($od['paymethod'], array('무통장','가상계좌'))) continue;

		change_order_status_ipgum($od_id);

		icode_order_sms_send($od['pt_id'], $od['cellphone'], $od_id, 3);

    // PUSH _20240705_SY {
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$od_id}' ";
    $od_count_row = sql_fetch($od_count_sel);
    $total_cnt = $od_count_row['cnt'];

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
    
    $gs = unserialize($od['od_goods']);
    $gname = $gs['gname'];

    $amount = get_order_spay($od['od_id']);
		$sodr = get_order_list($od, $amount, "and dan IN ('4','5')");
    $total_price = $sodr['disp_price'];

    if($total_cnt > 1) {
      $etc_text = $total_cnt -1;
      $body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 주문이 완료 되었습니다. 결제 금액 {$total_price}원";
    } else {
      $body = "주문 하신 {$gname} 상품 주문이 완료 되었습니다. 결제 금액 {$total_price}원";
    };
    
    $message = [
      'token' => $fcm_token, // 수신자의 디바이스 토큰
      'title' => '입금 완료',
      'body' => $body
    ];

    $response = sendFCMMessage($message);
    // } PUSH _20240705_SY
	}
}
else if($_POST['act_button'] == "주문취소")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];

		$od = get_order($od_id);
		if($od['dan'] != 1) continue;
		if(!in_array($od['paymethod'], array('무통장','가상계좌'))) continue;

		$sql = " select od_no from shop_order where od_id = '$od_id' order by index_no ";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)) {
			change_order_status_6($row['od_no']);
		}

		icode_order_sms_send($od['pt_id'], $od['cellphone'], $od_id, 5);

    // PUSH _20240705_SY {
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$od_id}' ";
    $od_count_row = sql_fetch($od_count_sel);
    $total_cnt = $od_count_row['cnt'];

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
    
    $gs = unserialize($od['od_goods']);
    $gname = $gs['gname'];

    if($total_cnt > 1) {
      $etc_text = $total_cnt -1;
      $body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 주문이 정상적으로 취소되었습니다.";
    } else {
      $body = "주문 하신 {$gname} 상품 주문이 정상적으로 취소되었습니다.";
    };
    
    $message = [
      'token' => $fcm_token, // 수신자의 디바이스 토큰
      'title' => '주문 취소',
      'body' => $body
    ];

    $response = sendFCMMessage($message);
    // } PUSH _20240705_SY
	}
}
else if($_POST['act_button'] == "배송준비" || $_POST['act_button'] == "상품준비중")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_no = $_POST['od_no'][$k];

		$od = get_order($od_no);
		if($od['dan'] != 2) continue;

		change_order_status_3($od_no);
	}
}
else if($_POST['act_button'] == "배송중")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k			 = $_POST['chk'][$i];
		$od_no		 = $_POST['od_no'][$k];
		$delivery	 = $_POST['delivery'][$k];
		$delivery_no = $_POST['delivery_no'][$k];

		$od = get_order($od_no);
		if($od['dan'] != 3) continue;

		change_order_status_4($od_no, $delivery, $delivery_no);

		$od_sms_baesong[$od['od_id']] = $od['cellphone'];
	}

	foreach($od_sms_baesong as $key=>$recv) {
		$q = get_order($key, 'pt_id');
		icode_order_sms_send($q['pt_id'], $recv, $key, 4);
	}

  // PUSH _20240708_SY {
  foreach($_POST['od_id'] as $key => $val) {
    $push_od = get_order($val);
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$val}' AND dan = '4' ";
    $od_count_row = sql_fetch($od_count_sel);
    $total_cnt = $od_count_row['cnt'];

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$push_od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
 
    $gs = unserialize($push_od['od_goods']);
    $gname = $gs['gname'];

    if($total_cnt > 1) {
      $etc_text = $total_cnt -1;
      $body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 배송이 시작되었습니다. 영업일 기준 1~3 배송일이 소요될 수 있습니다.";
    } else {
      $body = "주문 하신 {$gname} 상품 배송이 시작되었습니다. 영업일 기준 1~3 배송일이 소요될 수 있습니다.";
    };
    
    $message = [
      'token' => $fcm_token, // 수신자의 디바이스 토큰
      'title' => '배송중',
      'body' => $body
    ];

    $response = sendFCMMessage($message);
  }
  // } PUSH _20240708_SY
}
else if($_POST['act_button'] == "배송완료")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k			 = $_POST['chk'][$i];
		$od_no		 = $_POST['od_no'][$k];
		$delivery	 = $_POST['delivery'][$k];
		$delivery_no = $_POST['delivery_no'][$k];

		$od = get_order($od_no);
		if($od['dan'] != 4) continue;

		change_order_status_5($od_no, $delivery, $delivery_no);

		$od_sms_delivered[$od['od_id']] = $od['cellphone'];

	}

	foreach($od_sms_delivered as $key=>$recv) {
		$q = get_order($key, 'pt_id');
		icode_order_sms_send($q['pt_id'], $recv, $key, 6);
	}

  // PUSH _20240708_SY {
  foreach($_POST['od_id'] as $key => $val) {
    $push_od = get_order($val);
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$val}' AND dan = '5' ";
    $od_count_row = sql_fetch($od_count_sel);
    $total_cnt = $od_count_row['cnt'];

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$push_od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
  
    $gs = unserialize($push_od['od_goods']);
    $gname = $gs['gname'];

    if($total_cnt > 1) {
      $etc_text = $total_cnt -1;
      $body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 배송이 완료되었습니다.";
    } else {
      $body = "주문 하신 {$gname} 상품 배송이 완료되었습니다.";
    };
    
    $message = [
      'token' => $fcm_token, // 수신자의 디바이스 토큰
      'title' => '배송 완료',
      'body' => $body
    ];

    $response = sendFCMMessage($message);
  }
  // } PUSH _20240708_SY
}
else if($_POST['act_button'] == "구매확정")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_no = $_POST['od_no'][$k];

		change_status_final($od_no);
	}
}
else if($_POST['act_button'] == "구매확정취소")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_no = $_POST['od_no'][$k];

		change_status_final_cancel($od_no);
	}
}
else if($_POST['act_button'] == "선택삭제")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];

		$od = get_order($od_id);
		if(!in_array($od['dan'], array(1,6)))
			alert('입금대기, 주문취소 상태의 상품만 삭제 가능합니다.');

		$sql = " select od_no from shop_order where od_id = '$od_id' order by index_no ";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)) {
			order_delete($row['od_no'], $od_id); // 주문서 삭제
		}
	}
}
else if($_POST['act_button'] == "운송장번호수정")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = " update shop_order
					set delivery	= '{$_POST['delivery'][$k]}'
					  , delivery_no = '{$_POST['delivery_no'][$k]}'
				  where od_no = '{$_POST['od_no'][$k]}' ";
		sql_query($sql);
	}
}else if($_POST['act_button'] == "강제입금")
{

	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		 $sql = " update shop_order
		 			set dan3='13'
		 		  where od_no = '{$_POST['od_no'][$k]}' ";
		 sql_query($sql);

		 $sql = " update shop_order
		 			set dan3='13'
		 		  where od_id = '{$_POST['od_id'][$k]}' ";
		 sql_query($sql);
	}
}
else if($_POST['act_button'] == "강제출고")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = " update shop_order
					set dan3='15'
				where od_no = '{$_POST['od_no'][$k]}' ";
		sql_query($sql);

		$sql = " update shop_order
		 			set dan3='15'
		 		  where od_id = '{$_POST['od_id'][$k]}' ";
		 sql_query($sql);
	}
}
else if($_POST['act_button'] == "강제입금완료")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$sql = " update shop_order
					set dan3='14'
				where od_no = '{$_POST['od_no'][$k]}' ";
		sql_query($sql);

		$sql = " update shop_order
		 			set dan3='14'
		 		  where od_id = '{$_POST['od_id'][$k]}' ";
		 sql_query($sql);
	}
}
else if($_POST['act_button'] == "강제출고완료")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = " update shop_order
					set dan3='16'
				where od_no = '{$_POST['od_no'][$k]}' ";
		sql_query($sql);

		$sql = " update shop_order
		 			set dan3='16'
		 		  where od_id = '{$_POST['od_id'][$k]}' ";
		 sql_query($sql);
	}
}
else {
	alert($_POST['act_button']." : act_button val");
}

goto_url(BV_ADMIN_URL."/order.php?$q1&page=$page");
?>