<?php
include_once "./_common.php";

if (!$is_member) {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}

$cr_num1     = $_POST['cr_num1'];
$cr_num2     = $_POST['cr_num2'];
$cr_num3     = $_POST['cr_num3'];
$cr_num4     = $_POST['cr_num4'];
$cr_month    = $_POST['cr_month'];
$cr_year     = $_POST['cr_year'];
$cr_birth    = $_POST['cr_birth'];
$cr_password = $_POST['cr_password'];
$mb_id       = $_POST['mb_id'];
$email       = "jjh@iium.kr";

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

$card = $cr_num1 . $cr_num2 . $cr_num3 . $cr_num4;

$Card                    = new IUD_Model();
$db_input['cr_num1']     = $cr_num1;
$db_input['cr_num2']     = $cr_num2;
$db_input['cr_num3']     = $cr_num3;
$db_input['cr_num4']     = $cr_num4;
$db_input['cr_month']    = $cr_month;
$db_input['cr_year']     = $cr_year;
$db_input['cr_birth']    = $cr_birth;
$db_input['cr_password'] = $cr_password;
$db_input['wdate']       = $wdate;
$db_input['cr_use']      = 'Y';
$db_input['mb_id']       = $mb_id;

$Toss      = new Tosspay();
$getBlling = $Toss->getBilling($card, $cr_year, $cr_month, $cr_password, $cr_birth, $mb_id, $email);

// **************************************************************
// 모든 카드 사용 불가로 변경시키기
// $sql = "SELECT * FROM iu_card_reg WHERE mb_id = '{$mb_id}'";
// $res = sql_query($sql);
// $numRow = sql_num_rows($sql);

// if($numRow > 0){
//   $db_all_update['cr_use'] = "N";
//   $all_where = "WHERE mb_id = '{$mb_id}'";
//   $Card->update("iud_card_reg", $db_all_update, $all_where )
// }
// **************************************************************

$res = "";
$code = 200;
$Card->insert("iu_card_reg", $db_input);
$res = $getBlling;
// if ($getBlling == 200) {
//   $code = 200;
//   $res = $getBlling;
// } else {
//   $code = 400;
//   $db_input['cr_use'] = 'N';
//   $res = false;
// }

//   $Card->insert("iu_card_reg", $db_input);



echo json_encode(array('code' => $code, 'res' => $res));
