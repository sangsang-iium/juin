<?php

include_once "../../../common.php";

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}

$credential = "live_sk_vZnjEJeQVxKlJ066Ep6Y3PmOoBN0";
$paymentKey = $_GET['paymentKey'];
$orderId    = $_GET['orderId'];
$amount     = $_GET['amount'];
$TossRun    = new Tosspay();
$toss_run   = $TossRun->normalPay($paymentKey, $orderId, $amount, $credential);

if ($toss_acc->code) {
  if ($resulturl == 'pc') {
    alert("가상계좌 결제 오류 " . $t_amount . $t_orderid . $t_ordername . $t_name . $t_email . $t_bank . $customerMobilePhone, '/mng/shop/cart.php');
  } else {
    alert("가상계좌 결제 오류 " . $t_amount . $t_orderid . $t_ordername . $t_name . $t_email . $t_bank . $customerMobilePhone, BV_MSHOP_URL . '/cart.php');
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

$orderModel     = new IUD_Model();
$up_table       = "shop_order";
$up_data['dan'] = 2;
$up_where       = "WHERE od_id = '{$orderId}'";

$orderModel->update($up_table, $up_data, $up_where);

goto_url(BV_URL . '/mng/shop/orderinquiryview.php?od_id=' . $orderId . '&reg_yn=2&tran_id=' . $tran_id);