<?php
define('BV_USERIN_MOBILE', true);
include_once("../../common.php");

//중앙회/공제회/관리자 접근가능 추가 _20240626_SY
if( $member['grade'] > 8 ){
  // alert("로그인 후 이용하실 수 있습니다.", BV_MBBS_URL."/login.php");
  goto_url(BV_MBBS_URL."/login.php");
}
?>