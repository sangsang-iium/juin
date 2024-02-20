<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가

if(defined('_PURENESS_')) return;
if(defined('BV_IS_ADMIN')) return;

//------------------------------------------------------------------------------
// 가맹점관련 모음 시작
//------------------------------------------------------------------------------

$mk = array();
$pt = array();
unset($pt_id);

// 개별도메인을 검사 후 있으면 세션을 바꾼다
$sql = "select id from shop_member where homepage = '{$_SERVER['HTTP_HOST']}'";
$row = sql_fetch($sql);
if($row['id']) {
	$temp_shopid = $row['id'].'.';
} else {
	$temp_domain = get_basedomain($_SERVER['HTTP_HOST']);
	$temp_shopid = preg_replace("/{$temp_domain}/", "", $_SERVER['HTTP_HOST']);
}

// 접속도메인이 (아이디.domain) 형태인 경우
if(substr_count($temp_shopid, ".") == 1) {
	$fr_shopid = explode('.', $temp_shopid);
	$pt_id = trim($fr_shopid[0]);

	// 가맹점인가?
	if(is_partner($pt_id)) {
		// 관리비를 사용중일때 기간이 만료되었다면 pt_id 를 비움
		if($config['pf_expire_use'] && $config['pf_session_no']) {
			$row = get_member($pt_id, 'term_date');
			if(!is_null_time($row['term_date'])) {
				if($row['term_date'] < BV_TIME_YMD) {
					unset($pt_id);
				}
			}
		}
	}
}

// 가맹점이 아니면 최고관리자로 변경
if(!is_partner($pt_id)) {
	$pt_id = 'admin';
}

/*
// 승인된 가맹점이 아니면 본사도메인으로 이동
// 사용을 원하시면 주석을 해제하세요.
if(substr_count($temp_shopid, ".") == 1 && $pt_id == 'admin') {
	if(preg_match("/bluevation\.co\.kr|bluevation\.kr|cafe24\.com/", $_SERVER['HTTP_HOST'])== false)
		goto_url(set_http($config['admin_shop_url']));
}
*/

// 가맹점아이디를 세션에담는다.
set_session('pt_id', $pt_id);

$mk = get_member($pt_id);
$pt = get_partner($pt_id);

if(!$mk['theme']) $mk['theme'] = 'basic';
if(!$mk['mobile_theme']) $mk['mobile_theme'] = 'basic';

define('BV_THEME_PATH', get_theme_path($mk['theme']));
define('BV_THEME_URL',  get_theme_url($mk['theme']));
define('BV_MTHEME_PATH', get_mobile_theme_path($mk['mobile_theme']));
define('BV_MTHEME_URL',  get_mobile_theme_url($mk['mobile_theme']));

// 방문자수의 접속을 남김
include_once(BV_LIB_PATH.'/visit_insert.inc.php');

$auth_good = false;
$auth_pg = false;

if($pt_id != 'admin') {
	// 개별 상품판매
	if($config['pf_auth_good'] == 2 || ($config['pf_auth_good'] == 3 && $mk['use_good']))
		$auth_good = true;

	// 개별 PG결제
	if($config['pf_auth_pg'] == 2 || ($config['pf_auth_pg'] == 3 && $mk['use_pg']))
		$auth_pg = true;
}

// 인트로사용시 로그인페이지로 이동을 제외함.
$intro_run = 0;
if(!$is_member && $config['shop_intro_yes']) {
	if(preg_match("/index.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/register.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/register_form.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/register_form_update.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/register_result.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/email_stop.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/password_lost.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/password_lost2.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/password_lost_certify.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_check.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/provision.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/policy.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ajax.mb_email.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ajax.mb_hp.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ajax.mb_id.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ajax.mb_recommend.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/hpcert1.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/hpcert2.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ipin1.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/ipin2.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/kcpcert_form.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/kcpcert_result.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/AuthOnlyReq.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/AuthOnlyRes.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/returnurl.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_with_facebook.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_with_google.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_with_kakao.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_with_naver.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/login_with_twitter.php/", $_SERVER['PHP_SELF'])) $intro_run++;
	if(preg_match("/oauth_check.php/", $_SERVER['PHP_SELF'])) $intro_run++;

	if(!$intro_run) {
		if(BV_IS_MOBILE) // 모바일 접속인가?
			goto_url(BV_MURL);
		else
			goto_url(BV_URL);
	}
}

// 개별 전자결제(PG)
if($auth_pg) {
	$pt_settle_pid = $pt_id;
	$default = set_partner_value($pt_id);
} else {
	$pt_settle_pid = 'admin';
}

// 본사접속일 아닐때는 가맹점 설정정보를 불러옴
if($pt_id != 'admin') {
	$default = set_default_value($pt_id);
	$config  = set_config_value($pt_id);

	if($pt['saupja_yes']) {
		$super['email'] = $mk['email'];
	}
}

// 역슬래시가 생기는 현상을 방지
$config['shop_provision'] = preg_replace("/\\\/", "", $config['shop_provision']);
$config['shop_private']   = preg_replace("/\\\/", "", $config['shop_private']);
$config['shop_policy']    = preg_replace("/\\\/", "", $config['shop_policy']);

// 매출전표 url 설정
if($default['de_card_test']) {
    define('BV_BILL_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('BV_CASH_RECEIPT_URL', 'https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
} else {
    define('BV_BILL_RECEIPT_URL', 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=');
    define('BV_CASH_RECEIPT_URL', 'https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=PGNW');
}
?>