<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<form name="fpasswordlost" action="<?php echo $form_action_url; ?>" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<div id="contents" class="sub-contents userLost passwordLost">
	<div class="passwordLost-wrap">
		<div class="container">
			<p class="passwordLost-text">
        회원님의 계정정보가 정상적으로 조회되었습니다.<br>
        회원님의 안전한 계정 보호를 위해 비밀번호를 재설정해주시기 바랍니다.
			</p>
      <form action="">
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_mb_id">아이디</label><b>*</b></p>
          </div>
          <div class="form-body">
            <input type="text" name="mb_id" value="" id="reg_mb_id" required="" class=" frm-input w-per100" size="20" maxlength="20" placeholder="아이디를 입력해주세요." autocapitalize="off">
          </div>
        </div>
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
            <input type="tel" name="mb_hp[]" value="" id="reg_mb_hp" required="" class="frm-input phone_no1" size="20" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
