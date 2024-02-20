<?php
include_once("./_common.php");
include_once(BV_SHOP_PATH.'/settle_naverpay.inc.php');

if(BV_IS_MOBILE) {
	goto_url(BV_MSHOP_URL.'/cart.php');
}

$tb['title'] = '장바구니';
include_once("./_head.php");

$sql = " select * 
		   from shop_cart 
		  where ct_direct = '$set_cart_id' 
		    and ct_select = '0' 
		  group by gs_id 
		  order by index_no ";
$result = sql_query($sql);
$cart_count = sql_num_rows($result);

$cart_action_url = BV_SHOP_URL.'/cartupdate.php';

include_once(BV_THEME_PATH.'/cart.skin.php');

include_once("./_tail.php");
?>