<?php
include_once "./_common.php";

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}

$cr_num1 = $_POST['cr_num1'];
$cr_num2 = $_POST['cr_num2'];
$cr_num3 = $_POST['cr_num3'];
$cr_num4 = $_POST['cr_num4'];
$cr_month = $_POST['cr_month'];
$cr_year = $_POST['cr_year'];
$cr_birth = $_POST['cr_birth'];
$cr_password = $_POST['cr_password'];
$mb_id = $_POST['mb_id'];
$email = "jjh@iium.kr";

function preZero($num) {
  $len = mb_strlen($num, "UTF-8");
  if ($len < 10) {
    $num = sprintf('%02d', $num);
  }

  return $num;
}

$cr_month = preZero($cr_month);
$cr_year  = preZero($cr_year);

$wdate       = date("Y-m-d H:i:s");
$cr_password = base64_encode($cr_password);

$card = $cr_num1.$cr_num2.$cr_num3.$cr_num4;

$Toss = new Tosspay();
$getBlling = $Toss->getBilling($card, $cr_year, $cr_month, $cr_password, $cr_birth, $mb_id, $email);

print_r($getBlling);

// if($getBlling == 200){

// } else if ($getBlling == 400){

// }