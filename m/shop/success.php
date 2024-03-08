<?php
include_once "./_common.php";

$authKey = $_GET['authKey'];
$customerKey = $_GET['customerKey'];
// 빌링키 발급
function issueBillingKey($authKey, $customerKey) {
  $url       = 'https://api.tosspayments.com/v1/billing/authorizations/issue';
  $secretKey = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R'; // 시크릿 키

  $headers = array(
    'Authorization: Basic ' . base64_encode($secretKey . ':'),
    'Content-Type: application/json',
  );

  $data = array(
    'authKey'     => $authKey,
    'customerKey' => $customerKey,
  );

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_POSTFIELDS     => json_encode($data),
    CURLOPT_HTTPHEADER     => $headers,
  ));

  $response = curl_exec($curl);
  $err      = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return false; // 요청 실패
  } else {
    return json_decode($response); // 요청 성공
  }
}

// 빌링키 발급 성공
$issueResult = issueBillingKey($_GET['authKey'], $_GET['customerKey']);
if ($issueResult !== false) {
	$db_input["mb_id"] = $member['id'];
	$db_input["cr_company"] = $issueResult->cardCompany;
	$db_input["cr_type"] = $issueResult->card->cardType;
	$db_input["cr_owner"] = $issueResult->card->ownerType;
	$db_input["cr_issuercode"] = $issueResult->card->issuerCode;
	$db_input["cr_acquirercode"] = $issueResult->card->acquirerCode;
	$db_input["cr_mid"] = $issueResult->mId;
	$db_input["cr_method"] = $issueResult->method;
	$db_input["cr_card"] = $issueResult->cardNumber;
	$db_input["cr_billing"] = $issueResult->billingKey;
	$db_input["cr_customer_key"] = $issueResult->customerKey;
	$db_input["cr_use"] = "Y";
	$db_input["wdate"] = $issueResult->authenticatedAt;

  $Card = new IUD_Model();
  $table = "iu_card_reg";
  $Card->insert($table, $db_input);

  goto_url("/m/shop/card.php?res=suc");

} else {
  // 실패 시 처리
  // header('Location: /m/shop/fail.php?' . http_build_query($_GET));
  goto_url("/m/shop/card.php?res=fai");
}

// 빌링키 발급 실패
function fail($message, $code) {
  // 실패 처리
  echo "Failed: $message, Code: $code";
}

if (isset($_GET['message']) && isset($_GET['code'])) {
  fail($_GET['message'], $_GET['code']);
}