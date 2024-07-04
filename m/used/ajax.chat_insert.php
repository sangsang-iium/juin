<?php
include_once('./_common.php');
//include_once G5_LIB_PATH.'/thumbnail.lib.php';

$chatno = trim($_POST['chatno']);
$content = trim($_POST['content']);

sql_query("insert into shop_used_chatd set pno={$chatno}, mb_id='{$member['id']}', content='$content', regdate='".BV_TIME_YMDHIS."'");
sql_query("update shop_used_chat set lasttime='".BV_SERVER_TIME."' where no={$chatno}");



// 채팅 PUSH _20240704_SY
$chat_sel = " SELECT room.mb_id AS seller, sub.mb_id AS buyer, chat.*
                FROM shop_used AS room, shop_used_chat AS sub, shop_used_chatd AS chat
               WHERE room.no = sub.pno
                 AND sub.no  = chat.pno
                 AND room.no = '{$chatno}'
            ORDER BY chat.`no` DESC 
                LIMIT 1 ";
$chat_row = sql_fetch($chat_sel);

$seller = $chat_row['seller'];
$buyer  = $chat_row['buyer'];
$sender = $chat_row['mb_id'];
$mread  = $chat_row['mread'];
$uread  = $chat_row['uread'];

if($seller == $sender && $uread != '1') {
  // 판매자가 채팅 보냈을 때
  $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$buyer}' ";
  $token_row = sql_fetch($token_sel);
  // $fcm_token = $token_row['fcm_token'];
  // 테스트 토큰
  $fcm_token = "eQWmi-2FT8eL5C_SPtGi0E:APA91bGUA5K1gYAcmTY1Pz-Yn6BJn65OpmAsCT_RUDLpZ3wNPPzg10qbanZXcAdPOQ42uX7kpVs0Yvx_oQ5wNYay9nxlZSeNgL2ViRpVFefMHjGxCUnPW47rAwvYrxOKG7l9x-ZfESBA";

  $message = [
    'token' => $fcm_token,
    'title' => '채팅알림',
    'body'  => '주인장 중고장터 메신저가 도착했습니다.'
  ];
  $response = sendFCMMessage($message);

} else if($buyer == $sender && $mread != '1') {
  // 구매자가 채팅 보냈을 때
  $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$seller}' ";
  $token_row = sql_fetch($token_sel);
  // $token = $token_row['fcm_token'];
  // 테스트 토큰
  $fcm_token = "eQWmi-2FT8eL5C_SPtGi0E:APA91bGUA5K1gYAcmTY1Pz-Yn6BJn65OpmAsCT_RUDLpZ3wNPPzg10qbanZXcAdPOQ42uX7kpVs0Yvx_oQ5wNYay9nxlZSeNgL2ViRpVFefMHjGxCUnPW47rAwvYrxOKG7l9x-ZfESBA";

  $message = [
      'token' => $fcm_token,
      'title' => '채팅알림',
      'body'  => '주인장 중고장터 메신저가 도착했습니다.'
  ];
  $response = sendFCMMessage($message);
}

exit;
?>