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
        회원님의 아이디 찾기가 완료 되었습니다.<br>
        회원님의 아이디는 <strong id="userId">kshn****</strong> 입니다.
			</p>
		</div>
	</div>
	<div class="userLost-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
				<a href="<?php echo BV_MBBS_URL; ?>/login.php" class="ui-btn round stBlack">로그인</a>
				<a href="<?php echo BV_MBBS_URL; ?>/find_password.php" class="ui-btn round stWhite st2">비밀번호 찾기</a>
			</div>
		</div>
	</div>
</div>
</form>
