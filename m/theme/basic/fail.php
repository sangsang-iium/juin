<?php


include_once "../../../common.php";

$message = $_GET['message'];
$code    = $_GET['code'];

$previousUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'https://juinjang.kr/m/shop/orderform.php';

alert($message.':'.$code, $previousUrl);
?>

<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="https://static.toss.im/icons/png/4x/icon-toss-logo.png" />
    <link rel="stylesheet" type="text/css" href="./public/style.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>토스페이먼츠 결제 실패</title>
  </head>

  <body>
    <div class="box_section" style="width: 600px">
      <!-- <img width="100px" src="https://static.toss.im/lotties/error-spot-no-loop-space-apng.png" />
      <h2>결제를 실패했어요</h2>

      <div class="p-grid typography--p" style="margin-top: 50px">
        <div class="p-grid-col text--left"><b>에러메시지</b></div>
        <div class="p-grid-col text--right" id="message"><?php echo $message ?></div>
      </div>
      <div class="p-grid typography--p" style="margin-top: 10px">
        <div class="p-grid-col text--left"><b>에러코드</b></div>
        <div class="p-grid-col text--right" id="code"><?php echo $code ?></div>
      </div> -->
      <!-- <div class="p-grid">
        <button class="button p-grid-col5" onclick="location.href='https://docs.tosspayments.com/guides/payment/integration';">연동 문서</button>
        <button class="button p-grid-col5" onclick="location.href='https://discord.gg/A4fRFXQhRu';" style="background-color: #e8f3ff; color: #1b64da">실시간 문의</button>
      </div> -->

    </div>
  </body>

</html>