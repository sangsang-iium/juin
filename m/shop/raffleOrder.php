<?php
include_once "./_common.php";

if(!$index_no) {
  $url = '';
  die(json_encode(array('url'=>$url)));
}

$gs_name = $_POST['gs_name'];
$type    = $_POST['type'];

// $gs_id = $index_no."000000"; 

// // 기존 장바구니 자료를 먼저 삭제
// $sql = "select * from shop_cart where gs_id='$gs_id' and ct_select='0' and ct_direct='$set_cart_id'";
// $res = sql_query($sql);
// while ($row = sql_fetch_array($res)) {
//   $sql = " delete from shop_order
//         where od_id = '{$row['od_id']}'
//         and od_no = '{$row['od_no']}'
//         and gs_id = '{$row['gs_id']}'
//         and dan = '0' ";
//   sql_query($sql, FALSE);
// }

// sql_query(" delete from shop_cart where gs_id='$gs_id' and ct_select='0' and ct_direct='$set_cart_id' ");



// $sql = " SELECT * FROM shop_goods_raffle WHERE index_no =  '$index_no' ";
// $res = sql_fetch($sql);

// $ca_id = '';
// $ct_qty = 1;
// $raffleIndexNo = $res['index_no']."000000"; 
// $raffle_price = $res['raffle_price'];

// // 중복되지 않는 유일키를 생성
// $od_no = cart_uniqid();

// $sql = " insert into shop_cart
//       ( ca_id, mb_id, gs_id, ct_direct, ct_time, ct_price, ct_supply_price, ct_qty, ct_point, io_id, io_type, io_supply_price, io_price, ct_option, ct_send_cost, od_no, ct_ip, raffle, reg_yn )
//     VALUES ";
// $sql .= "( '$ca_id', '{$member['id']}', '{$raffleIndexNo}', '$set_cart_id', '" . BV_TIME_YMDHIS . "', '{$raffle_price}', '{$raffle_price}', '$ct_qty', '0', '', '', '', '', '', '', '$od_no', '{$_SERVER['REMOTE_ADDR']}', '1', '2' ) ";

// sql_query($sql);
// $ss_cart_id .= $comma . sql_insert_id();
// $comma = ",";

// set_session('ss_cart_id', $ss_cart_id);

// $url = BV_MSHOP_URL . "/orderform.php";
// die(json_encode(array('url'=>$url)));



if($member['id']) {
  if($type == "cancle") {
    $sql = " DELETE FROM shop_goods_raffle_log 
                WHERE raffle_index = '$index_no'
                AND mb_id = '{$member['id']}' ";
                sql_query($sql);

    $returnArr = array('res' => 'N');

    $message = [
      'token' => $member['fcm_token'], // 수신자의 디바이스 토큰
      'title' => '래플 취소 완료',
      'body' => "{$gs_name} 상품 래플 취소가 완료되었습니다."
    ];
    $response = sendFCMMessage($message);
  }
}
die(json_encode($returnArr));


?>