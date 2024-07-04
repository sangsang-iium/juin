<?php
include_once('./_common.php');

// 래플 상품 명 _20240703_SY
$gs_name = $_POST['gs_name'];

if($member['id']) {
  $rafflePrizeCheck = rafflePrizeCheck($index_no);
  if($rafflePrizeCheck) {
    $sql = " INSERT INTO shop_goods_raffle_log SET
            raffle_index = '$index_no',
            mb_id = '{$member['id']}',
            mb_name = '{$member['name']}',
            reg_time = '".BV_TIME_YMDHIS."',
            prize = 'N' ";
            sql_query($sql);
    $returnArr = array('res' => 'Y');

    // Push 추가 _20240703_SY
    $message = [
      'token' => $member['fcm_token'], // 수신자의 디바이스 토큰
      'title' => '래플 응모 완료',
      'body' => "{$gs_name} 상품 래플 응모가 완료되었습니다."
    ];
    $response = sendFCMMessage($message);
  } else {
    $returnArr = array('res' => 'N');
  }
}
die(json_encode($returnArr));
?>