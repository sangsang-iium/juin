<?php

include_once "./_common.php";
include_once BV_LIB_PATH . '/mailer.lib.php';
$resulturl = $_POST['resulturl'];

// 삼성페이 요청으로 왔다면 현재 삼성페이는 이니시스 밖에 없으므로
if ($_POST['paymethod'] == '삼성페이' && $default['de_pg_service'] != 'inicis') {
  alert("이니시스를 사용중일때만 삼성페이 결제가 가능합니다.", BV_MSHOP_URL . "/cart.php");
}

// 장바구니 상품 재고 검사
$error  = "";
$sql    = " select * from shop_cart where index_no IN ({$_POST['ss_cart_id']}) and ct_select = '0' ";
$result = sql_query($sql);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
  // 상품에 대한 현재고수량
  if ($row['io_id']) {
    $it_stock_qty = (int) get_option_stock_qty($row['gs_id'], $row['io_id'], $row['io_type']);
  } else {
    $it_stock_qty = (int) get_it_stock_qty($row['gs_id']);
  }
  // 장바구니 수량이 재고수량보다 많다면 오류
  if ($row['ct_qty'] > $it_stock_qty) {
    $error .= "{$row['ct_option']} 의 재고수량이 부족합니다. 현재고수량 : $it_stock_qty 개\\n\\n";
  }

}

if ($i == 0) {
  alert("장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.", BV_MSHOP_URL . "/cart.php");
}

if ($error != "") {
  $error .= "다른 고객님께서 {$name}님 보다 먼저 주문하신 경우입니다. 불편을 끼쳐 죄송합니다.";
  alert($error);
}

// 주문번호를 얻는다.
$od_id = get_session('ss_order_id');

if (!$od_id) {
  alert("주문번호가 없습니다.", BV_MURL);
}

// '신용카드,계좌이체,가상계좌'등으로 결제시도 후 주문서로 리턴해 다시 재주문하는 경우에는 주문서가 2번 등록되므로 기존에 주문이 발생되지 않은 주문건은 먼저 삭제함.
sql_query(" delete from shop_order where od_id = '$od_id' ");

$dan = 0;
if ($_POST['paymethod'] == '무통장') {
  $dan = 1;
}
// 주문접수 단계로 적용

if ((int) $_POST['tot_price'] == 0) { // 총 결제금액이 0 이면
  $dan = 2;                             // 입금확인 단계로 적용

  // 포인트로 전액 결제시는 포인트결제로 값을 바꾼다.
  if ($_POST['paymethod'] != '포인트' && (int) $_POST['org_price'] == (int) $_POST['use_point']) {
    $_POST['paymethod'] = '포인트';
  }
}
if ($_POST['paymethod'] == '신용카드') {
  $dan = 2;
}

set_session('tot_price', (int) $_POST['tot_price']);
set_session('use_point', (int) $_POST['use_point']);

$baesong_price = explode("|", $_POST['baesong_price']); // 상품별 배송비
$coupon_price  = explode("|", $_POST['coupon_price']);  // 상품별 할인가
$coupon_lo_id  = explode("|", $_POST['coupon_lo_id']);  // 상품별 쿠폰 shop_coupon_log (필드:lo_id)
$coupon_cp_id  = explode("|", $_POST['coupon_cp_id']);  // 상품별 쿠폰 shop_coupon_log (필드:cp_id)
$ss_cart_id    = explode(",", $_POST['ss_cart_id']);    // 장바구니 idx

$use_point      = (int) $_POST['use_point'];      // 포인트결제
$baesong_price2 = (int) $_POST['baesong_price2']; // 추가배송비

if ($is_member) {
  $od_pwd = $member['passwd'];
} else {
  $od_pwd = get_encrypt_string($_POST['od_pwd']);
}

// 토스 결제 먼저 진행해야 재고, 쿠폰, 포인트에 영향 안줌
if (in_array($_POST['paymethod'], array('무통장', '포인트'))) {
  $gs_first_id = $gs_id[0];
  $gs_count    = count($gs_id);
  $sql_gs      = "SELECT * FROM shop_goods WHERE index_no = '{$gs_first_id}'";
  $row_gs      = sql_fetch($sql_gs);

  if ($gs_count > 1) {
    $t_turnstr = truncateString($row_gs['gname'], 8) . '외' . $gs_count . '건';
  } else {
    $t_turnstr = truncateString($row_gs['gname'], 10);
  }

  $t_amount    = str_replace(',', '', $_POST['tot_price']);
  $t_orderid   = $od_id;
  $t_ordername = $t_turnstr;
  $t_name      = $_POST['name'];
  $t_bank      = $_POST['bank_code'];
  $t_email     = $_POST['customerEmail'];


  $TossVirtualAcc = new Tosspay();
  $toss_acc       = $TossVirtualAcc->virtualAcc($t_amount, $t_orderid, $t_ordername, $t_name, $t_email, $t_bank);
  if ($toss_acc->code) {
    if ($resulturl == 'pc') {
      alert("가상계좌 결제 오류 ".$t_amount. $t_orderid .$t_ordername .$t_name. $t_email .$t_bank, '/mng/shop/cart.php');
    } else {
      alert("가상계좌 결제 오류 ".$t_amount .$t_orderid .$t_ordername .$t_name .$t_email .$t_bank, BV_MSHOP_URL . '/cart.php');
    }
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
// $or_where = "WHERE od_id = {$od_id}";
  $tran_id = $accInsert->insert('toss_virtual_account', $acc_insert);

}
// else if ($_POST['paymethod'] == '신용카드') {
//   $gs_first_id = $gs_id[0];
//   $gs_count    = count($gs_id);
//   $sql_gs      = "SELECT * FROM shop_goods WHERE index_no = '{$gs_first_id}'";
//   $row_gs      = sql_fetch($sql_gs);

//   $sql_card = "SELECT * FROM iu_card_reg WHERE idx = '{$card_id}'";
//   $row_card = sql_fetch($sql_card);

//   if ($gs_count > 1) {
//     $t_turnstr = truncateString($row_gs['gname'], 8) . '외' . $gs_count . '건';
//   } else {
//     $t_turnstr = truncateString($row_gs['gname'], 10);
//   }

//   $billingkey      = $row_card['cr_billing'];
//   $t_ckey          = $row_card['cr_customer_key'];
//   $t_amount        = str_replace(',', '', $_POST['tot_price']);
//   $t_orderid       = $od_id;
//   $t_ordername     = $t_turnstr;
//   $t_taxfreeamount = 0;
//   $t_name          = $_POST['name'];
//   $t_email         = $_POST['email'];
//   $TossRun         = new Tosspay();
//   $toss_run        = $TossRun->autoPay($t_ckey, $t_amount, $t_orderid, $t_ordername, $t_taxfreeamount, $t_name, $t_email, $billingkey);
//   if ($toss_run->code) {
//     if ($resulturl == 'pc') {
//       alert("결제 오류 ".$toss_run->code, '/mng/shop/cart.php');
//     } else {
//       alert("결제 오류 ".$toss_run->code, BV_MSHOP_URL . '/cart.php');
//     }
//   }
//   $orderInsert                            = new IUD_Model();
//   $or_insert['mId']                       = $toss_run->mId;
//   $or_insert['lastTransactionKey']        = $toss_run->lastTransactionKey;
//   $or_insert['paymentKey']                = $toss_run->paymentKey;
//   $or_insert['orderId']                   = $toss_run->orderId;
//   $or_insert['orderName']                 = $toss_run->orderName;
//   $or_insert['taxExemptionAmount']        = $toss_run->taxExemptionAmount;
//   $or_insert['status']                    = $toss_run->status;
//   $or_insert['requestedAt']               = $toss_run->requestedAt;
//   $or_insert['approvedAt']                = $toss_run->approvedAt;
//   $or_insert['useEscrow']                 = $toss_run->useEscrow;
//   $or_insert['cultureExpense']            = $toss_run->cultureExpense;
//   $or_insert['cardIssuerCode']            = $toss_run->card->issuerCode;
//   $or_insert['cardAcquirerCode']          = $toss_run->card->acquirerCode;
//   $or_insert['cardNumber']                = $toss_run->card->number;
//   $or_insert['cardInstallmentPlanMonths'] = $toss_run->card->installmentPlanMonths;
//   $or_insert['cardIsInterestFree']        = $toss_run->card->isInterestFree;
//   $or_insert['cardInterestPayer']         = $toss_run->card->interestPayer;
//   $or_insert['cardApproveNo']             = $toss_run->card->approveNo;
//   $or_insert['cardUseCardPoint']          = $toss_run->card->useCardPoint;
//   $or_insert['cardType']                  = $toss_run->card->cardType;
//   $or_insert['cardOwnerType']             = $toss_run->card->ownerType;
//   $or_insert['cardAcquireStatus']         = $toss_run->card->acquireStatus;
//   $or_insert['cardAmount']                = $toss_run->card->amount;
//   $or_insert['virtualAccount']            = $toss_run->virtualAccount;
//   $or_insert['transfer']                  = $toss_run->transfer;
//   $or_insert['mobilePhone']               = $toss_run->mobilePhone;
//   $or_insert['giftCertificate']           = $toss_run->giftCertificate;
//   $or_insert['cashReceipt']               = $toss_run->cashReceipt;
//   $or_insert['cashReceipts']              = $toss_run->cashReceipts;
//   $or_insert['discount']                  = $toss_run->discount;
//   $or_insert['cancels']                   = $toss_run->cancels;
//   $or_insert['secret']                    = $toss_run->secret;
//   $or_insert['type']                      = $toss_run->type;
//   $or_insert['easyPay']                   = $toss_run->easyPay;
//   $or_insert['country']                   = $toss_run->country;
//   $or_insert['failure']                   = $toss_run->failure;
//   $or_insert['isPartialCancelable']       = $toss_run->isPartialCancelable;
//   $or_insert['receiptUrl']                = $toss_run->receipt->url;
//   $or_insert['checkoutUrl']               = $toss_run->checkout->url;
//   $or_insert['currency']                  = $toss_run->currency;
//   $or_insert['totalAmount']               = $toss_run->totalAmount;
//   $or_insert['balanceAmount']             = $toss_run->balanceAmount;
//   $or_insert['suppliedAmount']            = $toss_run->suppliedAmount;
//   $or_insert['vat']                       = $toss_run->vat;
//   $or_insert['taxFreeAmount']             = $toss_run->taxFreeAmount;
//   $or_insert['method']                    = $toss_run->method;
//   $or_insert['version']                   = $toss_run->version;
// // $or_where = "WHERE od_id = {$od_id}";
//   $tran_id = $orderInsert->insert('toss_transactions', $or_insert);

// }
// 비회원 전화번호 _20240415_SY
if (is_array($_POST['b_cellphone'])) {
  $b_cellp = implode("-", $_POST['b_cellphone']);
} else {
  $b_cellp = $_POST['b_cellphone'];
}

for ($i = 0; $i < count($gs_id); $i++) {

  // 주문 일련번호
  $od_no = $cart_id[$i];

  if ($i == 0) {
    $t_point = $use_point; // 포인트 결제금액
    for ($k = 0; $k < count($gs_id); $k++) {
      if ($k == 0 && $baesong_price2 > 0) {
        $baesong_price[$k] = (int) $baesong_price[$k] + $baesong_price2; // 배송비 + 추가배송비
      }

      $t_baesong = (int) $baesong_price[$k];                      // 배송비 결제금액
      $t_price   = (int) $gs_price[$k] - (int) $coupon_price[$k]; // 상품 판매가 - 쿠폰 할인가
      if ($t_point > 0) {
        if (($t_price + $t_baesong) >= $t_point) {
          $i_use_price[$k] = ($t_price + $t_baesong) - $t_point;
          $i_use_point[$k] = $t_point;
          $t_point         = 0;

        } else if (($t_price + $t_baesong) < $t_point) {
          $i_use_price[$k] = 0;
          $i_use_point[$k] = $t_price + $t_baesong;
          $t_point         = $t_point - ($t_price + $t_baesong);
        }

      } else {
        $t_point         = 0;
        $i_use_point[$k] = 0;
        $i_use_price[$k] = $t_price + $t_baesong;
      }
    }
  } else {
    $baesong_price2 = 0;
  }

  if ($_POST['zip']) {
    $order_info_query = "
				, zip					= '{$_POST['zip']}'
				 , addr1				= '{$_POST['addr1']}'
				 , addr2				= '{$_POST['addr2']}'
				 , addr3				= '{$_POST['addr3']}'
		";
  } else {
    $order_info_query = "
				 , zip				= '{$_POST['b_zip']}'
				 , addr1				= '{$_POST['b_addr1']}'
				 , addr2				= '{$_POST['b_addr2']}'
				 , addr3				= '{$_POST['b_addr3']}'
		";
  }

// 1번 시작할 차례 ( reg_y = 1 이면 주문 테이블 shop_order_reg에 쌓아야함 )
  if($reg_yn == 1 ){
    $shop_table = "shop_order_reg";
    $count_od_wday = count($od_wday);
    $weekdays = [
      1 => '월',
      2 => '화',
      3 => '수',
      4 => '목',
      5 => '금',
      6 => '토',
    ];
    $translatedDays = array_map(function ($day) use ($weekdays) {
      return $weekdays[$day];
    }, $od_wday);

    $od_wdays = implode(',',$translatedDays);
    $od_reg_total_num = $count_od_wday * $od_reg_cnt;
    // 배송요일 '월,화' , 배송주기 1주 ~ 4주, 배송횟수 2~12회, 정기배송 주문 시작으로 0부터 시작  ( 크론텝으로 등록 될때마다 +1 ), 총배송횟수: od_wday * od_reg_cnt = 총배송횟수, 첫 배송일
    $reg_order_query = "
      , od_wday = '{$od_wdays}'
      , od_week = '{$od_week}'
      , od_reg_cnt = '{$od_reg_cnt}'
      , od_reg_num = '0'
      , od_reg_total_num = '{$od_reg_total_num}'
      , od_begin_date = '{$od_begin_date}'
    ";
  } else if ($reg_yn == 2 ) {
    $shop_table      = "shop_order";
    $reg_order_query = "";
  }

  // b_addr_req 추가 _20240507_SY
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
         $reg_order_query
         ";

  if ($_POST['taxsave_yes'] == 'Y') {
    $sql .= " , tax_hp			    = '{$_POST['tax_hp']}'
              , tax_saupja_no		= '{$_POST['tax_saupja_no']}'
            ";
  }
  if ($_POST['taxbill_yes'] == 'Y') {
    $sql .= " , company_saupja_no = '{$_POST['company_saupja_no']}'
              , company_name		  = '{$_POST['company_name']}'
              , company_owner		  = '{$_POST['company_owner']}'
              , company_addr		  = '{$_POST['company_addr']}'
              , company_item		  = '{$_POST['company_item']}'
              , company_service	  = '{$_POST['company_service']}'
            ";
  }

  // refund 추가 _20240507_SY
  if ($_POST['paymethod'] == '무통장') {
    $sql .= " , refund_bank = '{$_POST['refund_bank']}'
              , refund_num  = '{$_POST['refund_num']}'
              , refund_name = '{$_POST['refund_name']}'
            ";
  }

  sql_query($sql, true);
  $insert_id = sql_insert_id();

  // 고객이 주문/배송조회를 위해 보관해 둔다.
  save_goods_data($gs_id[$i], $insert_id, $od_id, $shop_table);

  // 쿠폰 사용함으로 변경 (무통장, 포인트결제일 경우만)
  if ($coupon_lo_id[$i] && $is_member && in_array($_POST['paymethod'], array('무통장', '포인트'))) {
    sql_query("update shop_coupon_log set mb_use='1',od_no='$od_no',cp_udate='" . BV_TIME_YMDHIS . "' where lo_id='$coupon_lo_id[$i]'");
  }

  // 쿠폰 주문건수 증가
  if ($coupon_cp_id[$i] && $is_member) {
    sql_query("update shop_coupon set cp_odr_cnt=(cp_odr_cnt + 1) where cp_id='$coupon_cp_id[$i]'");
  }

  // 주문완료 후 쿠폰발행
  $gs = get_goods($gs_id[$i], 'use_aff');
  if (!$gs['use_aff'] && $config['coupon_yes'] && $is_member) {
    $cp_used = is_used_coupon('1', $gs_id[$i], $member['id']);
    if ($cp_used) {
      $cp_id = explode(",", $cp_used);
      for ($g = 0; $g < count($cp_id); $g++) {
        if ($cp_id[$g]) {
          $cp = sql_fetch("select * from shop_coupon where cp_id='$cp_id[$g]'");
          insert_used_coupon($member['id'], $member['name'], $cp);
        }
      }
    }
  }
}

$od_pg = $default['de_pg_service'];
if ($_POST['paymethod'] == 'KAKAOPAY') {
  $od_pg = 'KAKAOPAY';
}

// 복합과세 금액
if ($default['de_tax_flag_use']) {
  $info        = comm_tax_flag($od_id);
  $od_tax_mny  = $info['comm_tax_mny'];
  $od_vat_mny  = $info['comm_vat_mny'];
  $od_free_mny = $info['comm_free_mny'];
} else {
  $od_tax_mny  = round($_POST['tot_price'] / 1.1);
  $od_vat_mny  = $_POST['tot_price'] - $od_tax_mny;
  $od_free_mny = 0;
}

// 주문서에 UPDATE
$sql = " update {$shop_table}
            set od_pg		 = '$od_pg'
			  , od_tax_mny	 = '$od_tax_mny'
			  , od_vat_mny	 = '$od_vat_mny'
			  , od_free_mny	 = '$od_free_mny'
		  where od_id = '$od_id'";
sql_query($sql, false);

if (in_array($_POST['paymethod'], array('무통장', '포인트', '신용카드'))) {
  $cart_select = " , ct_select = '1' ";
}

// 장바구니 주문완료 처리 (무통장, 포인트결제)
$sql = "update shop_cart set od_id = '$od_id' {$cart_select} where index_no IN ({$_POST['ss_cart_id']}) ";
sql_query($sql);

// 재고수량 감소
for ($i = 0; $i < count($ss_cart_id); $i++) {
  $ct = get_cart_id($ss_cart_id[$i]);

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

if (in_array($_POST['paymethod'], array('무통장', '포인트'))) {
  // 회원이면서 포인트를 사용했다면 테이블에 사용을 추가
  if ($is_member && $use_point) {
    insert_point($member['id'], (-1) * $use_point, "주문번호 $od_id 결제");
  }

  // 쿠폰사용내역기록
  if ($is_member) {
    $sql = "select * from {$shop_table} where od_id='$od_id'";
    $res = sql_query($sql);
    for ($i = 0; $row = sql_fetch_array($res); $i++) {
      if ($row['coupon_price']) {
        $sql = "update shop_coupon_log
						   set mb_use = '1',
							   od_no = '$row[od_no]',
							   cp_udate	= '" . BV_TIME_YMDHIS . "'
						 where lo_id = '$row[coupon_lo_id]' ";
        sql_query($sql);
      }
    }
  }

  $od = sql_fetch("select * from {$shop_table} where od_id='$od_id'");

  // 주문완료 문자전송
  icode_order_sms_send($od['pt_id'], $od['cellphone'], $od_id, 2);

  // 무통장 입금 때 고객에게 계좌정보 보냄
  if ($_POST['paymethod'] == '무통장' && (int) $_POST['tot_price'] > 0) {
    $sms_content = $od['name'] . "님의 입금계좌입니다.\n금액:" . number_format($_POST['tot_price']) . "원\n계좌:" . $od['bank'] . "\n" . $config['company_name'];
    icode_direct_sms_send($od['pt_id'], $od['cellphone'], $sms_content);
  }

  // 메일발송
  if ($od['email']) {
    $subject1 = get_text($od['name']) . "님 주문이 정상적으로 처리되었습니다.";
    $subject2 = get_text($od['name']) . " 고객님께서 신규주문을 신청하셨습니다.";

    ob_start();
    include_once BV_SHOP_PATH . '/orderformupdate_mail.php';
    $content = ob_get_contents();
    ob_end_clean();

    // 주문자에게 메일발송
    mailer($config['company_name'], $super['email'], $od['email'], $subject1, $content, 1);

    // 관리자에게 메일발송
    if ($super['email'] != $od['email']) {
      mailer($od['name'], $od['email'], $super['email'], $subject2, $content, 1);
    }
  }
}

// 주문번호제거
set_session('ss_order_id', '');

// 장바구니 session 삭제
set_session('ss_cart_id', '');

// orderinquiryview 에서 사용하기 위해 session에 넣고
$uid = md5($od_id . BV_TIME_YMDHIS . $_SERVER['REMOTE_ADDR']);
set_session('ss_orderview_uid', $uid);

function truncateString($string, $length) {
  if (mb_strlen($string, 'UTF-8') > $length) {
    // 문자열이 지정된 길이를 초과하는 경우
    $string = mb_substr($string, 0, $length, 'UTF-8') . "...";
  }

  return $string;
}

if (in_array($_POST['paymethod'], array('무통장', '포인트'))) {
  if ($resulturl == 'pc') {
    goto_url(BV_URL . '/mng/shop/orderinquiryview.php?od_id=' . $od_id . '&uid=' . $uid. '&tran_id=' . $tran_id);
  } else {
    goto_url(BV_MSHOP_URL . '/orderinquiryview.php?od_id=' . $od_id . '&uid=' . $uid. '&tran_id=' . $tran_id);
  }
} else if ($_POST['paymethod'] == 'KAKAOPAY') {
  goto_url(BV_MSHOP_URL . '/orderkakaopay.php?od_id=' . $od_id);
} else if ($_POST['paymethod'] == '삼성페이') {
  goto_url(BV_MSHOP_URL . '/orderinicis.php?od_id=' . $od_id);
} else if ($_POST['paymethod'] == '신용카드') {
  if ($resulturl == 'pc') {
    goto_url(BV_URL . '/mng/shop/orderinquiryview.php?od_id=' . $od_id . '&uid=' . $uid . '&tran_id=' . $tran_id.'&reg_yn='.$reg_yn );
  } else {
    goto_url(BV_MSHOP_URL . '/orderinquiryview.php?od_id=' . $od_id . '&uid=' . $uid . '&tran_id=' . $tran_id.'&reg_yn='.$reg_yn);
  }
} else {
  if ($default['de_pg_service'] == 'kcp') {
    goto_url(BV_MSHOP_URL . '/orderkcp.php?od_id=' . $od_id);
  } else if ($default['de_pg_service'] == 'inicis') {
    goto_url(BV_MSHOP_URL . '/orderinicis.php?od_id=' . $od_id);
  } else if ($default['de_pg_service'] == 'lg') {
    goto_url(BV_MSHOP_URL . '/orderlg.php?od_id=' . $od_id);
  }

}
?>