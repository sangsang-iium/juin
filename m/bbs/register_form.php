<?php
include_once('./_common.php');
include_once(BV_LIB_PATH.'/register.lib.php');

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);
set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");
set_session("ss_hash_token", BV_HASH_TOKEN);

if($w == "") {

    // 회원 로그인을 한 경우 회원가입 할 수 없다
    // 경고창이 뜨는것을 막기위해 아래의 코드로 대체
    // alert("이미 로그인중이므로 회원 가입 하실 수 없습니다.", "./");
	if($is_member) {
		goto_url(BV_MURL);
	}

	// 본사쇼핑몰에서 회원가입을 받지 않을때  
	$config['admin_reg_msg'] = str_replace("\r\n", "\\r\\n", $config['admin_reg_msg']);
	if($config['admin_reg_yes'] && $pt_id == 'admin') {
		alert($config['admin_reg_msg'], BV_MURL);
	}

    if(!isset($_POST['agree']) || !$_POST['agree']) {
        alert('회원가입 약관 내용에 동의하셔야 회원가입 하실 수 있습니다.', BV_MBBS_URL.'/register.php');
    }

    if(!isset($_POST['agree2']) || !$_POST['agree2']) {
        alert('개인정보 수집 및 이용 내용에 동의하셔야 회원가입 하실 수 있습니다.', BV_MBBS_URL.'/register.php');
    }

    $agree  = preg_replace('#[^0-9]#', '', $_POST['agree']);
    $agree2 = preg_replace('#[^0-9]#', '', $_POST['agree2']);

	$tb['title'] = '회원가입';

	// 추천인을 담는다.
	$member['pt_id'] = $pt_id;

} else if($w == 'u') {

    if(!$is_member)
        alert('로그인 후 이용하여 주십시오.', BV_MURL);

    if($member['id'] == 'admin')
        alert('관리자의 회원정보는 관리자 화면에서 수정해 주십시오.', BV_MURL);

    if($member['id'] != $_POST['mb_id'])
        alert('로그인된 회원과 넘어온 정보가 서로 다릅니다.');

    /*
    if(!($member[passwd] == sql_password($_POST[mb_password]) && $_POST[mb_password]))
        alert("비밀번호가 틀립니다.");

    // 수정 후 다시 이 폼으로 돌아오기 위해 임시로 저장해 놓음
    set_session("ss_tmp_password", $_POST[mb_password]);
    */

    if($_POST['mb_password']) {
        // 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
        if($_POST['is_update'])
            $tmp_password = $_POST['mb_password'];
        else
            $tmp_password = get_encrypt_string($_POST['mb_password']);

        if($member['passwd'] != $tmp_password)
            alert('비밀번호가 틀립니다.');
    }
    
    // 보안상 암호화로 수정 _20240610_SY  
    $_POST['mb_password'] = $tmp_password;
	
    $tb['title'] = '회원정보수정';

    set_session("ss_reg_mb_name", $member['name']);
    set_session("ss_reg_mb_hp", $member['cellphone']);

} else {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

include_once('./_head.php');

$required = ($w=='') ? ' required' : '';
$readonly = ($w=='u') ? ' readonly' : '';

$agree  = preg_replace('#[^0-9]#', '', $agree);
$agree2 = preg_replace('#[^0-9]#', '', $agree2);

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// if($config['register_use_addr'])
//     add_javascript(BV_POSTCODE_JS, 0); //다음 주소 js


$register_action_url = BV_HTTPS_MBBS_URL.'/register_form_update.php';

// 중앙회 회원 / 일반회원 구분 _20240610_SY
if($w == '') {
  ($_POST['reg_type'] == 1) ? include_once(BV_MTHEME_PATH.'/register_form.skin.php') : include_once(BV_MTHEME_PATH.'/register_form.normal.skin.php');
} else {
  ($member['grade'] == 8) ? include_once(BV_MTHEME_PATH.'/register_form.skin.php') : include_once(BV_MTHEME_PATH.'/register_form.normal.skin.php');
} 
include_once("./_tail.php");
?>