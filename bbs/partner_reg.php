<?php
include_once("./_common.php");

if(BV_IS_MOBILE) {
	goto_url(BV_MBBS_URL.'/partner_reg.php');
}

if(!$config['partner_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', BV_URL);
}

if(!$is_member) {
	goto_url(BV_BBS_URL.'/login.php?url='.$urlencode);
}

$tb['title'] = '쇼핑몰 분양신청';
include_once("./_head.php");

if($partner['mb_id']) {
	include_once(BV_THEME_PATH.'/partner_reg_result.skin.php');
} else {
	$token = md5(uniqid(rand(), true));
	set_session("ss_token", $token);

	$from_action_url = BV_HTTPS_BBS_URL.'/partner_reg_update.php';
	include_once(BV_THEME_PATH.'/partner_reg.skin.php');
}

include_once("./_tail.php");
?>