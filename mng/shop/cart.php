<?php
include_once("./_common.php");
// include_once(BV_SHOP_PATH.'/settle_naverpay.inc.php');

if (empty($paytype)) {
  $paytype = 2;
}

$tb['title'] = '장바구니';
include_once("./_head.php");

$sql = "SELECT a.* FROM shop_cart a
				JOIN shop_goods b ON (a.gs_id = b.index_no)
				WHERE a.ct_direct = '{$set_cart_id}'
				AND a.ct_select = '0'
				AND a.reg_yn = '{$paytype}'
				group BY a.gs_id
				order BY b.mb_id, a.index_no ";
// $sql = " select *
// 		   from shop_cart
// 		  where ct_direct = '$set_cart_id'
// 		    and ct_select = '0'
// 				and reg_yn = '{$paytype}'
// 		  group by gs_id
// 		  order by index_no ";
$result = sql_query($sql);
$cart_count = sql_num_rows($result);

$cart_action_url = './cartupdate.php';


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

include_once('../skin/cart.skin.php');

include_once("./_tail.php");
?>