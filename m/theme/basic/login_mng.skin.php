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


<link rel="stylesheet" href="/src/css/kim.css?ver=<?php echo BV_CSS_VER;?>">

<div id="mng_login">
	<div class="login-wrap">
		<div class="container">
			<div class="login-logo">
				<img src="/img/logo.png" alt="주인장터 로고">
                <p>사장이 왕이되는 식자재 장터</p>
			</div>
            <form name="flogin" action="<?php echo $login_action_url; ?>" onsubmit="return flogin_submit(this);" method="post">
                <input type="hidden" name="url" value="<?php echo $login_url; ?>">
                <input type="hidden" name="ref_url" value="<?php echo $previous_page_url; ?>">
                <section class="login_fs">
                    <div class="login-input">
                        <label for="login_id" class="sound_only">회원아이디</label>
                        <input type="text" name="mb_id" class="frm-input" id="login_id" maxLength="20" placeholder="아이디를 입력하세요." autocapitalize="off">
                        <label for="login_pw" class="sound_only">비밀번호</label>
                        <input type="password" name="mb_password" class="frm-input" id="login_pw" maxLength="20" placeholder="비밀번호를 입력하세요." autocapitalize="off">
                    </div>
                    <div class="login-ctrl">
                        <!-- <div class="login-save frm-choice">
                            <input type="checkbox" name="auto_login" id="login_auto_login" class="css-checkbox lrg">
                            <label for="login_auto_login">자동로그인</label>
                        </div> -->
                        <!-- <div class="find-wrap2">
                            <a href="<?php echo BV_MBBS_URL; ?>/find_id.php?type=1" class="search-btn">아이디 찾기</a>
                            <span class="bar">/</span>
                            <a href="<?php echo BV_MBBS_URL; ?>/find_password.php?type=1" class="search-btn">비밀번호 찾기</a>
                        </div> -->
                    </div>
                    <div class="login-btn">
                        <button type="submit" class="ui-btn round stBlack login-btn">로그인</button>
                        <!-- <a href="<?php echo BV_MBBS_URL; ?>/register_type.php" class="ui-btn round stWhite join-btn">회원가입</a> -->
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
		</div>
	</div>
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
