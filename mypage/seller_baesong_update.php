<?php
include_once("./_common.php");

check_demo();

check_admin_token();

unset($value);
$value['delivery_method']	= $_POST['delivery_method'];
$value['delivery_price']	= conv_number($_POST['delivery_price']);
$value['delivery_price2']	= conv_number($_POST['delivery_price2']);
$value['delivery_minimum']	= conv_number($_POST['delivery_minimum']);	
$value['baesong_cont1']		= $_POST['baesong_cont1'];
$value['baesong_cont2']		= $_POST['baesong_cont2'];
update("shop_seller",$value,"where mb_id='$member[id]'");

goto_url(BV_MYPAGE_URL.'/page.php?code=seller_baesong');
?>