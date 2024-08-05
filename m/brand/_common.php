<?php
define('BV_USERIN_MOBILE', true);
include_once("../../common.php");
if ($member['grade'] > 8) {
  // alert("로그인 후 이용하실 수 있습니다.", BV_MBBS_URL."/login.php");
  alert("외식업중앙회 회원 전용 서비스 입니다.");
  // goto_url(BV_MBBS_URL."/login.php");
}
?>