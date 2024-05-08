<?php

include_once "../../../common.php";

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}

$credential = "live_sk_vZnjEJeQVxKlJ066Ep6Y3PmOoBN0";
$paymentKey = $_GET['paymentKey'];
$orderId    = $_GET['orderId'];
$amount     = $_GET['amount'];
$TossRun  = new Tosspay();
$toss_run = $TossRun->normalPay($paymentKey, $orderId, $amount, $credential);

print_r($toss_run);
