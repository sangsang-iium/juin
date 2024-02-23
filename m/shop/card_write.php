<?php
include_once("./_common.php");

if(!$is_member)
	goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);

$tb['title'] = "카드관리";
include_once("./_head.php");
?>

<div id="contents" class="sub-contents cardMngList">
  <div id="smb-wCard" class="container">
    <form name="" id="" method="post">
      <div class="smb-wCard-wrap">
        <div class="form-row">
          <div class="form-head">
            <p class="title">카드번호</p>
          </div>
          <div class="form-body card">
            <input type="text" name="" id="" class="frm-input">
            <span class="hyphen">-</span>
            <input type="text" name="" id="" class="frm-input">
            <span class="hyphen">-</span>
            <input type="text" name="" id="" class="frm-input">
            <span class="hyphen">-</span>
            <input type="text" name="" id="" class="frm-input">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">유효기간</p>
          </div>
          <div class="form-body card">
            <input type="text" name="" id="" class="frm-input" placeholder="mm">
            <span class="hyphen">/</span>
            <input type="text" name="" id="" class="frm-input" placeholder="yy">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">생년월일(8자리)</p>
          </div>
          <div class="form-body">
            <input type="text" name="" id="" class="frm-input w-per100">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">비밀번호(앞 2자리)</p>
          </div>
          <div class="form-body">
            <input type="text" name="" id="" class="frm-input w-per100">
          </div>
        </div>
      </div>
      <div class="btn_confirm">
        <button type="button" class="ui-btn round stBlack add-btn">결제카드 등록</button>
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