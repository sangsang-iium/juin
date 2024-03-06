<?php
include_once("./_common.php");

if(!$is_member)
	goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);

$tb['title'] = "카드관리";
include_once("./_head.php");
?>

<div id="contents" class="sub-contents cardMngList">
  <div id="smb-wCard" class="container">
    <form name="ajaxFormSbm" id="cardform" method="post" action="./card_update.php">
      <input type="text" name="mb_id" value="<?php echo $mb_id?>">
      <div class="smb-wCard-wrap">
        <div class="form-row">
          <div class="form-head">
            <p class="title">카드번호</p>
          </div>
          <div class="form-body card">
            <input type="text" name="cr_num1" id="cr_num1" class="frm-input" maxlength="4" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="text" name="cr_num2" id="cr_num2" class="frm-input" maxlength="4" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="text" name="cr_num3" id="cr_num3" class="frm-input" maxlength="4" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="text" name="cr_num4" id="cr_num4" class="frm-input" maxlength="4" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">유효기간</p>
          </div>
          <div class="form-body card">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="cr_month" id="cr_month" maxlength="2" required class="frm-input" placeholder="mm">
            <span class="hyphen">/</span>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="cr_year" id="cr_year" maxlength="2" required class="frm-input" placeholder="yy">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">생년월일(6자리)</p>
          </div>
          <div class="form-body">
            <input type="text" name="cr_birth" id="cr_birth" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="6" required class="frm-input w-per100">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title">비밀번호(앞 2자리)</p>
          </div>
          <div class="form-body">
            <input type="password" name="cr_password" id="cr_password" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  maxlength="2" required class="frm-input w-per100">
          </div>
        </div>
      </div>
      <div class="btn_confirm">
        <button type="button" class="ui-btn round stBlack add-btn" onclick="ajaxFormSubmitz()">결제카드 등록</button>
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
function ajaxFormSubmitz() {
      var params = $("#ajaxFormSbm").serializeArray(); // serialize() : 입력된 모든Element(을)를 문자열의 데이터에 serialize 한다.
      if(ajaxFormSbm.mb_id.value == ""){
        alert("잘못된 접근입니다.");
        return false;
      }
      if(ajaxFormSbm.cr_num1.value == "" || ajaxFormSbm.cr_num2.value == "" || ajaxFormSbm.cr_num3.value == "" || ajaxFormSbm.cr_num4.value == ""){
        alert("카드 번호를 입력해주세요.");
        return false;
      }
      if (ajaxFormSbm.cr_month.value == "" || ajaxFormSbm.cr_year.value == "") {
        alert("유효기간을 입력해주세요.");
        return false;
      }
      if (ajaxFormSbm.cr_birth.value == "") {
        alert("생년월일을 입력해주세요.");
        return false;
      }
      if (ajaxFormSbm.cr_password.value == "") {
        alert("카드 비밀번호 앞 두자리를 입력해주세요.");
        return false;
      }
      jQuery.ajax({
        url: '/m/shop/card_update.php',
        type: 'POST',
        data:params,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: "json",
        success: function (res) {
            if (res.code == 200){
                alert("카드등록이 완료 되었습니다.");
                location.href=document.referrer;
            } else {
              alert("잘못된 카드 정보 입니다.");
            }
        }
      });
    }
</script>

<?php
include_once("./_tail.php");
?>