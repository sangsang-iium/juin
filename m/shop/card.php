<?php
include_once("./_common.php");

if(!$is_member)
	goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);

$tb['title'] = "카드관리";
include_once("./_head.php");
?>

<div id="contents" class="sub-contents cardMngList">
  <div id="smb-card" class="container">
    <form name="" id="" method="post">
      <div class="smb-card-wrap">
        <!--
        기본 카드 class : default-card
        loop {
        -->
        <?php
        $sql = "SELECT * FROM iu_card_reg WHERE mb_id = '{$member['id']}'";
        $res = sql_query($sql);
          while ($row = sql_fetch_array($res)) {
            $use_card = "";
            if($row['cr_use'] == "Y"){
              $use_card = "<span class='tag on'>기본</span>";
            }
            $card_number        = $row['cr_card'];
            $parts              = preg_split('/(.{4})/', $card_number, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $masked_card_number = implode('-', $parts);
        ?>
        <div class="smb-card__li default-card">
          <div class="lt">
            <p class="name"><?php echo $row['cr_company']; ?>카드<?php echo $use_card ?></p>
            <p class="number"><?php echo $masked_card_number ?></p>
          </div>
          <div class="rt">
            <button type="button" class="ui-btn delete">삭제</button>
          </div>
        </div>
        <?php } ?>
        <!-- } loop -->
      </div>
      <div class="btn_confirm">
        <a href="javascript:void(0);" onclick="billing('카드',jsons.card);" class="ui-btn round stBlack add-btn">결제카드 추가</a>
      </div>
    </form>
  </div>
</div>
<script src="https://js.tosspayments.com/v1/payment"></script>
<!-- <button class="button is-link" onclick="billing('카드',jsons.card);">자동결제</button> -->
  <script>
    // ------ 클라이언트 키로 객체 초기화 ------
    var clientKey = 'test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq';
    var tossPayments = TossPayments(clientKey);

    var amount = 4900;
    function billing(method, requestJson) {
      console.log(requestJson);
      tossPayments.requestBillingAuth(method, requestJson)
        .catch(function (error) {
          if (error.code === "USER_CANCEL") {
            alert('취소했습니다.');
          } else {
            alert(error.message);
          }
        });
    }

    var successUrl = window.location.origin + "/m/shop/success.php";
    var failUrl = window.location.origin + "/m/shop/fail.php";

    var jsons = {
      "card": {
        // customerKey에는 가맹점에서 가지고 있는 고객 식별키를 넣어주세요.
        // 다른 사용자가 이 값을 알게 되면 악의적으로 사용할 수 있어 자동 증가하는 숫자는 안전하지 않습니다. UUID와 같이 충분히 무작위적인 고유 값으로 생성해주세요.
        "customerKey": "<?php echo uniqid();?>",
        "successUrl": successUrl,
        "failUrl": failUrl
      }
    }
  </script>

<script>
$(document).ready(function(){
  const cardEl = $(".smb-card__li");

  cardEl.on('click', function(){
    if(!$(this).hasClass('default-card')) {
      if(confirm('결제 카드를 변경하시겠습니까?')) {
        $(this).addClass('default-card').siblings().removeClass('default-card').find('.tag').remove();
        $(this).find(".name").append(`<span class="tag on">기본</span>`)
      } else {

      }
    }
  });
});
</script>

<?php
include_once("./_tail.php");
?>