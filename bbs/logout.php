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
    $link = BV_URL;
}


// 로그아웃 링크 _20240711_SY

if($member['id'] != 'admin' && is_admin()) {
  $link = BV_MBBS_URL . "/login_mng.php";
}

if(is_seller($member['id'])) {
  $link = BV_MBBS_URL . "/login_seller.php";
}


// 관리자 로그아웃 시 매니저 로그인으로 수정 _20240619_SY
// $link = BV_MBBS_URL . "/login_mng.php?url=$url";
goto_url($link);
?>