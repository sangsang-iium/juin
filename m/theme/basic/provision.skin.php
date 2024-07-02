<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

// 메시지 전송 예제
$message = [
    'token' => $member['fcm_token'], // 수신자의 디바이스 토큰
    'title' => 'Hello',
    'body' => 'This is a test notification.'
];

echo $response = sendFCMMessage($message);

?>

<!-- <h2 class="pop_title">
	<?php echo $tb['title']; ?>
	<a href="javascript:window.close();" class="btn_small bx-white">창닫기</a>
</h2>
<div class="m_agree">
	<?php echo nl2br($config['shop_provision']); ?>
</div>
<div class="btn_confirm">
	<button type="button" onclick="window.close();" class="btn_medium bx-white">창닫기</button>
</div> -->

<div id="contents">

	<div class="m_agree">
		<div class="container">
			<?php echo nl2br($config['shop_private']); ?>
		</div>
	</div>

</div>