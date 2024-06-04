<?php
include_once("./_common.php");
include_once(BV_SHOP_PATH.'/settle_naverpay.inc.php');


if (empty($paytype)) {
  $paytype = 2;
}

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
				and reg_yn = '{$paytype}'
        {$sql_add}
		  group by gs_id
		  order by index_no ";
$result = sql_query($sql);
$cart_count = sql_num_rows($result);

$sql_cnt = "SELECT
							SUM(cnt1) AS total_cnt1,
							SUM(cnt2) AS total_cnt2
						FROM (
							SELECT
								gs_id,
								COUNT(CASE WHEN reg_yn = 1 THEN 1 END) AS cnt1,
								COUNT(CASE WHEN reg_yn = 2 THEN 1 END) AS cnt2
							FROM shop_cart
							WHERE ct_direct = '{$set_cart_id}'
							AND ct_select = '0'
							GROUP BY gs_id
						) aa";
$row_cnt = sql_fetch($sql_cnt);

$cart_action_url = BV_MSHOP_URL.'/cartupdate.php';

include_once(BV_MTHEME_PATH.'/cart.skin.php');

include_once("./tail.sub.php");
?>