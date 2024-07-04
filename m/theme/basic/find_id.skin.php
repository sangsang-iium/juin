<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<form name="fpasswordlost" action="<?php echo $form_action_url; ?>" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<div id="contents" class="sub-contents userLost passwordLost">
	<div class="passwordLost-wrap">
		<div class="container">
			<p class="passwordLost-text">
				회원가입 시 등록하신 이름과 휴대번호를 입력해 주세요.<br>
				본인인증을 통해 일부 아이디 정보를 확인 할 수 있습니다.
			</p>
      <form action="">
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_mb_name">이름</label><b>*</b></p>
          </div>
          <div class="form-body">
            <input type="text" name="mb_name" id="reg_mb_name" required class="frm-input w-per100" placeholder="이름을 입력해주세요">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_mb_hp">핸드폰번호</label><b>*</b></p>
          </div>
          <div class="form-body phone">
            <input type="tel" name="mb_hp[]" value="" id="reg_mb_hp" required="" class="frm-input  phone_no1" size="20" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="tel" name="mb_hp[]" value="" class="frm-input phone_no2" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="tel" name="mb_hp[]" value="" class="frm-input phone_no3" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
          </div>
        </div>
      </form>
		</div>
	</div>
	<div class="userLost-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
				<input type="submit" value="본인인증" id="btn_submit" class="ui-btn round stBlack">
			</div>
		</div>
	</div>
</div>
</form>
