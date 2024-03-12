<?php
include_once("./_common.php");
include_once(BV_SHOP_PATH.'/settle_naverpay.inc.php');

$tb['title'] = '장바구니';
include_once("./_head.php");

// 장바구니 구분 추가 _20240312_SY
if($is_member) {
  $sql_add = " AND mb_id = '{$member['id']}' ";
} else {
  $sql_add = "";
}

$sql = " select * 
		   from shop_cart 
		  where ct_direct = '$set_cart_id' 
		    and ct_select = '0' 
        {$sql_add}
		  group by gs_id 
		  order by index_no ";
$result = sql_query($sql);
$cart_count = sql_num_rows($result);

$cart_action_url = BV_MSHOP_URL.'/cartupdate.php';

include_once(BV_MTHEME_PATH.'/cart.skin.php');

include_once("./tail.sub.php");
?>