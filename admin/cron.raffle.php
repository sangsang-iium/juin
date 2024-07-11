<?php // 래플응모 푸시 크론탭 _20240711_SY
include_once "/home/juin/www/common.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$now = date('Y-m-d H:i');
$now = '2024-07-10 11:05';

/*
* 래플 응모 기간 종료 PUSH
*/

$raf_cnt_sel = " SELECT COUNT(*) as cnt FROM shop_goods_raffle WHERE DATE_FORMAT(event_end_date, '%Y-%m-%d %H:%i') = '{$now}' ";
$raf_cnt_row = sql_fetch($raf_cnt_sel);
if($raf_cnt_row['cnt'] > 1 ){
  $raf_end_sel = " SELECT * FROM shop_goods_raffle WHERE DATE_FORMAT(event_end_date, '%Y-%m-%d %H:%i') = '{$now}' ";
  $raf_end_res = sql_query($raf_end_sel);

  for($i=0; $raf_end_row = sql_fetch_array($raf_end_res); $i++) {
    $mem_sel = " SELECT ral.*, ra.goods_name AS goods_name, mm.fcm_token AS fcm_token 
                   FROM shop_goods_raffle_log AS ral
                      , shop_goods_raffle AS ra
                      , shop_member AS mm 
                  WHERE (ra.index_no = ral.raffle_index)
                    AND (ral.mb_id = mm.id)
                    AND ral.raffle_index = '{$raf_end_row['index_no']}' ";
    $mem_res = sql_query($mem_sel);
    while($mem_row = sql_fetch_array($mem_res)) {
      if($mem_row['prize'] == 'N') {
        
        $fcm_token = $mem_row['fcm_token'];
        $body = "축하드립니다. 응모하신 {$mem_row['goods_name']} 상품 래플 응모에 선정되셨습니다. 구매 기간에 맞춰 구매를 진행해주시기 바랍니다.";
        $message = [
          'token' => $fcm_token, // 수신자의 디바이스 토큰
          'title' => '래플 응모 당첨자 발표',
          'body' => $body
        ];
     
        // $response = sendFCMMessage($message);

        // log_write("PUSH : " . $response . ";" . $body);

      } else if($mem_row['prize'] == 'Y') {

        $fcm_token = $mem_row['fcm_token'];
        $body = "축하드립니다. 응모하신 {$mem_row['goods_name']} 상품 래플 응모에 선정되셨습니다. 구매 기간에 맞춰 구매를 진행해주시기 바랍니다.";
        $message = [
          'token' => $fcm_token, // 수신자의 디바이스 토큰
          'title' => '래플 응모 당첨자 발표',
          'body' => $body
        ];
     
        // $response = sendFCMMessage($message);

        // log_write("PUSH : " . $response . ";" . $body);
      }
    }

  }

} else {
  $mem_sel = " SELECT ral.*, ra.goods_name AS goods_name, mm.fcm_token AS fcm_token 
                 FROM shop_goods_raffle_log AS ral
                    , shop_goods_raffle AS ra
                    , shop_member AS mm 
                WHERE (ra.index_no = ral.raffle_index)
                  AND (ral.mb_id = mm.id)
                  AND DATE_FORMAT(ra.event_end_date, '%Y-%m-%d %H:%i') = '{$now}' ";
  $mem_res = sql_query($mem_sel);
  while($mem_row = sql_fetch_array($mem_res)) {
    print_r2($mem_row);
  }
  // $fcm_token = $mem_row['fcm_token'];
}


/*
* 래플 응모 당첨자 발표 PUSH
*/