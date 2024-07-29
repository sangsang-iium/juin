<?php
include_once "./_common.php";

check_demo();

check_admin_token();

print_r2($_POST);

$delivery_company = '';
$delivery_count   = count($_POST['spl_name']);
if ($delivery_count) {
  $arr_spl = array();
  for ($i = 0; $i < $delivery_count; $i++) {
    $spl_val   = trim($_POST['spl_name'][$i]) . '|' . trim($_POST['spl_url'][$i]);
    $arr_spl[] = $spl_val;
  }
  $delivery_company = implode(',', $arr_spl);
}

$delivery_mg       = '';
$delivery_mg_count = count($_POST['spl_name2']);
if ($delivery_mg_count) {
  $arr_spl2 = array();
  for ($i = 0; $i < $delivery_mg_count; $i++) {
    $spl2_val   = trim($_POST['spl_name2'][$i]);
    $arr_spl2[] = $spl2_val;
  }
  $delivery_mg = implode(',', $arr_spl2);
}

unset($value);
$value['delivery_mg']      = $delivery_mg;
$value['delivery_company'] = $delivery_company;
$value['delivery_method']  = $_POST['delivery_method'];
$value['delivery_price']   = conv_number($_POST['delivery_price']);
$value['delivery_price2']  = conv_number($_POST['delivery_price2']);
$value['delivery_minimum'] = conv_number($_POST['delivery_minimum']);
$value['baesong_cont1']    = $_POST['baesong_cont1'];
$value['baesong_cont2']    = $_POST['baesong_cont2'];
update("shop_seller", $value, "where mb_id='$mb_id'");

goto_url(BV_MYPAGE_URL . '/page.php?code=seller_baesong');
?>