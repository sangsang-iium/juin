<?php // 3일 후 자동 구매확정 _20240802_SY
include_once "/home/juin/www/common.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$today = date('Y-m-d');
$now   = BV_TIME_YMDHIS;
$table = "shop_order";

/** Table Column
 * dan : 주문상태 ( 5 : 배송완료)
 * invoice_date : 배송완료일시 : 0000-00-00 00:00:00
 * user_ok : 구매확정유무 : 0 / 1
 * user_date : 구매확정일시 : 0000-00-00 00:00:00
 * 
 * 배송후 반품 & 배송후 교환의 경우 → 구매확정 제외
 */

$list_sel = " SELECT * FROM {$table} 
               WHERE '{$today}' >= LEFT(DATE_ADD(invoice_date, INTERVAL 3 DAY),10) 
                 AND dan = '5'
                 AND user_ok = 0
            ORDER BY invoice_date 
            ";
$list_res = sql_query($list_sel);

while($list_row = sql_fetch_array($list_res)) {
  $UPDATE = new IUD_Model;

  $upd_data['user_ok']   = 1;
  $upd_data['user_date'] = $now;
  $upd_where = " WHERE index_no = '{$list_row['index_no']}' AND od_no = '{$list_row['od_no']}' ";

  $UPDATE->update($table, $upd_data, $upd_where);
};

