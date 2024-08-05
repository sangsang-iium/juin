<?php
include_once "./_common.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$postData  = file_get_contents("php://input");
$post_data = json_decode($postData, true);
log_write($post_data);

$secret = $post_data['secret'];

if ($post_data['status'] == 'DONE') {
  $sql_secret = "SELECT * FROM toss_virtual_account WHERE `secret` = '{$secret}'";
  $row_secret = sql_fetch($sql_secret);

  if ($row_secret['idx']) {
    $VA                    = new IUD_Model();
    $VA_table              = "toss_virtual_account";
    $VA_data['status']     = $post_data['status'];
    $VA_data['approvedAt'] = $post_data['approvedAt'];
    $VA_where              = "WHERE secret = '{$secret}'";
    $VA->update($VA_table, $VA_data, $VA_where);

    $SO             = new IUD_Model();
    $SO_table       = "shop_order";
    $SO_data['dan'] = 2;
    $SO_where       = "WHERE od_id = '{$post_data['orderId']}'";
    $SO->update($SO_table, $SO_data, $SO_where);

  } else {
    log_write($post_data . "[db 값 없음]");
  }
} else if ($post_data['status'] == 'CANCELED' || $post_data['status'] == 'EXPIRED' || $post_data['status'] == 'ABORTED') {
  $sql_secret = "SELECT * FROM toss_virtual_account WHERE `secret` = '{$secret}'";
  $row_secret = sql_fetch($sql_secret);

  if ($row_secret['idx']) {
    $VA                    = new IUD_Model();
    $VA_table              = "toss_virtual_account";
    $VA_data['status']     = $post_data['status'];
    $VA_data['approvedAt'] = $post_data['approvedAt'];
    $VA_where              = "WHERE secret = '{$secret}'";
    $VA->update($VA_table, $VA_data, $VA_where);

    $SO             = new IUD_Model();
    $SO_table       = "shop_order";
    $SO_data['dan'] = 6;
    $SO_where       = "WHERE od_id = '{$post_data['orderId']}'";
    $SO->update($SO_table, $SO_data, $SO_where);

  } else {
    log_write($post_data . "[db 값 없음]");
  }
}
