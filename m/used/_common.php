<?php
define('BV_USERIN_MOBILE', true);
include_once("../../common.php");

//중앙회/공제회/관리자 접근가능
if( !in_array($member['grade'], [1,7,8]) ){
    alert("로그인 후 이용하실 수 있습니다.", BV_MBBS_URL."/login.php?url=".$urlencode);
}
?>