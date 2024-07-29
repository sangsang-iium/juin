<?php
define('BV_USERIN_MOBILE', true);
include_once("../../common.php");

//중앙회/공제회/관리자 접근가능// 회원 등급에 따른 카테고리 노출 처리
if( $member['grade'] > 8 ){
    alert("외식업중앙회 회원 전용 서비스 입니다.", "/m/shop/introjuin.php");
    // goto_url(BV_MBBS_URL."/login.php");
}
?>