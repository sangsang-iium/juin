<?php
include_once "./_common.php";

if (empty($b_type)) {
  alert("정상적인 방법으로 접근해주세요.", "./list.php");
}

$bc_able = implode("||", $bc_able);
$b_tel   = implode("-", $b_tel);
$b_phone = implode("-", $b_phone);

$db_input['mb_id'] = $mb_id;
// 1. 신한체크, 2. 신한신용, 3. 노무, 4, 상조
switch ($b_type) {
  case '1':
  case '2':
    $db_input['b_type']   = $b_type;
    $db_input['bc_gubun'] = $bc_gubun;
    $db_input['bc_card']  = $bc_card;
    $db_input['bc_sale']  = $bc_sale;
    $db_input['bc_birth'] = $bc_birth;
    $db_input['bc_able']  = $bc_able;
    $db_input['c_name']   = $c_name;
    $db_input['b_num']    = $b_num;
    $db_input['b_phone']  = $b_phone;
    $db_input['b_staff']  = $b_staff;
    $db_input['b_agree']  = $b_agree;
    break;
  case '3':
    $db_input['b_type']     = $b_type;
    $db_input['b_addr_zip'] = $b_addr_zip;
    $db_input['b_addr_1']   = $b_addr_1;
    $db_input['b_addr_2']   = $b_addr_2;
    $db_input['b_addr_3']   = $b_addr_3;
    $db_input['b_name']     = $b_name;
    $db_input['b_num']      = $b_num;
    $db_input['c_name']     = $c_name;
    $db_input['b_tel']      = $b_tel;
    $db_input['b_phone']    = $b_phone;
    $db_input['b_contents'] = $b_contents;
    $db_input['b_hope']     = $b_hope;
    $db_input['b_pw']       = $b_pw;
    $db_input['b_staff']    = $b_staff;
    break;
  case '4':
    $db_input['b_type']         = $b_type;
    $db_input['c_name']         = $c_name;
    $db_input['bc_birth']       = preg_replace('/[^0-9]/', '', $bc_birth);
    $db_input['b_addr_zip']     = $b_addr_zip;
    $db_input['b_addr_1']       = $b_addr_1;
    $db_input['b_addr_2']       = $b_addr_2;
    $db_input['b_addr_3']       = $b_addr_3;
    $db_input['b_name']         = $b_name;
    $db_input['b_addr_zip20']   = $b_addr_zip20;
    $db_input['b_addr_21']      = $b_addr_21;
    $db_input['b_addr_22']      = $b_addr_22;
    $db_input['b_addr_23']      = $b_addr_23;
    $db_input['b_tel']          = $b_tel;
    $db_input['b_phone']        = $b_phone;
    $db_input['b_paymethod']    = $b_paymethod;
    $db_input['b_bank']         = $b_bank;
    $db_input['b_account_num']  = preg_replace('/[^0-9]/', '', $b_account_num);
    $db_input['b_account_name'] = $b_account_name;
    $db_input['bc_birth2']      = preg_replace('/[^0-9]/', '', $bc_birth2);
    $db_input['bc_relation']    = $bc_relation;
    $db_input['bc_card_com']    = $bc_card_com;
    $db_input['bc_card_num']    = preg_replace('/[^0-9]/', '', $bc_card_num);
    $db_input['bc_card_cvc']    = $bc_card_cvc;
    $db_input['bc_acc']         = $bc_acc;
    $db_input['bc_acc_date']    = $bc_acc_date;
    $db_input['b_sign']         = $sign1;
    $db_input['b_agree']        = $b_agree;
    $db_input['b_agree1']       = $b_agree1;
    break;
}

$db_input['wdate'] = date("Y-m-d H:i:s");

$serviceModel = new IUD_Model();
$serviceTable = "iu_service";
$serviceModel->insert($serviceTable, $db_input);

alert("정상 등록되었습니다.", "./list.php");