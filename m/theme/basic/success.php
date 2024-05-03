<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

include_once "../../../common.php";

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}


$paymentKey = $_GET['paymentKey'];
$orderId    = $_GET['orderId'];
$amount     = $_GET['amount'];
$TossRun  = new Tosspay();
$toss_run = $TossRun->normalPay($paymentKey, $orderId, $amount);

print_r($toss_run);
