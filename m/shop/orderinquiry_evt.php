<?php
include_once "./_common.php";
//echo $odId;
//echo $evt;
//환불
//취소신청
$od_id = $odId;
if ($evt == 'return-money') {
  $sq = "select * from shop_order where od_id='$od_id' ";
  $rs = sql_fetch($sq);
  if ($rs['paymethod'] == '무통장') {
    $csql = "update shop_order
            set
            dan = '9',
            dan2 = '9',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = '9';
  } else {
    $csql = "update shop_order
            set
            dan = '17',
            dan2 = '17',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = '17';
  }

}
//교환
if ($evt == 'change-product') {
  $csql = "update shop_order
        set
        dan = '11',
        dan2 = '11',
        return_memo='$return_memo'
        where od_id='$od_id'
        ";
  $dan = '11';
}
//반품
if ($evt == 'return-product') {
  $sq = "select * from shop_order where od_id='$od_id' ";
  $rs = sql_fetch($sq);
  if ($rs['paymethod'] == '무통장') {
    $csql = "update shop_order
            set
            dan = '18',
            dan2 = '18',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = '18';
  } else {
    $csql = "update shop_order
            set
            dan = '10',
            dan2 = '10',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = "10";
  }

}

if ($evt == "cancel-order") {
  $sq = "select * from shop_order where od_id='$od_id' ";
  $rs = sql_fetch($sq);
  if ($rs['paymethod'] == '무통장') {
    $csql = "update shop_order
            set
            dan = '9',
            dan2 = '9',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = '9';
  } else {
    $csql = "update shop_order
            set
            dan = '17',
            dan2 = '17',
            return_memo='$return_memo'
            where od_id='$od_id'
            ";
    $dan = '17';
  }

  //echo $csql."<br/>";

}
sql_query($csql);

// if ($dan=='7') {
//     $change_status = 7;
// }
$sq1 = "select * from shop_order where od_id='$od_id' ";
$res = sql_fetch($sq1);

//무통장이 아닌 경우만
if ($res['paymethod'] != "무통장") {

  if ($dan == '17') { // 취소완료
    $change_status = 9;
  }
  if ($dan == "10") { // 반품완료일때
    $change_status = 10;
  }

  $od_cancel_change = 0;

  switch ($change_status) {
    case '9': // 환불
      change_order_status_9($od_no);
      $od_sms_cancel_check++;
      $od_cancel_change++;
      break;
    case '10': // 환불
      change_order_status_10($od_no);
      $od_sms_cancel_check++;
      $od_cancel_change++;
      break;
  }

  if ($od_cancel_change) {
    $sql = " select COUNT(*) as od_count1,
              SUM(IF( dan = '17' OR dan = '6' OR dan = '7' OR dan = '9', 1, 0)) as od_count2,
              SUM(refund_price) as od_refund_price,
              SUM(use_price) as od_receipt_price
          from shop_order
      where od_id = '$od_id' ";
    $row = sql_fetch($sql);


    if ($row['od_count1'] == $row['od_count2']) {
      // PG 신용카드 결제 취소일 때
      $od_receipt_price = $row['od_receipt_price'];
      if ($od_receipt_price > 0 && $row['od_refund_price'] == 0) {
        $sql1 = " select * from shop_order where od_id = '$od_id' ";
        $od1  = sql_fetch($sql1);
        if ($od1['paymethod'] == '무통장') {
          $JOIN = "JOIN toss_virtual_account b";
        } else {
          $JOIN = "JOIN toss_transactions b";
        }
        $sql = " SELECT * FROM shop_order a
                {$JOIN}
                ON ( a.od_id = b.orderId )
                where a.od_id = '{$od_id}'";
        $od = sql_fetch($sql);

        if ($od['method'] == '카드' || $od['method'] == '가상계좌' || $od['paymethod'] == '신용카드' || $od['paymethod'] == '간편결제' || $od['paymethod'] == '간편' || $od['paymethod'] == '계좌이체' || $od['paymethod'] == '일반') {
          // 가맹점 PG결제 정보
          $default = set_partner_value($od['od_settle_pid']);

          switch ($od['od_pg']) {
            case 'lg':
              include_once BV_SHOP_PATH . '/settle_lg.inc.php';

              $LGD_TID = $od['od_tno'];

              $xpay = new XPay($configPath, $CST_PLATFORM);

              // Mert Key 설정
              $xpay->set_config_value('t' . $LGD_MID, $default['de_lg_mert_key']);
              $xpay->set_config_value($LGD_MID, $default['de_lg_mert_key']);

              $xpay->Init_TX($LGD_MID);

              $xpay->Set('LGD_TXNAME', 'Cancel');
              $xpay->Set('LGD_TID', $LGD_TID);

              if ($xpay->TX()) {
                $res_cd = $xpay->Response_Code();
                if ($res_cd != '0000' && $res_cd != 'AV11') {
                  $pg_res_cd  = $res_cd;
                  $pg_res_msg = $xpay->Response_Msg();
                }
              } else {
                $pg_res_cd  = $xpay->Response_Code();
                $pg_res_msg = $xpay->Response_Msg();
              }
              break;
            case 'inicis':
              include_once BV_SHOP_PATH . '/settle_inicis.inc.php';
              $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');

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
              $inipay->SetField("admin", $default['de_inicis_admin_key']); // 비대칭 사용키 키패스워드
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
                $pg_res_cd  = $res_cd;
                $pg_res_msg = iconv_utf8($res_msg);
              }
              break;
            case 'KAKAOPAY':
              include_once BV_SHOP_PATH . '/settle_kakaopay.inc.php';
              $_REQUEST['TID']               = $od['od_tno'];
              $_REQUEST['Amt']               = $od_receipt_price;
              $_REQUEST['CancelMsg']         = '쇼핑몰 운영자 승인 취소';
              $_REQUEST['PartialCancelCode'] = 0;
              include BV_SHOP_PATH . '/kakaopay/kakaopay_cancel.php';
              break;
            case 'kcp':
              include_once BV_SHOP_PATH . '/settle_kcp.inc.php';
              require_once BV_SHOP_PATH . '/kcp/pp_ax_hub_lib.php';

              // locale ko_KR.euc-kr 로 설정
              setlocale(LC_CTYPE, 'ko_KR.euc-kr');

              $c_PayPlus = new C_PP_CLI_T;

              $c_PayPlus->mf_clear();

              $tno            = $od['od_tno'];
              $tran_cd        = '00200000';
              $cancel_msg     = iconv_euckr('쇼핑몰 운영자 승인 취소');
              $cust_ip        = $_SERVER['REMOTE_ADDR'];
              $bSucc_mod_type = "STSC";

              $c_PayPlus->mf_set_modx_data("tno", $tno);                 // KCP 원거래 거래번호
              $c_PayPlus->mf_set_modx_data("mod_type", $bSucc_mod_type); // 원거래 변경 요청 종류
              $c_PayPlus->mf_set_modx_data("mod_ip", $cust_ip);          // 변경 요청자 IP
              $c_PayPlus->mf_set_modx_data("mod_desc", $cancel_msg);     // 변경 사유

              $c_PayPlus->mf_do_tx($tno, $g_conf_home_dir, $g_conf_site_cd,
                $g_conf_site_key, $tran_cd, "",
                $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib",
                $ordr_idxx, $cust_ip, "3",
                0, 0, $g_conf_key_dir, $g_conf_log_dir);

              $res_cd  = $c_PayPlus->m_res_cd;
              $res_msg = $c_PayPlus->m_res_msg;

              if ($res_cd != '0000') {
                $pg_res_cd  = $res_cd;
                $pg_res_msg = iconv_utf8($res_msg);
              }

              // locale 설정 초기화
              setlocale(LC_CTYPE, '');
              break;
            case 'toss':
              if ($od['paymethod'] == '무통장' || $od['paymethod'] == '일반' || $od['paymethod'] == '계좌이체') {
                $sk = "live_sk_vZnjEJeQVxKlJ066Ep6Y3PmOoBN0";
              } else if ($od['paymethod'] == '간편' || $od['paymethod'] == '신용카드') {
                $sk = "live_sk_0RnYX2w532Mklgz2ZPY18NeyqApQ";
              }
              $tossCC  = new Tosspay();
              $tossRes = $tossCC->cancel($od['paymentKey'], BV_TIME_YMDHIS . ' ' . $member['id'] . ' 주문취소 처리', $sk);
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
              $ts_where             = "WHERE orderId = '{$od_id}'";
              if ($od['paymethod'] == '무통장') {
                $tossModel->update('toss_virtual_account', $ts_update, $ts_where);
              } else {
                $tossModel->update('toss_transactions', $ts_update, $ts_where);
              }
              $pg_res_cd = "";

              break;
          }
          // PG 취소요청 성공했으면
          if ($pg_res_cd == '') {
            $pg_cancel_log = ' PG 신용카드 승인취소 처리';

            // 전체취소
            $sql = " select index_no from shop_order where od_id = '$od_id' order by index_no asc ";
            $res = sql_query($sql);
            while ($row = sql_fetch_array($res)) {
              $sql = " update shop_order
                                                                        set refund_price = use_price
                                                                    where index_no = '{$row['index_no']}' ";
              sql_query($sql);
            }
          }
        }
      }

      // 관리자 주문취소 로그
      $mod_history = BV_TIME_YMDHIS . ' ' . $member['id'] . ' 주문취소 처리' . $pg_cancel_log . "\n";
    }
  }

  if ($mod_history) { // 주문변경 히스토리 기록
    $sql = " update shop_order
                                                    set od_mod_history = CONCAT(od_mod_history,'$mod_history')
                                                where od_id = '$od_id' ";
    sql_query($sql);
  }

}

// PUSH _20240708_SY {
$push_od      = get_order($od_id);
$od_count_sel = "SELECT COUNT(*) AS cnt FROM shop_order where od_id = '{$od_id}' AND dan = '{$dan}' ";
$od_count_row = sql_fetch($od_count_sel);
$total_cnt    = $od_count_row['cnt'];

$token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$push_od['mb_id']}' ";
$token_row = sql_fetch($token_sel);
$fcm_token = $token_row['fcm_token'];

$gs    = unserialize($push_od['od_goods']);
$gname = $gs['gname'];

$push_title = "";
$push_body  = "";

if ($dan == '9' || $dan == '17') {
  $push_title = "주문 환불 요청";
  if ($total_cnt > 1) {
    $etc_text  = $total_cnt - 1;
    $push_body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 환불 요청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  } else {
    $push_body = "주문 하신 {$gname} 상품 환불 요청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  }
} else if ($dan == '11') {
  $push_title = "주문 교환 요청";
  if ($total_cnt > 1) {
    $etc_text  = $total_cnt - 1;
    $push_body = "주문 하신 {$gname} 상품 외 {$etc_text}개 교환 신청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  } else {
    $push_body = "주문 하신 {$gname} 교환 신청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  }

} else if ($dan == '10' || $dan == '18') {
  $push_title = "주문 반품 신청";
  if ($total_cnt > 1) {
    $etc_text  = $total_cnt - 1;
    $push_body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 반품 신청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  } else {
    $push_body = "주문 하신 {$gname} 상품 반품 신청이 완료되었습니다. 검수 기간 영업일 기준 1~3일 정도 소요될 수 있습니다.";
  }
} else if ($dan == '6') {
  $push_title = "주문 취소";
  if ($total_cnt > 1) {
    $etc_text  = $total_cnt - 1;
    $push_body = "주문 하신 {$gname} 상품 외 {$etc_text}개 상품 주문이 정상적으로 취소되었습니다.";
  } else {
    $push_body = "주문 하신 {$gname} 상품 주문이 정상적으로 취소되었습니다.";
  }
}

$message = [
  'token' => $fcm_token, // 수신자의 디바이스 토큰
  'title' => $push_title,
  'body'  => $push_body,
];

if (!empty($push_title)) {
  $response = sendFCMMessage($message);
}

// } PUSH _20240708_SY

//echo $csql;
$url = "/m/shop/orderinquiry.php";
goto_url($url);
?>