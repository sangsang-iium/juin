<?php
include_once("./_common.php");

check_demo();

check_admin_token();

unset($value);
$mb_id = explode("|",$_POST['mb_id']);
$value['seller_code']		  = code_uniqid();
$value['mb_id']				  = $mb_id[1];
$value['seller_item']		  = $_POST['seller_item'];
$value['company_name']		  = $_POST['company_name'];
$value['company_saupja_no']	  = $_POST['company_saupja_no'];
$value['company_item']		  = $_POST['company_item'];
$value['company_service']	  = $_POST['company_service'];
$value['company_owner']		  = $_POST['company_owner'];
$value['company_tel']		  = $_POST['company_tel'];
$value['company_fax']		  = $_POST['company_fax'];
$value['company_zip']		  = $_POST['company_zip'];
$value['company_addr1']		  = $_POST['company_addr1'];
$value['company_addr2']		  = $_POST['company_addr2'];
$value['company_addr3']		  = $_POST['company_addr3'];
$value['company_addr_jibeon'] = $_POST['company_addr_jibeon'];
$value['company_hompage']	  = $_POST['company_hompage'];
$value['info_name']			  = $_POST['info_name'];
$value['info_tel']			  = $_POST['info_tel'];
$value['info_email']		  = $_POST['info_email'];
$value['bank_name']			  = $_POST['bank_name'];
$value['bank_account']		  = $_POST['bank_account'];
$value['bank_holder']		  = $_POST['bank_holder'];
$value['memo']				  = $_POST['memo'];
$value['reg_time']			  = BV_TIME_YMDHIS;
$value['update_time']		  = BV_TIME_YMDHIS;

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

goto_url(BV_ADMIN_URL.'/seller.php?code=register');
?>