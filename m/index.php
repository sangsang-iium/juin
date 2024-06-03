<?php
define('_MINDEX_', true);
include_once("./_common.php");

// 인트로를 사용중인지 검사
if ($_SERVER['REMOTE_ADDR'] === '106.247.231.170') {
    if(!$is_member && $config['shop_intro_yes']) {
        include_once(BV_MTHEME_PATH.'/intro.skin.php');
        return;
    }
}

include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_MPATH."/popup.inc.php"); // 팝업

include_once(BV_MTHEME_PATH.'/main.skin.php'); // 팝업레이어

include_once(BV_MPATH."/_tail.php"); // 하단
?>