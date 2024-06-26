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
  $sql_add = " AND a.mb_id = '{$member['id']}' ";
} else {
  $sql_add = "";
}
$sql = "SELECT a.*, b.sc_type FROM shop_cart a
				JOIN shop_goods b ON (a.gs_id = b.index_no)
				WHERE a.ct_direct = '{$set_cart_id}'
				AND a.ct_select = '0'
				AND a.reg_yn = '{$paytype}'
				 {$sql_add}
				group BY a.gs_id
				order BY b.sc_type desc, b.mb_id, a.index_no ";
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