<?php
include_once("./_common.php");

if(BV_IS_MOBILE) {
	goto_url(BV_MSHOP_URL.'/gift.php');
}

if(!$config['gift_yes']) {
    alert("쿠폰사용이 중지 되었습니다.");
}

if(!$is_member) {
	goto_url(BV_BBS_URL.'/login.php?url='.$urlencode);
}

$tb['title'] = '쿠폰인증';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$form_action_url = BV_HTTPS_SHOP_URL.'/gift_update.php';
include_once(BV_THEME_PATH.'/gift.skin.php');

include_once("./_tail.php");
?>