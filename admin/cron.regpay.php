<?php
include_once "/home/juin/www/common.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
$today         = date('Y-m-d');
$daysOfWeek    = ['일', '월', '화', '수', '목', '금', '토'];
$daysOfWeekMap = [
  '일' => 'Sunday',
  '월' => 'Monday',
  '화' => 'Tuesday',
  '수' => 'Wednesday',
  '목' => 'Thursday',
  '금' => 'Friday',
  '토' => 'Saturday',
];

// 3일 후 날짜 계산
$threeDaysLaterDate     = date('Y-m-d', strtotime('+3 days', strtotime($today)));
$threeDaysLaterDayIndex = date('w', strtotime($threeDaysLaterDate)); // 3일 후의 요일 인덱스 (0: 일요일, 1: 월요일, ..., 6: 토요일)

// 요일 인덱스를 한글 요일 이름으로 변환
$threeDaysLaterDay = $daysOfWeek[$threeDaysLaterDayIndex];

// SQL 조건 생성
$sqlCondition = "FIND_IN_SET('$threeDaysLaterDay', od_wday)";

// SQL 쿼리 작성
$sql = "SELECT * FROM shop_order_reg
        WHERE ({$sqlCondition})
        AND od_reg_total_num > od_reg_num
        AND od_begin_date <> '0000-00-00';";
$res = sql_query($sql);

// 배송 대상 주문을 저장할 배열
$deliveryTargets = [];

while ($row = sql_fetch_array($res)) {
  $beginDate           = $row['od_begin_date'];         // 배송 시작일
  $deliveryDays        = explode(',', $row['od_wday']); // 배송 요일 (월, 수 등)
  $weekInterval        = $row['od_week'];               // 배송 주기
  $totalDeliveries     = $row['od_reg_total_num'];      // 총 배송 횟수
  $completedDeliveries = $row['od_reg_num'];            // 완료된 배송 횟수

  $isFirstDelivery = ($completedDeliveries == 0);

  if ($isFirstDelivery) {
    foreach ($deliveryDays as $day) {
      $day               = trim($day);
      $englishDay        = $daysOfWeekMap[$day];
      $firstDeliveryDate = date('Y-m-d', strtotime("next $englishDay", strtotime($beginDate)));

      // 첫 배송일이 3일 후의 요일과 일치하는지 확인
      if (date('w', strtotime($firstDeliveryDate)) == $threeDaysLaterDayIndex) {
        $deliveryTargets[] = [
          'orderId'          => $row['od_id'],
          'nextDeliveryDate' => $firstDeliveryDate,
        ];
      }
    }
  } else {
    // 첫 배송이 아닌 경우 주기를 고려하여 다음 배송 날짜 계산
    $nextDeliveryDate = $beginDate;
    $deliveryCount    = $completedDeliveries;

    while ($deliveryCount < $totalDeliveries) {
      foreach ($deliveryDays as $day) {
        $day              = trim($day);
        $englishDay       = $daysOfWeekMap[$day];
        $nextDeliveryDate = date('Y-m-d', strtotime("next $englishDay", strtotime($nextDeliveryDate)));

        if ($deliveryCount > 0 && $deliveryCount % count($deliveryDays) == 0) {
          $nextDeliveryDate = date('Y-m-d', strtotime("+{$weekInterval} weeks", strtotime($nextDeliveryDate)));
        }

        // 다음 배송일이 3일 후의 요일과 일치하는지 확인
        if (date('w', strtotime($nextDeliveryDate)) == $threeDaysLaterDayIndex && date('Y-m-d', strtotime('-3 days', strtotime($nextDeliveryDate))) == $today) {
          $deliveryTargets[] = [
            'orderId'          => $row['od_id'],
            'nextDeliveryDate' => $nextDeliveryDate,
          ];
          break 2; // 해당 주문이 조건에 맞는 경우 반복문을 종료
        }

        $deliveryCount++;
      }
    }
  }
}

$orderIds   = array_unique(array_column($deliveryTargets, 'orderId'));
$orderIdsIn = implode(", ", $orderIds);
if(count($orderIds) <= 0) {
  die;
}
$sqlOdShop = "SELECT * FROM shop_order_reg
            WHERE od_id IN ({$orderIdsIn})";
$resOdShop    = sql_query($sqlOdShop);
$orderNumRows = sql_num_rows($resOdShop);

$sqlCartSum = "SELECT o.od_id, o.mb_id, o.email, o.name, o.paymethod, o.bank_code, o.od_reg_num,
                  GROUP_CONCAT(DISTINCT c.gs_id ORDER BY c.gs_id SEPARATOR ',') AS gs_ids,
                  GROUP_CONCAT(DISTINCT c.index_no ORDER BY c.index_no SEPARATOR ',') AS index_nos,
                  SUM(c.ct_price) AS total_ct_price
              FROM shop_order_reg o
              JOIN shop_cart c ON o.od_no = c.od_no
              WHERE o.od_id IN ({$orderIdsIn})
              GROUP BY o.od_id";

$resCartSum = sql_query($sqlCartSum);

// 결과를 배열로 저장
$totals = array();
while ($rowSum = sql_fetch_array($resCartSum)) {
  $totals[] = $rowSum;
}

// $odIdCounters = array();
if ($orderNumRows > 0) {
  while ($row = sql_fetch_array($resOdShop)) {
    // $od_id = $row['od_id'];
    $odRegNum = $row['od_reg_num'];

    // // od_id가 처음 등장하는 경우 카운터를 초기화
    // if (!isset($odIdCounters[$od_id])) {
    //   $odIdCounters[$od_id] = 0;
    // }

    // // 현재 카운터 값을 사용하고, 이후 카운터 값을 증가시킴
    // $i = $odIdCounters[$od_id];
    // $odIdCounters[$od_id]++;

    $od_id_plus    = sprintf("%02d", $odRegNum);

    $shopVal['od_id']             = $row['od_id'] . "_" . $od_id_plus;
    $shopVal['od_no']             = $row['od_no'] . "_" . $od_id_plus;
    $shopVal['mb_id']             = $row['mb_id'];
    $shopVal['pt_id']             = $row['pt_id'];
    $shopVal['shop_id']           = $row['shop_id'];
    $shopVal['dan']               = 2;
    $shopVal['dan2']              = $row['dan2'];
    $shopVal['dan3']              = $row['dan3'];
    $shopVal['paymethod']         = $row['paymethod'];
    $shopVal['name']              = $row['name'];
    $shopVal['telephone']         = $row['telephone'];
    $shopVal['cellphone']         = $row['cellphone'];
    $shopVal['email']             = $row['email'];
    $shopVal['zip']               = $row['zip'];
    $shopVal['addr1']             = $row['addr1'];
    $shopVal['addr2']             = $row['addr2'];
    $shopVal['addr3']             = $row['addr3'];
    $shopVal['addr_jibeon']       = $row['addr_jibeon'];
    $shopVal['b_name']            = $row['b_name'];
    $shopVal['b_cellphone']       = $row['b_cellphone'];
    $shopVal['b_telephone']       = $row['b_telephone'];
    $shopVal['b_zip']             = $row['b_zip'];
    $shopVal['b_addr1']           = $row['b_addr1'];
    $shopVal['b_addr2']           = $row['b_addr2'];
    $shopVal['b_addr3']           = $row['b_addr3'];
    $shopVal['b_addr_jibeon']     = $row['b_addr_jibeon'];
    $shopVal['b_addr_req']        = $row['b_addr_req'];
    $shopVal['gs_id']             = $row['gs_id'];
    $shopVal['gs_notax']          = $row['gs_notax'];
    $shopVal['seller_id']         = $row['seller_id'];
    $shopVal['sellerpay_yes']     = $row['sellerpay_yes'];
    $shopVal['sum_point']         = $row['sum_point'];
    $shopVal['sum_qty']           = $row['sum_qty'];
    $shopVal['goods_price']       = $row['goods_price'];
    $shopVal['supply_price']      = $row['supply_price'];
    $shopVal['coupon_price']      = $row['coupon_price'];
    $shopVal['coupon_lo_id']      = $row['coupon_lo_id'];
    $shopVal['coupon_cp_id']      = $row['coupon_cp_id'];
    $shopVal['use_price']         = $row['use_price'];
    $shopVal['use_point']         = $row['use_point'];
    $shopVal['baesong_price']     = $row['baesong_price'];
    $shopVal['baesong_price2']    = $row['baesong_price2'];
    $shopVal['cancel_price']      = $row['cancel_price'];
    $shopVal['refund_price']      = $row['refund_price'];
    $shopVal['bank']              = $row['bank'];
    $shopVal['deposit_name']      = $row['deposit_name'];
    $shopVal['receipt_time']      = $row['receipt_time'];
    $shopVal['refund_bank']       = $row['refund_bank'];
    $shopVal['refund_num']        = $row['refund_num'];
    $shopVal['refund_name']       = $row['refund_name'];
    $shopVal['delivery']          = $row['delivery'];
    $shopVal['delivery_no']       = $row['delivery_no'];
    $shopVal['delivery_date']     = $row['delivery_date'];
    $shopVal['cancel_date']       = $row['cancel_date'];
    $shopVal['return_date']       = $row['return_date'];
    $shopVal['change_date']       = $row['change_date'];
    $shopVal['invoice_date']      = $row['invoice_date'];
    $shopVal['refund_date']       = $row['refund_date'];
    $shopVal['memo']              = $row['memo'];
    $shopVal['shop_memo']         = $row['shop_memo'];
    $shopVal['user_ok']           = $row['user_ok'];
    $shopVal['user_date']         = $row['user_date'];
    $shopVal['taxsave_yes']       = $row['taxsave_yes'];
    $shopVal['taxbill_yes']       = $row['taxbill_yes'];
    $shopVal['company_saupja_no'] = $row['company_saupja_no'];
    $shopVal['company_name']      = $row['company_name'];
    $shopVal['company_owner']     = $row['company_owner'];
    $shopVal['company_addr']      = $row['company_addr'];
    $shopVal['company_item']      = $row['company_item'];
    $shopVal['company_service']   = $row['company_service'];
    $shopVal['company_tel']       = $row['company_tel'];
    $shopVal['company_email']     = $row['company_email'];
    $shopVal['tax_hp']            = $row['tax_hp'];
    $shopVal['tax_saupja_no']     = $row['tax_saupja_no'];
    $shopVal['od_time']           = date("Y-m-d H:i:s");
    $shopVal['od_mobile']         = $row['od_mobile'];
    $shopVal['od_mod_history']    = $row['od_mod_history'];
    $shopVal['od_pwd']            = $row['od_pwd'];
    $shopVal['od_test']           = $row['od_test'];
    $shopVal['od_settle_pid']     = $row['od_settle_pid'];
    $shopVal['od_pg']             = $row['od_pg'];
    $shopVal['od_tno']            = $row['od_tno'];
    $shopVal['od_app_no']         = $row['od_app_no'];
    $shopVal['od_escrow']         = $row['od_escrow'];
    $shopVal['od_casseqno']       = $row['od_casseqno'];
    $shopVal['od_tax_flag']       = $row['od_tax_flag'];
    $shopVal['od_tax_mny']        = $row['od_tax_mny'];
    $shopVal['od_vat_mny']        = $row['od_vat_mny'];
    $shopVal['od_free_mny']       = $row['od_free_mny'];
    $shopVal['od_cash']           = $row['od_cash'];
    $shopVal['od_cash_no']        = $row['od_cash_no'];
    $shopVal['od_cash_info']      = $row['od_cash_info'];
    $shopVal['od_goods']          = $row['od_goods'];
    $shopVal['od_ip']             = $row['od_ip'];
    $shopVal['return_memo']       = $row['return_memo'];

    $OrderModel = new IUD_Model();
    $table      = "shop_order";
    $OrderModel->insert($table, $shopVal);

    $RegOrderModel            = new IUD_Model();
    $reg_table                = "shop_order_reg";
    $shopRegVal['od_reg_num'] = $row['od_reg_num'] + 1;
    $upWhere                  = "WHERE index_no = '{$row['index_no']}'";
    $RegOrderModel->update($reg_table, $shopRegVal, $upWhere);
  }
}
foreach ($totals as $totalData) {
  $od_id          = $totalData['od_id'];
  $gs_ids         = $totalData['gs_ids'];
  $index_nos      = $totalData['index_nos'];
  $total_ct_price = $totalData['total_ct_price'];
  $gs_count       = count(explode(',', $gs_ids));
  $gs_id_arr      = explode(',', $gs_ids);
  $cart_count     = count(explode(',', $index_nos));
  $cart_id_arr    = explode(',', $index_nos);

  $sql_gs = "SELECT * FROM shop_goods WHERE index_no = '{$gs_id_arr[0]}'";
  $row_gs = sql_fetch($sql_gs);

  // 결제 관련 데이터 설정
  $sql_card = "SELECT * FROM iu_card_reg WHERE mb_id = '{$totalData['mb_id']}' AND cr_use = 'Y'";
  $row_card = sql_fetch($sql_card);

  $sql_mem = "SELECT * FROM shop_member WHERE id = '{$totalData['mb_id']}'";
  $row_mem = sql_fetch($sql_mem);

  $t_turnstr           = $gs_count > 1 ? truncateString($row_gs['gname'], 8) . '외' . $gs_count . '건' : truncateString($row_gs['gname'], 10);
  $billingkey          = $row_card['cr_billing'];
  $t_ckey              = $row_card['cr_customer_key'];
  $t_amount            = str_replace(',', '', $total_ct_price); // total_ct_price 사용
  $t_orderid           = $od_id . '_' . $totalData['od_reg_num'] + 1;
  $t_bank              = $totalData['bank_code'];
  $t_ordername         = $t_turnstr;
  $t_taxfreeamount     = 0;
  // $credential          = "test_sk_QbgMGZzorzKD26y2w4728l5E1em4";
  $credential          = "live_sk_0RnYX2w532Mklgz2ZPY18NeyqApQ";
  $t_name              = $totalData['name'];
  $t_email             = $totalData['email'];
  $customerMobilePhone = $row_mem['cellphone'];

  if ($totalData['paymethod'] == "무통장") {
    $TossVirtualAcc = new Tosspay();
    $toss_acc       = $TossVirtualAcc->virtualAcc($t_amount, $t_orderid, $t_ordername, $t_name, $t_email, $t_bank, $customerMobilePhone);
    if ($toss_acc->code) {
      log_write($toss_acc->code . "[가상계좌 결제 오류]");
      continue;
    }
    $accInsert                            = new IUD_Model();
    $acc_insert['mId']                    = $toss_acc->mId;
    $acc_insert['lastTransactionKey']     = $toss_acc->lastTransactionKey;
    $acc_insert['paymentKey']             = $toss_acc->paymentKey;
    $acc_insert['orderId']                = $toss_acc->orderId;
    $acc_insert['orderName']              = $toss_acc->orderName;
    $acc_insert['taxExemptionAmount']     = $toss_acc->taxExemptionAmount;
    $acc_insert['status']                 = $toss_acc->status;
    $acc_insert['requestedAt']            = $toss_acc->requestedAt;
    $acc_insert['approvedAt']             = $toss_acc->approvedAt;
    $acc_insert['useEscrow']              = $toss_acc->useEscrow;
    $acc_insert['cultureExpense']         = $toss_acc->cultureExpense;
    $acc_insert['vaAccountNumber']        = $toss_acc->virtualAccount->accountNumber;
    $acc_insert['vaAccountType']          = $toss_acc->virtualAccount->accountType;
    $acc_insert['vaBankCode']             = $toss_acc->virtualAccount->bankCode;
    $acc_insert['vaCustomerName']         = $toss_acc->virtualAccount->customerName;
    $acc_insert['vaDueDate']              = $toss_acc->virtualAccount->dueDate;
    $acc_insert['vaExpired']              = $toss_acc->virtualAccount->expired;
    $acc_insert['vaSettlementStatus']     = $toss_acc->virtualAccount->settlementStatus;
    $acc_insert['vaRefundStatus']         = $toss_acc->virtualAccount->refundStatus;
    $acc_insert['vaRefundReceiveAccount'] = $toss_acc->virtualAccount->refundReceiveAccount;
    $acc_insert['transfer']               = $toss_acc->transfer;
    $acc_insert['mobilePhone']            = $toss_acc->mobilePhone;
    $acc_insert['giftCertificate']        = $toss_acc->giftCertificate;
    $acc_insert['cashReceipt']            = $toss_acc->cashReceipt;
    $acc_insert['cashReceipts']           = $toss_acc->cashReceipts;
    $acc_insert['discount']               = $toss_acc->discount;
    $acc_insert['cancels']                = $toss_acc->cancels;
    $acc_insert['secret']                 = $toss_acc->secret;
    $acc_insert['type']                   = $toss_acc->type;
    $acc_insert['easyPay']                = $toss_acc->easyPay;
    $acc_insert['country']                = $toss_acc->country;
    $acc_insert['failure']                = $toss_acc->failure;
    $acc_insert['isPartialCancelable']    = $toss_acc->isPartialCancelable;
    $acc_insert['receiptUrl']             = $toss_acc->receipt->url;
    $acc_insert['checkoutUrl']            = $toss_acc->checkout->url;
    $acc_insert['currency']               = $toss_acc->currency;
    $acc_insert['totalAmount']            = $toss_acc->totalAmount;
    $acc_insert['balanceAmount']          = $toss_acc->balanceAmount;
    $acc_insert['suppliedAmount']         = $toss_acc->suppliedAmount;
    $acc_insert['vat']                    = $toss_acc->vat;
    $acc_insert['taxFreeAmount']          = $toss_acc->taxFreeAmount;
    $acc_insert['method']                 = $toss_acc->method;
    $acc_insert['version']                = $toss_acc->version;
    $tran_id                              = $accInsert->insert('toss_virtual_account', $acc_insert);

  } else {
    $TossRun  = new Tosspay();
    $toss_run = $TossRun->autoPay($t_ckey, $t_amount, $t_orderid, $t_ordername, $t_taxfreeamount, $t_name, $t_email, $billingkey, $credential);
    if ($toss_run->code) {
      log_write($toss_run->code . "[신용 결제 오류]");
      continue;
    }
    $orderInsert                            = new IUD_Model();
    $or_insert['mId']                       = $toss_run->mId;
    $or_insert['lastTransactionKey']        = $toss_run->lastTransactionKey;
    $or_insert['paymentKey']                = $toss_run->paymentKey;
    $or_insert['orderId']                   = $toss_run->orderId;
    $or_insert['orderName']                 = $toss_run->orderName;
    $or_insert['taxExemptionAmount']        = $toss_run->taxExemptionAmount;
    $or_insert['status']                    = $toss_run->status;
    $or_insert['requestedAt']               = $toss_run->requestedAt;
    $or_insert['approvedAt']                = $toss_run->approvedAt;
    $or_insert['useEscrow']                 = $toss_run->useEscrow;
    $or_insert['cultureExpense']            = $toss_run->cultureExpense;
    $or_insert['cardIssuerCode']            = $toss_run->card->issuerCode;
    $or_insert['cardAcquirerCode']          = $toss_run->card->acquirerCode;
    $or_insert['cardNumber']                = $toss_run->card->number;
    $or_insert['cardInstallmentPlanMonths'] = $toss_run->card->installmentPlanMonths;
    $or_insert['cardIsInterestFree']        = $toss_run->card->isInterestFree;
    $or_insert['cardInterestPayer']         = $toss_run->card->interestPayer;
    $or_insert['cardApproveNo']             = $toss_run->card->approveNo;
    $or_insert['cardUseCardPoint']          = $toss_run->card->useCardPoint;
    $or_insert['cardType']                  = $toss_run->card->cardType;
    $or_insert['cardOwnerType']             = $toss_run->card->ownerType;
    $or_insert['cardAcquireStatus']         = $toss_run->card->acquireStatus;
    $or_insert['cardAmount']                = $toss_run->card->amount;
    $or_insert['virtualAccount']            = $toss_run->virtualAccount;
    $or_insert['transfer']                  = $toss_run->transfer;
    $or_insert['mobilePhone']               = $toss_run->mobilePhone;
    $or_insert['giftCertificate']           = $toss_run->giftCertificate;
    $or_insert['cashReceipt']               = $toss_run->cashReceipt;
    $or_insert['cashReceipts']              = $toss_run->cashReceipts;
    $or_insert['discount']                  = $toss_run->discount;
    $or_insert['cancels']                   = $toss_run->cancels;
    $or_insert['secret']                    = $toss_run->secret;
    $or_insert['type']                      = $toss_run->type;
    $or_insert['easyPay']                   = $toss_run->easyPay;
    $or_insert['country']                   = $toss_run->country;
    $or_insert['failure']                   = $toss_run->failure;
    $or_insert['isPartialCancelable']       = $toss_run->isPartialCancelable;
    $or_insert['receiptUrl']                = $toss_run->receipt->url;
    $or_insert['checkoutUrl']               = $toss_run->checkout->url;
    $or_insert['currency']                  = $toss_run->currency;
    $or_insert['totalAmount']               = $toss_run->totalAmount;
    $or_insert['balanceAmount']             = $toss_run->balanceAmount;
    $or_insert['suppliedAmount']            = $toss_run->suppliedAmount;
    $or_insert['vat']                       = $toss_run->vat;
    $or_insert['taxFreeAmount']             = $toss_run->taxFreeAmount;
    $or_insert['method']                    = $toss_run->method;
    $or_insert['version']                   = $toss_run->version;
    // $or_where = "WHERE od_id = {$od_id}";
    $tran_id = $orderInsert->insert('toss_transactions', $or_insert);
  }

  // $cart_count  = count(explode(',', $index_nos));
  // $cart_id_arr = explode(',', $index_nos);
  // 재고수량 감소
  for ($i = 0; $i < $cart_count; $i++) {
    $ct = get_cart_id($cart_id_arr[$i]);

    if ($ct['io_id']) { // 옵션 : 재고수량 감소
      $sql = " update shop_goods_option
                set io_stock_qty = io_stock_qty - '{$ct['ct_qty']}'
                where io_id = '{$ct['io_id']}'
                and gs_id = '{$ct['gs_id']}'
                and io_type = '{$ct['io_type']}'
                and io_stock_qty <> '999999999' ";
      sql_query($sql, FALSE);
    } else { // 상품 : 재고수량 감소
      $sql = " update shop_goods
                set stock_qty = stock_qty - '{$ct['ct_qty']}'
                where index_no = '{$ct['gs_id']}'
                and stock_mod = '1' ";
      sql_query($sql, FALSE);
    }
  }


}

function truncateString($string, $length) {
  if (mb_strlen($string, 'UTF-8') > $length) {
    // 문자열이 지정된 길이를 초과하는 경우
    $string = mb_substr($string, 0, $length, 'UTF-8') . "...";
  }

  return $string;
}