<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<form name="fpasswordlost" action="<?php echo $form_action_url; ?>" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<div id="contents" class="sub-contents passwordLost">
	<div class="passwordLost-wrap">
		<div class="container">
			<p class="passwordLost-text">
				회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>
				해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.
			</p>
			<div class="form-row">
				<div class="form-head">
					<p class="title"><label for="reg_mb_email">이메일</label><b>*</b></p>
				</div>
				<div class="form-body">
					<input type="text" name="mb_email" id="mb_email" required email class="frm-input w-per100" itemname="E-mail 주소" placeholder="E-mail 주소">
					<!-- <span class="at">@</span>
					<select name="" class="frm-select">
						<option value="">선택하세요.</option>
						<option value="">gmail.com</option>
						<option value="">naver.com</option>
						<option value="">hanmail.net</option>
					</select> -->
				</div>
			</div>
		</div>
	</div>
	<div class="cp-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
				<input type="submit" value="발송하기" id="btn_submit" class="ui-btn round stBlack">
			</div>
		</div>
	</div>
</div>
</form>
