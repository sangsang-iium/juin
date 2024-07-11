<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if($_POST['act_button'] == "배송준비")
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

  // PUSH _20240711_SY {
  $post_cnt = count($_POST['chk']);

  foreach($_POST['od_id'] as $key => $val) {
    $push_od = get_order($val);
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$val}' AND dan = '4' ";
    $od_count_row = sql_fetch($od_count_sel);
    $sql_cnt = $od_count_row['cnt'];
    if($post_cnt == $sql_cnt) {
      $total_cnt = $post_cnt;
    } else {
      $total_cnt = (int)$sql_cnt - (int)$post_cnt;
    }

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$push_od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
  
    if($total_cnt == 1 ) {
      $k			 = $_POST['chk'][0];
      $push_od = get_order($_POST['od_no'][$k]);
    }
    
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

    log_write("공급사 PUSH : " . $response . ";" . $body);
    
  }
  // } PUSH _20240711_SY

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
  $post_cnt = count($_POST['chk']);

  foreach($_POST['od_id'] as $key => $val) {
    $push_od = get_order($val);
    $od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$val}' AND dan = '5' ";
    $od_count_row = sql_fetch($od_count_sel);
    $sql_cnt = $od_count_row['cnt'];
    if($post_cnt == $sql_cnt) {
      $total_cnt = $post_cnt;
    } else {
      $total_cnt = (int)$sql_cnt - (int)$post_cnt;
    }

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$push_od['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];

    if($total_cnt == 1 ) {
      $k			 = $_POST['chk'][0];
      $push_od = get_order($_POST['od_no'][$k]);
    }
  
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

    log_write("공급사 PUSH : " . $response . ";" . $body);

  }
  // } PUSH _20240708_SY
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
} else {
	alert();
}

goto_url(BV_MYPAGE_URL."/page.php?$q1&page=$page");
?>