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
        <div class="smb-card__li default-card">
          <div class="lt">
            <p class="name">우리카드<span class="tag on">기본</span></p>
            <p class="number">0000-0000-0000-0000</p>
          </div>
          <div class="rt">
            <button type="button" class="ui-btn delete">삭제</button>
          </div>
        </div>
        <!-- } loop -->
        <div class="smb-card__li">
          <div class="lt">
            <p class="name">하나카드</p>
            <p class="number">0000-0000-0000-0000</p>
          </div>
          <div class="rt">
            <button type="button" class="ui-btn delete">삭제</button>
          </div>
        </div>
      </div>
      <div class="btn_confirm">
        <a href="./card_write.php" class="ui-btn round stBlack add-btn">결제카드 추가</a>
      </div>
    </form>
  </div>
</div>

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