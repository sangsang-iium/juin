<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<form name="fpasswordlost" action="<?php echo $form_action_url; ?>" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<div id="contents" class="sub-contents passwordLost userLostResult">
	<div class="passwordLost-wrap">
		<div class="container">
      <div class="findComplete-img">
        <img src="/src/img/icon-check.svg" alt="회원 정보 찾기 완료">
      </div>
			<p class="passwordLost-text">
        회원님의 계정정보가 정상적으로 조회되었습니다. <br>
        회원님의 안전한 계정 보호를 위해 비밀번호를 재설정해주시기 바랍니다.
			</p>
      <form action="">
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_mb_password">비밀번호</label><b>*</b></p>
          </div>
          <div class="form-body">
            <input type="password" name="mb_password" id="reg_mb_password" required class=" frm-input w-per100" size="20" maxlength="20" placeholder="비밀번호를 입력해주세요.">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_mb_password_re">비밀번호 확인</label><b>*</b></p>
          </div>
          <div class="form-body">
            <input type="password" name="mb_password_re" id="reg_mb_password_re" required class="frm-input w-per100" size="20" maxlength="20" placeholder="비밀번호를 한번 더 입력해주세요.">
          </div>
        </div>
      </form>
		</div>
	</div>
	<div class="userLost-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
        <a href="<?php echo BV_MBBS_URL; ?>/login.php" class="ui-btn round stBlack w-per100">로그인</a>
			</div>
		</div>
	</div>
</div>
</form>
