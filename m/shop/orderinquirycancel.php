<?php
include_once './_common.php';

// 세션에 저장된 토큰과 폼으로 넘어온 토큰을 비교하여 틀리면 에러
if ($token && get_session("ss_token") == $token) {
  // 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
  set_session("ss_token", "");
} else {
  set_session("ss_token", "");
  alert("토큰 에러", BV_MURL);
}
if($reg_yn == 1 ){
  $shop_table = "shop_order_reg";
} else if ($reg_yn == 2 ) {
  $shop_table      = "shop_order";
}
// $od = sql_fetch(" select * from shop_order where od_id = '$od_id' and mb_id = '{$member['id']}' ");
$sql1 = "select * from {$shop_table} where od_id = '$od_id' and mb_id = '{$member['id']}'";
$od1  = sql_fetch($sql1);
if ($od1['paymethod'] == '무통장') {
  $JOIN = "JOIN toss_virtual_account b";
} else {
  $JOIN = "JOIN toss_transactions b";
}

$od = sql_fetch("SELECT * FROM {$shop_table} a
                    $JOIN
                    ON (a.od_id = b.orderId)
                    WHERE a.od_id = '{$od_id}'
                    AND mb_id = '{$member['id']}'");

if (!$od['od_id']) {
  alert("존재하는 주문이 아닙니다.");
}

// 주문취소 가능여부 체크
$od_count1 = $od_count2 = $od_cancel_price = 0;

$sql = " select dan, cancel_price from {$shop_table} where od_id = '$od_id' order by index_no asc ";
$res = sql_query($sql);
while ($row = sql_fetch_array($res)) {
  $od_count1++;
  if (in_array($row['dan'], array('1', '2', '3'))) {
    $od_count2++;
  }

  $od_cancel_price += (int) $row['cancel_price'];
}

$uid = md5($od['od_id'] . $od['od_time'] . $od['od_ip']);

if ($od_cancel_price > 0 || $od_count1 != $od_count2) {
  alert("취소할 수 있는 주문이 아닙니다.", BV_MSHOP_URL . "/orderinquiryview.php?od_id=$od_id&uid=$uid");
}

// PG 결제 취소
if ($od['od_tno'] || $od['paymentKey']) {
  switch ($od['od_pg']) {
    case 'lg':
      require_once BV_SHOP_PATH . '/settle_lg.inc.php';
      $LGD_TID = $od['od_tno']; //LG유플러스으로 부터 내려받은 거래번호(LGD_TID)

      $xpay = new XPay($configPath, $CST_PLATFORM);

      // Mert Key 설정
      $xpay->set_config_value('t' . $LGD_MID, $default['de_lg_mert_key']);
      $xpay->set_config_value($LGD_MID, $default['de_lg_mert_key']);
      $xpay->Init_TX($LGD_MID);

      $xpay->Set("LGD_TXNAME", "Cancel");
      $xpay->Set("LGD_TID", $LGD_TID);

      if ($xpay->TX()) {
        //1)결제취소결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
        /*
                echo "결제 취소요청이 완료되었습니다.  <br>";
                echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
                */
      } else {
        //2)API 요청 실패 화면처리
        $msg = "결제 취소요청이 실패하였습니다.\\n";
        $msg .= "TX Response_code = " . $xpay->Response_Code() . "\\n";
        $msg .= "TX Response_msg = " . $xpay->Response_Msg();

        alert($msg);
      }
      break;
    case 'inicis':
      include_once BV_SHOP_PATH . '/settle_inicis.inc.php';
      $cancel_msg = iconv_euckr('주문자 본인 취소-' . $cancel_memo);

      /*********************
             * 3. 취소 정보 설정 *
             *********************/
      $inipay->SetField("type", "cancel");                 // 고정 (절대 수정 불가)
      $inipay->SetField("mid", $default['de_inicis_mid']); // 상점아이디
      /**************************************************************************************************
             * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
             * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
             * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
             * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
             **************************************************************************************************/
      $inipay->SetField("admin", $default['de_inicis_admin_key']); //비대칭 사용키 키패스워드
      $inipay->SetField("tid", $od['od_tno']);                     // 취소할 거래의 거래아이디
      $inipay->SetField("cancelmsg", $cancel_msg);                 // 취소사유

      /****************
             * 4. 취소 요청 *
             ****************/
      $inipay->startAction();

      /****************************************************************
             * 5. 취소 결과                                           	*
             *                                                        	*
             * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
             * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
             * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
             * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
             * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
             * (현금영수증 발급 취소시에만 리턴됨)                          *
             ****************************************************************/

      $res_cd  = $inipay->getResult('ResultCode');
      $res_msg = $inipay->getResult('ResultMsg');

      if ($res_cd != '00') {
        alert(iconv_utf8($res_msg) . ' 코드 : ' . $res_cd);
      }
      break;
    case 'kcp':
      require_once BV_SHOP_PATH . '/settle_kcp.inc.php';

      $_POST['tno']      = $od['od_tno'];
      $_POST['req_tx']   = 'mod';
      $_POST['mod_type'] = 'STSC';
      if ($od['od_escrow']) {
        $_POST['req_tx']   = 'mod_escrow';
        $_POST['mod_type'] = 'STE2';
        if ($od['paymethod'] == '가상계좌') {
          $_POST['mod_type'] = 'STE5';
        }

      }
      $_POST['mod_desc'] = iconv("utf-8", "euc-kr", '주문자 본인 취소-' . $cancel_memo);
      $_POST['site_cd']  = $default['de_kcp_mid'];

      // 취소내역 한글깨짐방지
      setlocale(LC_CTYPE, 'ko_KR.euc-kr');

      include BV_SHOP_PATH . '/kcp/pp_ax_hub.php';

      // locale 설정 초기화
      setlocale(LC_CTYPE, '');
      break;
    case 'toss':
      if ($od['paymethod'] == '무통장' || $od['paymethod'] == '일반' || $od['paymethod'] == '계좌이체') {
        $sk = "live_sk_vZnjEJeQVxKlJ066Ep6Y3PmOoBN0";
      } else if ($od['paymethod'] == '간편' || $od['paymethod'] == '신용카드') {
        $sk = "live_sk_0RnYX2w532Mklgz2ZPY18NeyqApQ";
      }

      $tossCC = new Tosspay();
      // $credential = "test_sk_DpexMgkW36ZvQYYo5Rx93GbR5ozO";
      $tossRes = $tossCC->cancel($od['paymentKey'], $_POST['cancel_memo'], $sk);

      print_r2($tossRes);
      $cancelData = [
        'transactionKey'     => $tossRes->cancels->transactionKey,
        'cancelReason'       => $tossRes->cancels->cancelReason,
        'taxExemptionAmount' => $tossRes->cancels->taxExemptionAmount,
        'canceledAt'         => $tossRes->cancels->canceledAt,
        'cancelStatus'       => $tossRes->cancels->cancelStatus,
        'cancelAmount'       => $tossRes->cancels->cancelAmount,
        'taxFreeAmount'      => $tossRes->cancels->taxFreeAmount,
        'refundableAmount'   => $tossRes->cancels->refundableAmount,
      ];

      $tossModel            = new IUD_Model();
      $ts_update['status']  = 'CANCELED';
      $ts_update['cancels'] = json_encode($cancelData);
      $ts_where            = "WHERE orderId = '{$od_id}'";
      if ($od['paymethod'] == '무통장') {
        $tossModel->update('toss_virtual_account', $ts_update, $ts_where);
      } else {
        $tossModel->update('toss_transactions', $ts_update, $ts_where);
      }

      break;
  }
}
// 주문 취소
$cancel_memo = addslashes(strip_tags($cancel_memo));

$sql    = " select od_no from {$shop_table} where od_id = '$od_id' order by index_no asc ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
  change_order_status_6($row['od_no']);
}

// 메모남김
$sql = " update {$shop_table}
			set shop_memo = CONCAT(shop_memo,\"\\n주문자 본인 직접 취소 - " . BV_TIME_YMDHIS . " (취소이유 : {$cancel_memo})\")
		 where od_id = '$od_id' ";
sql_query($sql);

exit;

// 주문취소 문자전송
icode_order_sms_send($od['pt_id'], $od['cellphone'], $od_id, 5);

goto_url(BV_MSHOP_URL . "/orderinquiryview.php?od_id=$od_id&uid=$uid&list=Y&reg_yn={$reg_yn}");
?>