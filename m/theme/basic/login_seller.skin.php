<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

$previous_page_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

// 회원가인 후 로그인시 오류때문에 추가 _20240308_SY
if($previous_page_url == BV_MBBS_URL."/register_result.php") {
  $previous_page_url = BV_MURL;
}

if ($gs_id) {
	$previous_page_url = $_SERVER['HTTP_REFERER']."?gs_id=".$gs_id;
}
?>

<div id="contents" class="sub-contents login">
	<div class="login-wrap">
		<div class="container">
			<div class="login-logo">
				<img src="/src/img/logo.svg" alt="주인장터 로고">
			</div>
			<!-- <div class="mb_login"> -->
				<form name="flogin" action="<?php echo $login_action_url; ?>" onsubmit="return flogin_submit(this);" method="post">
				<input type="hidden" name="url" value="/mypage/page.php?code=seller_main">
				<input type="hidden" name="ref_url" value="<?php echo $previous_page_url; ?>">
				<input type="hidden" name="seller_url" value="/mypage/page.php?code=seller_main">
				<section class="login_fs">
        	<div class="login-input">
						<label for="login_id" class="sound_only">회원아이디</label>
						<input type="text" name="mb_id" class="frm-input" id="login_id" maxLength="20" placeholder="아이디를 입력하세요." autocapitalize="off">
						<label for="login_pw" class="sound_only">비밀번호</label>
						<input type="password" name="mb_password" class="frm-input" id="login_pw" maxLength="20" placeholder="비밀번호를 입력하세요." autocapitalize="off">
        	</div>
        	<div class="login-ctrl">
          	<div class="login-save frm-choice">
							<input type="checkbox" name="auto_login" id="login_auto_login" class="css-checkbox lrg">
							<label for="login_auto_login">자동로그인</label>
						</div>
        	</div>
					<div class="login-btn">
						<button type="submit" class="ui-btn round stBlack login-btn">로그인</button></p>
						<a href="<?php echo BV_MBBS_URL; ?>/register_type.php" class="ui-btn round stWhite join-btn">회원가입</a>
						<a href="<?php echo BV_MBBS_URL; ?>/password_lost.php" class="search-btn">아이디/비밀번호 찾기</a>
        	</div>
				</section>
				<?php if($default['de_sns_login_use']) { ?>
				<p class="sns_btn">
					<?php if($default['de_naver_appid'] && $default['de_naver_secret']) { ?>
					<?php echo get_login_oauth('naver', 1); ?>
					<?php } ?>
					<?php if($default['de_facebook_appid'] && $default['de_facebook_secret']) { ?>
					<?php echo get_login_oauth('facebook', 1); ?>
					<?php } ?>
					<?php if($default['de_kakao_rest_apikey']) { ?>
					<?php echo get_login_oauth('kakao', 1); ?>
					<?php } ?>
				</p>
				<?php } ?>
				</form>

				<?php if(preg_match("/orderform.php/", $url)) { ?>
				<section class="mb_login_od">
					<h3>비회원 구매</h3>
        	<div class="login-btn">
						<a href="<?php echo BV_MSHOP_URL; ?>/orderform.php" class="ui-btn round stWhite login-btn">비회원으로 구매하기</a>
        	</div>
				</section>
				<?php } else if(preg_match("/orderinquiry.php$/", $url)) { ?>
				<form name="forderinquiry" method="post" action="<?php echo BV_MSHOP_URL; ?>/orderinquiry.php" autocomplete="off">
				<section class="mb_login_od">
					<h3>비회원 주문조회</h3>
        	<div class="login-input">
						<label for="od_id" class="sound_only">주문번호</label>
						<input type="text" name="od_id" class="frm-input" id="od_id" placeholder="주문번호">
						<label for="od_pwd" class="sound_only">비밀번호</label>
						<input type="password" name="od_pwd" class="frm-input" id="od_pwd" placeholder="비밀번호">
        	</div>
        	<div class="login-btn">
						<button type="submit" class="ui-btn round stBlack login-btn">확인</button>
        	</div>
				</section>
				</form>
				<?php } ?>
			<!-- </div> -->
		</div>
	</div>
	<!-- <div class="sns-wrap">
		<div class="container">
			<div class="sns-head">
				<p class="sns-title">간편로그인</p>
			</div>
			<div class="sns-body">
				<a href="" class="sns-link google">구글 로그인</a>
				<a href="" class="sns-link naver">네이버 로그인</a>
				<a href="" class="sns-link kakao">카카오 로그인</a>
			</div>
		</div>
	</div> -->
</div>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
	if(!f.mb_id.value) {
		alert('아이디를 입력하세요.');
		f.mb_id.focus();
		return false;
	}
	if(!f.mb_password.value) {
		alert('비밀번호를 입력하세요.');
		f.mb_password.focus();
		return false;
	}

    return true;
}

function fguest_submit(f)
{
	if(!f.od_id.value) {
		alert('주문번호를 입력하세요.');
		f.od_id.focus();
		return false;
	}
	if(!f.od_pwd.value) {
		alert('비밀번호를 입력해주세요.');
		f.od_pwd.focus();
		return false;
	}

    return true;
}
</script>
