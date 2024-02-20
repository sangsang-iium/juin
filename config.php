<?php
/********************
    상수 선언
********************/

define('BV_VERSION', '분양몰 v2.2.5');

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_BLUEVATION_', true);

if(PHP_VERSION >= '5.1.0') {
    //if(function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
    date_default_timezone_set("Asia/Seoul");
}

/********************
    경로 상수
********************/

/*
보안서버 도메인
회원가입, 글쓰기에 사용되는 https 로 시작되는 주소를 말합니다.
포트가 있다면 도메인 뒤에 :443 과 같이 입력하세요.
보안서버주소가 없다면 공란으로 두시면 되며 보안서버주소 뒤에 / 는 붙이지 않습니다.
입력예) https://www.domain.com:443
*/
define('BV_DOMAIN', '');
define('BV_HTTPS_DOMAIN', '');

/*
www.sample.co.kr 과 sample.co.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sample.co.kr 과 같이 입력하세요.
이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
*/
define('BV_COOKIE_DOMAIN',  '');
define('BV_DBCONFIG_FILE',  'dbconfig.php');

define('BV_ADMIN_DIR',      'admin');
define('BV_BBS_DIR',        'bbs');
define('BV_CSS_DIR',        'css');
define('BV_DATA_DIR',       'data');
define('BV_EXTEND_DIR',     'extend');
define('BV_IMG_DIR',        'img');
define('BV_JS_DIR',         'js');
define('BV_LIB_DIR',        'lib');
define('BV_MOBILE_DIR',     'm');
define('BV_MYPAGE_DIR',     'mypage');
define('BV_PLUGIN_DIR',     'plugin');
define('BV_SHOP_DIR',       'shop');
define('BV_THEME_DIR',		'theme');
define('BV_EDITOR_DIR',     'editor');
define('BV_LGXPAY_DIR',     'lgxpay');
define('BV_PHPMAILER_DIR',  'PHPMailer');
define('BV_SESSION_DIR',    'session');
define('BV_OKNAME_DIR',     'okname');
define('BV_KCPCERT_DIR',    'kcpcert');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if(BV_DOMAIN) {
    define('BV_URL', BV_DOMAIN);
} else {
    if(isset($bv_path['url']))
        define('BV_URL', $bv_path['url']);
    else
        define('BV_URL', '');
}

if(isset($bv_path['path'])) {
    define('BV_PATH', $bv_path['path']);
} else {
    define('BV_PATH', '');
}

define('BV_ADMIN_URL',      BV_URL.'/'.BV_ADMIN_DIR);
define('BV_BBS_URL',        BV_URL.'/'.BV_BBS_DIR);
define('BV_CSS_URL',        BV_URL.'/'.BV_CSS_DIR);
define('BV_DATA_URL',       BV_URL.'/'.BV_DATA_DIR);
define('BV_IMG_URL',        BV_URL.'/'.BV_IMG_DIR);
define('BV_JS_URL',         BV_URL.'/'.BV_JS_DIR);
define('BV_SHOP_URL',       BV_URL.'/'.BV_SHOP_DIR);
define('BV_LIB_URL',        BV_URL.'/'.BV_LIB_DIR);
define('BV_PLUGIN_URL',     BV_URL.'/'.BV_PLUGIN_DIR);
define('BV_MYPAGE_URL',     BV_URL.'/'.BV_MYPAGE_DIR);
define('BV_EDITOR_URL',     BV_PLUGIN_URL.'/'.BV_EDITOR_DIR);
define('BV_LGXPAY_URL',     BV_PLUGIN_URL.'/'.BV_LGXPAY_DIR);
define('BV_OKNAME_URL',     BV_PLUGIN_URL.'/'.BV_OKNAME_DIR);
define('BV_KCPCERT_URL',    BV_PLUGIN_URL.'/'.BV_KCPCERT_DIR);

// PATH 는 서버상에서의 절대경로
define('BV_ADMIN_PATH',     BV_PATH.'/'.BV_ADMIN_DIR);
define('BV_BBS_PATH',       BV_PATH.'/'.BV_BBS_DIR);
define('BV_DATA_PATH',      BV_PATH.'/'.BV_DATA_DIR);
define('BV_EXTEND_PATH',    BV_PATH.'/'.BV_EXTEND_DIR);
define('BV_LIB_PATH',       BV_PATH.'/'.BV_LIB_DIR);
define('BV_PLUGIN_PATH',    BV_PATH.'/'.BV_PLUGIN_DIR);
define('BV_SHOP_PATH',      BV_PATH.'/'.BV_SHOP_DIR);
define('BV_MYPAGE_PATH',    BV_PATH.'/'.BV_MYPAGE_DIR);
define('BV_SESSION_PATH',   BV_DATA_PATH.'/'.BV_SESSION_DIR);
define('BV_EDITOR_PATH',    BV_PLUGIN_PATH.'/'.BV_EDITOR_DIR);
define('BV_PHPMAILER_PATH', BV_PLUGIN_PATH.'/'.BV_PHPMAILER_DIR);
define('BV_LGXPAY_PATH',    BV_PLUGIN_PATH.'/'.BV_LGXPAY_DIR);
define('BV_OKNAME_PATH',    BV_PLUGIN_PATH.'/'.BV_OKNAME_DIR);
define('BV_KCPCERT_PATH',   BV_PLUGIN_PATH.'/'.BV_KCPCERT_DIR);

// 모바일경로 상수
define('BV_MPATH',			BV_PATH.'/'.BV_MOBILE_DIR);
define('BV_MURL',			BV_URL.'/'.BV_MOBILE_DIR);
define('BV_MBBS_PATH',		BV_MPATH.'/'.BV_BBS_DIR);
define('BV_MBBS_URL',		BV_MURL.'/'.BV_BBS_DIR);
define('BV_MCSS_PATH',		BV_MPATH.'/'.BV_CSS_DIR);
define('BV_MCSS_URL',		BV_MURL.'/'.BV_CSS_DIR);
define('BV_MIMG_PATH',		BV_MPATH.'/'.BV_IMG_DIR);
define('BV_MIMG_URL',		BV_MURL.'/'.BV_IMG_DIR);
define('BV_MJS_PATH',		BV_MPATH.'/'.BV_JS_DIR);
define('BV_MJS_URL',		BV_MURL.'/'.BV_JS_DIR);
define('BV_MSHOP_PATH',		BV_MPATH.'/'.BV_SHOP_DIR);
define('BV_MSHOP_URL',		BV_MURL.'/'.BV_SHOP_DIR);
//==============================================================================


//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('BV_SET_DEVICE', 'mobile');
define('BV_USE_MOBILE', true); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정


/********************
    시간 상수
********************/
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
define('BV_SERVER_TIME',    time());
define('BV_TIME_YEAR',		date("Y", BV_SERVER_TIME));
define('BV_TIME_MONTH',		date("m", BV_SERVER_TIME));
define('BV_TIME_DAY',		date("d", BV_SERVER_TIME));
define('BV_TIME_YM',		date("Y-m", BV_SERVER_TIME));
define('BV_TIME_YMDHIS',	date("Y-m-d H:i:s", BV_SERVER_TIME));
define('BV_TIME_YHS',		date("YmdHis", BV_SERVER_TIME));
define('BV_TIME_YMD',		substr(BV_TIME_YMDHIS, 0, 10));
define('BV_TIME_HIS',		substr(BV_TIME_YMDHIS, 11, 8));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('BV_ALPHAUPPER',		1); // 영대문자
define('BV_ALPHALOWER',		2); // 영소문자
define('BV_ALPHABETIC',		4); // 영대,소문자
define('BV_NUMERIC',		8); // 숫자
define('BV_HANGUL',		   16); // 한글
define('BV_SPACE',         32); // 공백
define('BV_SPECIAL',       64); // 특수문자

// 퍼미션
define('BV_DIR_PERMISSION',  0707); // 디렉토리 생성시 퍼미션
define('BV_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션

// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('BV_MOBILE_AGENT', 'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony');

// SMTP
// lib/mailer.lib.php 에서 사용
define('BV_SMTP',      '127.0.0.1');
define('BV_SMTP_PORT', '25');

// 아이코드 코인 최소금액 설정
// 코인 잔액이 설정 금액보다 작을 때는 주문시 SMS 발송 안함
define('BV_ICODE_COIN', 100);
/********************
    기타 상수
********************/

// 암호화 함수 지정
// 사이트 운영 중 설정을 변경하면 로그인이 안되는 등의 문제가 발생합니다.
define('BV_STRING_ENCRYPT_FUNCTION', 'sql_password');

// SQL 에러를 표시할 것인지 지정
// 에러를 표시하려면 TRUE 로 변경
define('BV_DISPLAY_SQL_ERROR', TRUE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
define('BV_ESCAPE_FUNCTION', 'sql_escape_string');

// sql_escape_string 함수에서 사용될 패턴
//define('BV_ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');
//define('BV_ESCAPE_REPLACE',  '');

// 썸네일 jpg Quality 설정
define('BV_THUMB_JPG_QUALITY', 90);

// 썸네일 png Compress 설정
define('BV_THUMB_PNG_COMPRESS', 5);

// MySQLi 사용여부를 설정합니다.
define('BV_MYSQLI_USE', true);

// 옵션 ID 특수문자 필터링 패턴
define('BV_OPTION_ID_FILTER', '/[\'\"\\\'\\\"]/');

// 스팸방지를 위한 암호화 키값
define('BV_HASH_TOKEN', md5(BV_URL.BV_TIME_YMD.$_SERVER['REMOTE_ADDR']));

// ip 숨김방법 설정
/* 123.456.789.012 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 012에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('BV_IP_DISPLAY', '\\1.♡.\\3.\\4');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('BV_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('BV_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}
?>