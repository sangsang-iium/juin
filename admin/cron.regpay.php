<?php
include_once "./_common.php";

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

      while ($row_cart = sql_fetch_array($res_cart)) {
        $gs_id[] = $row_cart['gs_id'];
      }
      $gs_first_id = $gs_id[0];
      $gs_count    = count($gs_id);
      $sql_gs      = "SELECT * FROM shop_goods WHERE index_no = '{$gs_first_id}'";
      $row_gs      = sql_fetch($sql_gs);

      $sql_card = "SELECT * FROM iu_card_reg WHERE idx = '{$card_id}'";
      $row_card = sql_fetch($sql_card);

      if ($gs_count > 1) {
        $t_turnstr = truncateString($row_gs['gname'], 8) . '외' . $gs_count . '건';
      } else {
        $t_turnstr = truncateString($row_gs['gname'], 10);
      }


      // $_POST['tot_price'] order_reg에 있는 데이터 다 불러와서 포스트 변수 수정 필요 선언된 변수들 전부 채크 필요



      $billingkey      = $row_card['cr_billing'];
      $t_ckey          = $row_card['cr_customer_key'];
      $t_amount        = str_replace(',', '', $_POST['tot_price']);
      $t_orderid       = $od_id;
      $t_ordername     = $t_turnstr;
      $t_taxfreeamount = 0;
      $t_name          = $_POST['name'];
      $t_email         = $_POST['email'];
      $TossRun         = new Tosspay();
      $toss_run        = $TossRun->autoPay($t_ckey, $t_amount, $t_orderid, $t_ordername, $t_taxfreeamount, $t_name, $t_email, $billingkey);
      if ($toss_run->code) {
        if ($resulturl == 'pc') {
          alert("결제 오류 ".$toss_run->code, '/mng/shop/cart.php');
        } else {
          alert("결제 오류 ".$toss_run->code, BV_MSHOP_URL . '/cart.php');
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
        $sql = "insert into {$shop_table}
			   set od_id				= '{$od_id}'
			     , od_no				= '{$od_no}'
				 , mb_id				= '{$member['id']}'
				 , name					= '{$_POST['name']}'
				 , cellphone			= '{$_POST['cellphone']}'
				 , telephone			= '{$_POST['telephone']}'
				 , email				= '{$_POST['email']}'

				  $order_info_query

				 , addr_jibeon			= '{$_POST['addr_jibeon']}'
				 , b_name				= '{$_POST['b_name']}'
				 , b_cellphone			= '{$b_cellp}'
				 , b_telephone			= '{$_POST['b_telephone']}'

				 , b_zip				= '{$_POST['b_zip']}'
				 , b_addr1				= '{$_POST['b_addr1']}'
				 , b_addr2				= '{$_POST['b_addr2']}'
				 , b_addr3				= '{$_POST['b_addr3']}'

				 , b_addr_jibeon		= '{$_POST['b_addr_jibeon']}'
         , b_addr_req       = '{$_POST['b_addr_req']}'
				 , gs_id				    = '{$gs_id[$i]}'
				 , gs_notax				  = '{$gs_notax[$i]}'
				 , seller_id			  = '{$seller_id[$i]}'
				 , goods_price			= '{$gs_price[$i]}'
				 , supply_price			= '{$supply_price[$i]}'
				 , sum_point			  = '{$sum_point[$i]}'
				 , sum_qty				  = '{$sum_qty[$i]}'
				 , coupon_price			= '{$coupon_price[$i]}'
				 , coupon_lo_id			= '{$coupon_lo_id[$i]}'
				 , coupon_cp_id			= '{$coupon_cp_id[$i]}'
				 , use_price			  = '{$i_use_price[$i]}'
				 , use_point			  = '{$i_use_point[$i]}'
				 , baesong_price		= '{$baesong_price[$i]}'
				 , baesong_price2		= '{$baesong_price2}'
				 , paymethod			  = '{$_POST['paymethod']}'
				 , bank					    = '{$_POST['bank']}'
				 , deposit_name			= '{$_POST['deposit_name']}'
				 , dan					    = '{$dan}'
				 , memo					    = '{$_POST['memo']}'
				 , taxsave_yes			= '{$_POST['taxsave_yes']}'
				 , taxbill_yes			= '{$_POST['taxbill_yes']}'
				 , od_time				  = '" . BV_TIME_YMDHIS . "'
				 , od_pwd				    = '{$od_pwd}'
				 , od_ip				    = '{$_SERVER['REMOTE_ADDR']}'
				 , od_test				  = '{$default['de_card_test']}'
				 , od_tax_flag			= '{$default['de_tax_flag_use']}'
				 , od_settle_pid		= '{$pt_settle_pid}'
				 , pt_id				    = '{$_POST['pt_id']}'
				 , shop_id				  = '{$_POST['shop_id']}'
				 , od_mobile			  = '1'
         ";
         sql_query($sql, true);
        $insert_id = sql_insert_id();
        $shop_table = "shop_order";
        save_goods_data($gs_id[$i], $insert_id, $od_id, $shop_table);
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