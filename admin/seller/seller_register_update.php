<?php
include_once("./_common.php");
include_once(BV_LIB_PATH."/register.lib.php");


check_demo();

check_admin_token();

// Insert Member 추가 _20240614_SY
$mb_id = trim($_POST['mb_id']);

$mb = get_member($mb_id);
if($mb['id'])
	alert('이미 존재하는 회원아이디입니다.\\nＩＤ : '.$mb['id'].'\\n이름 : '.$mb['name'].'\\n메일 : '.$mb['email']);

unset($memIns);
$memIns['id']         = $mb_id; 
$memIns['passwd']     = $_POST['mb_password']; 
$memIns['name']       = $_POST['mb_name']; 
$memIns['cellphone']  = $mb_hp; 
$memIns['zip']        = $_POST['mb_zip']; 
$memIns['addr1']      = $_POST['mb_addr1']; 
$memIns['addr2']      = $_POST['mb_addr2']; 
$memIns['addr3']      = $_POST['mb_addr3'];
$memIns['addr_jibeon']= $_POST['mb_addr_jibeon'];
$memIns['reg_time']   = BV_TIME_YMDHIS;
$memIns['mb_ip']			= $_SERVER['REMOTE_ADDR']; //IP
$memIns['grade']      = $_POST['mb_grade']; 
$memIns['pt_id']      = $_POST['mb_recommend']; 
$memIns['mailser']    = $_POST['mb_mailling']; 
$memIns['smsser']     = $_POST['mb_sms']; 
$memIns['mb_certify'] = $_POST['mb_certify']; 
$memIns['mb_adult']   = $_POST['mb_adult']; 

insert("shop_member", $memIns);

unset($value);
// $mb_id = explode("|",$_POST['mb_id']);
$value['seller_code']		    = code_uniqid();
$value['mb_id']             = trim($_POST['mb_id']);
$value['seller_item']		    = $_POST['seller_item'];
$value['company_name']		  = $_POST['company_name'];
$value['company_saupja_no']	= $_POST['company_saupja_no'];
$value['company_item']		  = $_POST['company_item'];
$value['company_service']	  = $_POST['company_service'];
$value['company_owner']		  = $_POST['company_owner'];
$value['company_tel']		    = $_POST['company_tel'];
$value['company_fax']		    = $_POST['company_fax'];
$value['company_zip']		    = $_POST['company_zip'];
$value['company_addr1']		  = $_POST['company_addr1'];
$value['company_addr2']		  = $_POST['company_addr2'];
$value['company_addr3']		  = $_POST['company_addr3'];
$value['company_addr_jibeon'] = $_POST['company_addr_jibeon'];
$value['company_hompage']	  = $_POST['company_hompage'];
$value['info_name']			    = $_POST['info_name'];
$value['info_tel']			    = $_POST['info_tel'];
$value['info_email']		    = $_POST['info_email'];
$value['bank_name']			    = $_POST['bank_name'];
$value['bank_account']		  = $_POST['bank_account'];
$value['bank_holder']		    = $_POST['bank_holder'];
$value['memo']				      = $_POST['memo'];
$value['reg_time']			    = BV_TIME_YMDHIS;
$value['update_time']		    = BV_TIME_YMDHIS;

// income 추가 _20240508_SY
if($_POST['income_type'] == '0') {
  $income_per = 0;
  $income_price = 0;
} else {
  if($_POST['incomePer_type'] == '0') {
    $income_per = 0;
    $income_price = $_POST['income_price'];
  } else if($_POST['incomePer_type'] == '1') {
    $income_per = $_POST['income_per'];
    $income_price = 0;
  }
}
$value['income_type']		    = $_POST['income_type'];
$value['income_per_type']   = $_POST['incomePer_type'];
$value['income_price']	    = $income_price;
$value['income_per']		    = $income_per;

insert("shop_seller", $value);

alert("등록 완료", BV_ADMIN_URL.'/seller.php?code=register');
?>