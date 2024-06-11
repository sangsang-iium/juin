<?php
include_once "./_common.php";

$authKey = $_GET['authKey'];
$customerKey = $_GET['customerKey'];
// 빌링키 발급



$table = "iu_card_reg";

$sql = "SELECT * FROM iu_card_reg WHERE mb_id = '{$member['id']}'";
$res = sql_query($sql);
$card_chk = array();
while ($row = sql_fetch_array($res)) {
  $card_chk[] = $row['cr_use'];
}
if(in_array("Y", $card_chk)){
  $CardStatus  = new IUD_Model();
  $db_update['cr_use'] = "N";
  $update_where = "WHERE mb_id = '{$member['id']}'";
  $CardStatus->update($table, $db_update, $update_where);
}

// 빌링키 발급 성공
$Toss = new Tosspay();
// $secretKey = $default['de_toss_skey']; // 시크릿 키
$secretKey = "test_sk_QbgMGZzorzKD26y2w4728l5E1em4"; // 시크릿 키
$issueResult = $Toss->issueBillingKey($authKey, $customerKey, $secretKey);
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