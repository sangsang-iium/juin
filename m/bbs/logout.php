<?php
define('_PURENESS_', true);
include_once("./_common.php");


// 이호경님 제안 코드
session_unset(); // 모든 세션변수를 언레지스터 시켜줌 
session_destroy(); // 세션해제함 

// 자동로그인 해제 --------------------------------
set_cookie("ck_mb_id", "", 0);
set_cookie("ck_auto", "", 0);
// 자동로그인 해제 end --------------------------------

if($url) {
    $p = parse_url($url);
    if($p['scheme'] || $p['host']) {
        alert("url에 도메인을 지정할 수 없습니다.");
    }

    $link = $url;
} else {
    $link = BV_MURL;
}

$os_type = getOS();
if($os_type != "Windows" && $os_type != "Macintosh") {
  resetFcmToken();
}

// 로그아웃 시 로그인 페이지로 이동 _20240308_SY
$link = BV_MBBS_URL . "/login.php";
goto_url($link);
?>