<?php
include_once("./_common.php");

if($is_member) {
    goto_url(BV_MURL);
}

// 본사쇼핑몰에서 회원가입을 받지 않을때
$config['admin_reg_msg'] = str_replace("\r\n", "\\r\\n", $config['admin_reg_msg']);
if($config['admin_reg_yes'] && $pt_id == 'admin') {
	alert($config['admin_reg_msg'], BV_MURL);
}

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

$tb['title'] = '약관동의';
include_once("./_head.php");

$register_action_url = BV_MBBS_URL.'/register_form.php';
include_once(BV_MTHEME_PATH.'/register.skin.php');

include_once("./_tail.php");
?>