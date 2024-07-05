<?php
include_once "./_common.php";

if (empty($b_type)) {
  alert("정상적인 방법으로 접근해주세요.", "./list.php");
}


$bc_able = implode("||",$bc_able);
$b_tel   = implode("-", $b_tel);
$b_phone = implode("-", $b_phone);
// 1. 신한체크, 2. 신한신용, 3. 노무, 4, 상조
switch ($b_type) {
  case '1':
  case '2':
    $db_input['bc_gubun'] = $bc_gubun;
    $db_input['bc_card']  = $bc_card;
    $db_input['bc_sale']  = $bc_sale;
    $db_input['bc_birth'] = $bc_birth;
    $db_input['bc_able']  = $bc_able;
    break;
  case '3':
  case '4':
    $db_input['b_addr_zip'] = $b_addr_zip;
    $db_input['b_addr_1']   = $b_addr_1;
    $db_input['b_addr_2']   = $b_addr_2;
    $db_input['b_addr_3']   = $b_addr_3;
    $db_input['b_name']     = $b_name;
    break;
}

$db_input['b_type']     = $b_type;
$db_input['b_num']      = $b_num;
$db_input['c_name']     = $c_name;
$db_input['b_tel']      = $b_tel;
$db_input['b_phone']    = $b_phone;
$db_input['b_contents'] = $b_contents;
$db_input['b_hope']     = $b_hope;
$db_input['b_pw']       = $b_pw;
$db_input['b_staff']    = $b_staff;
$db_input['b_sign']     = $b_sign;
$db_input['b_agree']    = $b_agree;
$db_input['wdate']      = date("Y-m-d H:i:s");

$serviceModel = new IUD_Model();
$serviceTable = "iu_service";
$serviceModel->insert($serviceTable, $db_input);

alert("정상 등록되었습니다.","./list.php");