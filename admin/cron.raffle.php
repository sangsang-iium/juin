<?php // 래플응모 푸시 크론탭 _20240711_SY
include_once "/home/juin/www/common.php";

$now = date('Y-m-d H');

/*
* 래플 응모 기간 종료 PUSH
*/

// 조회 시간 수정 ( 현재 시간 기준으로 이전 1시간 동안의 row 조회 )_20240802_SY
// $raf_end_sel = " SELECT * FROM shop_goods_raffle WHERE DATE_FORMAT(event_end_date, '%Y-%m-%d %H:%i') = '{$now}' ";
$raf_end_sel = " SELECT * FROM shop_goods_raffle 
                  WHERE event_end_date >= DATE_SUB('{$now}', INTERVAL 1 HOUR)
                    AND event_end_date < '{$now}' ";
$raf_end_res = sql_query($raf_end_sel);

for($e=0; $raf_end_row = sql_fetch_array($raf_end_res); $e++) {
  $end_mem_sel = " SELECT ral.*, ra.goods_name AS goods_name, mm.fcm_token AS fcm_token 
                  FROM shop_goods_raffle_log AS ral
                    , shop_goods_raffle AS ra
                    , shop_member AS mm 
                WHERE (ra.index_no = ral.raffle_index)
                  AND (ral.mb_id = mm.id)
                  AND ral.raffle_index = '{$raf_end_row['index_no']}' ";
  $end_mem_res = sql_query($end_mem_sel);

  while($end_mem_row = sql_fetch_array($end_mem_res)) {
    $fcm_token = $end_mem_row['fcm_token'];
    $body = "{$end_mem_row['goods_name']} 상품 래플 응모가 마감되었습니다.";
    $message = [
      'token' => $fcm_token, // 수신자의 디바이스 토큰
      'title' => '래플 응모 당첨자 발표',
      'body' => $body
    ];
  
    $response = sendFCMMessage($message);
  }
}

/*
* 래플 응모 당첨자 발표 PUSH
*/

// 조회 시간 수정 ( 현재 시간 기준으로 이전 1시간 동안의 row 조회 )_20240802_SY
// $raf_prize_sel = " SELECT * FROM shop_goods_raffle WHERE DATE_FORMAT(prize_date, '%Y-%m-%d %H:%i') = '{$now}' ";
$raf_prize_sel = " SELECT * FROM shop_goods_raffle 
                    WHERE prize_date >= DATE_SUB('{$now}', INTERVAL 1 HOUR)
                      AND prize_date < '{$now}' ";
$raf_prize_res = sql_query($raf_prize_sel);

for($p=0; $raf_prize_row = sql_fetch_array($raf_prize_res); $p++) {
  $prize_mem_sel = " SELECT ral.*, ra.goods_name AS goods_name, mm.fcm_token AS fcm_token 
                       FROM shop_goods_raffle_log AS ral
                          , shop_goods_raffle AS ra
                          , shop_member AS mm 
                      WHERE (ra.index_no = ral.raffle_index)
                        AND (ral.mb_id = mm.id)
                        AND ral.raffle_index = '{$raf_prize_row['index_no']}' ";
  $prize_mem_res = sql_query($prize_mem_sel);

  while($prize_mem_row = sql_fetch_array($prize_mem_res)) {
    if($prize_mem_row['prize'] == 'N') {

      $fcm_token = $prize_mem_row['fcm_token'];
      $body = "{$prize_mem_row['goods_name']} 상품 래플 응모 당첨자 선정이 완료되었습니다.";
      $message = [
        'token' => $fcm_token, // 수신자의 디바이스 토큰
        'title' => '래플 응모 당첨자 발표',
        'body' => $body
      ];
    
      $response = sendFCMMessage($message);

    } else if($prize_mem_row['prize'] == 'Y') {

      $fcm_token = $prize_mem_row['fcm_token'];
      $body = "축하드립니다. 응모하신 {$prize_mem_row['goods_name']} 상품 래플 응모에 선정되셨습니다. 구매 기간에 맞춰 구매를 진행해주시기 바랍니다.";
      $message = [
        'token' => $fcm_token, // 수신자의 디바이스 토큰
        'title' => '래플 응모 당첨자 발표',
        'body' => $body
      ];
    
      $response = sendFCMMessage($message);
    }
  }

}