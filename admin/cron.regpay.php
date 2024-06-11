<?php
include_once "./_common.php";

$today = date('Y-m-d'); // 오늘 날짜
echo "ddd";
// 요일 배열과 매핑을 설정합니다.
$daysOfWeekMap = ['일' => 0, '월' => 1, '화' => 2, '수' => 3, '목' => 4, '금' => 5, '토' => 6];

// DB에서 배송 관련 데이터 가져오기
$sql = "SELECT * FROM shop_order_reg WHERE od_reg_total_num > od_reg_num";
$res = sql_query($sql);

// 배송 대상 주문을 저장할 배열
$deliveryTargets = [];

while ($row = sql_fetch_array($res)) {
  $beginDate            = $row['od_begin_date'];         // 배송 시작일
  $deliveryCycle        = $row['od_week'];               // 배송 주기
  $totalDeliveryCount   = $row['od_reg_total_num'];      // 총 배송 횟수
  $currentDeliveryCount = $row['od_reg_num'];            // 현재 배송 횟수
  $deliveryDays         = explode(',', $row['od_wday']); // 배송 요일 (월, 수 등)
  $orderId              = $row['index_no'];              // 주문 번호

  // 시작 날짜가 0000-00-00인 경우 무시
  if ($beginDate === '0000-00-00') {
    continue;
  }

  // 현재 배송 횟수와 총 배송 횟수가 같으면 주문을 중단
  if ($currentDeliveryCount >= $totalDeliveryCount) {
    continue;
  }

  // 다음 배송 날짜 계산
  $nextDeliveryDate = $beginDate;
  $cycleCount       = $currentDeliveryCount;

  // 배송 요일을 반복하여 다음 배송 날짜 찾기
  while ($cycleCount < $totalDeliveryCount) {
    foreach ($deliveryDays as $day) {
      $day = trim($day); // 앞뒤 공백 제거

      // 배송 시작일이 과거이면 다음 배송 요일을 계산
      if (strtotime($nextDeliveryDate) < strtotime($today)) {
        $nextDeliveryDate = date('Y-m-d', strtotime("next {$day}", strtotime($nextDeliveryDate)));
      }

      // 배송 주기 반영
      if ($cycleCount > 0 && $cycleCount % count($deliveryDays) == 0) {
        $nextDeliveryDate = date('Y-m-d', strtotime("+{$deliveryCycle} weeks", strtotime($nextDeliveryDate)));
      }

      // 배송 날짜가 오늘 이후인 경우 계산을 멈추고 조건 확인
      if (strtotime($nextDeliveryDate) >= strtotime($today)) {
        $cycleCount++;
        break;
      }
    }

    // 무한 루프 방지
    if (strtotime($nextDeliveryDate) >= strtotime('+1 year', strtotime($today))) {
      break;
    }
  }

  // 배송 날짜의 3일 전 조건을 확인하여 결제 대상인지 확인
  $checkDate = date('Y-m-d', strtotime('-3 days', strtotime($nextDeliveryDate)));
  if (strtotime($checkDate) <= strtotime($today) && strtotime($nextDeliveryDate) >= strtotime($today)) {
    // 배송 대상 주문을 배열에 저장
    $deliveryTargets[] = [
      'orderId'          => $orderId,
      'nextDeliveryDate' => $nextDeliveryDate,
      'checkDate'        => $checkDate,
    ];
  }
}

// deliveryTargets 출력
echo "<pre>";
print_r($deliveryTargets);
echo "</pre>";

exit;

$today      = date('w'); // 0 (일요일)부터 6 (토요일)까지
$daysOfWeek = ['일', '월', '화', '수', '목', '금', '토'];

// 3일 이내의 요일 계산
$targetDays = [];
for ($i = 0; $i <= 3; $i++) {
  $targetDays[] = $daysOfWeek[($today + $i) % 7];
}

// 요일 조건 생성
$sqlConditions = [];
foreach ($targetDays as $day) {
  $sqlConditions[] = "FIND_IN_SET('$day', od_wday)";
}
$sqlCondition = implode(' OR ', $sqlConditions);

$currentDate    = date('Y-m-d');
$threeDaysLater = date('Y-m-d', strtotime('+3 days'));

$sql = "SELECT * FROM shop_order_reg
        WHERE ({$sqlCondition})
        AND od_reg_total_num > od_reg_num";
$res = sql_query($sql);

while ($row = sql_fetch_array($res)) {
  if($row['od_reg_num'] == 0) {
    $AND = " AND od_reg_num = 0
             AND (od_begin_date BETWEEN '{$currentDate}' AND '{$threeDaysLater}')";
  } else {
    $AND = "AND od_begin_date > '{$threeDaysLater}'";
  }
  $sql_order = "SELECT * FROM shop_order_reg
                WHERE ({$sqlCondition})
                AND index_no = '{$row['index_no']}'
                AND od_reg_total_num > od_reg_num
                {$AND}
                ";
  $res_order = sql_query($sql_order);

  while ($row_order = sql_fetch_array($res_order)) {
    if(!empty($row_order['index_no'])){
      $sql_cart = "SELECT * FROM shop_cart
                    WHERE od_id = '{$row_order['od_id']}'";
      $res_cart = sql_query($sql_cart);

      $sql_card = "SELECT * FROM iu_card_reg WHERE mb_id = '{$row_order['mb_id']}' AND cr_use = 'Y'";
      $row_card = sql_fetch($sql_card);

      print_r($row_order );
      exit;

      $card_id = $row_card['idx'];

      while ($row_cart = sql_fetch_array($res_cart)) {
        $gs_id[] = $row_cart['gs_id'];
      }
      $gs_first_id = $gs_id[0];
      $gs_count    = count($gs_id);
      $sql_gs      = "SELECT * FROM shop_goods WHERE index_no = '{$gs_first_id}'";
      $row_gs      = sql_fetch($sql_gs);

      if ($gs_count > 1) {
        $t_turnstr = truncateString($row_gs['gname'], 8) . '외' . $gs_count . '건';
      } else {
        $t_turnstr = truncateString($row_gs['gname'], 10);
      }


      // $_POST['tot_price'] order_reg에 있는 데이터 다 불러와서 포스트 변수 수정 필요 선언된 변수들 전부 채크 필요



      $billingkey      = $row_card['cr_billing'];
      $t_ckey          = $row_card['cr_customer_key'];
      $t_amount        = str_replace(',', '', $row_order['use_price']);
      $t_orderid       = $row_order['od_id'];
      $t_ordername     = $t_turnstr;
      $t_taxfreeamount = 0;
      $t_name          = $row_order['name'];
      $t_email         = $row_order['email'];
      $TossRun         = new Tosspay();
      $toss_run        = $TossRun->autoPay($t_ckey, $t_amount, $t_orderid, $t_ordername, $t_taxfreeamount, $t_name, $t_email, $billingkey);
      if ($toss_run->code) {
        if ($resulturl == 'pc') {
          log_write("결제 오류 ".$toss_run->code);
        } else {
          log_write("결제 오류 ".$toss_run->code);
        }
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

      if(!empty($tran_id)){
        if ($row_order['zip']) {
          $order_info_query = "
              , zip					= '{$row_order['zip']}'
              , addr1				= '{$row_order['addr1']}'
              , addr2				= '{$row_order['addr2']}'
              , addr3				= '{$row_order['addr3']}'
          ";
        } else {
          $order_info_query = "
              , zip				= '{$row_order['b_zip']}'
              , addr1				= '{$row_order['b_addr1']}'
              , addr2				= '{$row_order['b_addr2']}'
              , addr3				= '{$row_order['b_addr3']}'
          ";
        }
        $sql = "insert into shop_order
			   set od_id				= '{$row_order['od_id']}'
			     , od_no				= '{$row_order['od_no']}'
				 , mb_id				= '{$row_order['mb_id']}'
				 , name					= '{$row_order['name']}'
				 , cellphone			= '{$row_order['cellphone']}'
				 , telephone			= '{$row_order['telephone']}'
				 , email				= '{$row_order['email']}'

				  $order_info_query

				 , addr_jibeon			= '{$row_order['addr_jibeon']}'
				 , b_name				= '{$row_order['b_name']}'
				 , b_cellphone			= '{$row_order['b_cellphone']}'
				 , b_telephone			= '{$row_order['b_telephone']}'

				 , b_zip				= '{$row_order['b_zip']}'
				 , b_addr1				= '{$row_order['b_addr1']}'
				 , b_addr2				= '{$row_order['b_addr2']}'
				 , b_addr3				= '{$row_order['b_addr3']}'

				 , b_addr_jibeon		= '{$row_order['b_addr_jibeon']}'
         , b_addr_req       = '{$row_order['b_addr_req']}'
				 , gs_id				    = '{$row_order['gs_id']}'
				 , gs_notax				  = '{$row_order['gs_notax']}'
				 , seller_id			  = '{$row_order['seller_id']}'
				 , goods_price			= '{$row_order['gs_price']}'
				 , supply_price			= '{$row_order['supply_price']}'
				 , sum_point			  = '{$row_order['sum_point']}'
				 , sum_qty				  = '{$row_order['sum_qty']}'
				 , coupon_price			= '{$row_order['coupon_price']}'
				 , coupon_lo_id			= '{$row_order['coupon_lo_id']}'
				 , coupon_cp_id			= '{$row_order['coupon_cp_id']}'
				 , use_price			  = '{$row_order['i_use_price']}'
				 , use_point			  = '{$row_order['i_use_point']}'
				 , baesong_price		= '{$row_order['baesong_price']}'
				 , baesong_price2		= '{$row_order['baesong_price2']}'
				 , paymethod			  = '{$row_order['paymethod']}'
				 , bank					    = '{$row_order['bank']}'
				 , deposit_name			= '{$row_order['deposit_name']}'
				 , dan					    = '2'
				 , memo					    = '{$row_order['memo']}'
				 , taxsave_yes			= '{$row_order['taxsave_yes']}'
				 , taxbill_yes			= '{$row_order['taxbill_yes']}'
				 , od_time				  = '" . BV_TIME_YMDHIS . "'
				 , od_pwd				    = '{$row_order['od_pwd']}'
				 , od_ip				    = '{$_SERVER['REMOTE_ADDR']}'
				 , od_test				  = '{$row_order['de_card_test']}'
				 , od_tax_flag			= '{$row_order['de_tax_flag_use']}'
				 , od_settle_pid		= '{$row_order['pt_settle_pid']}'
				 , pt_id				    = '{$row_order['pt_id']}'
				 , shop_id				  = '{$row_order['shop_id']}'
				 , od_mobile			  = '1'
         ";
         sql_query($sql, true);
        $insert_id = sql_insert_id();
        $shop_table = "shop_order";
        save_goods_data($gs_id, $insert_id, $row_order['od_id'], $shop_table);
        // 뒤에 더 있는데...... 업데이트도 있고.................................................
      }
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