<?php
include_once('./_common.php');

if(isset($_SESSION['ss_mb_reg']))
    $mb = get_member($_SESSION['ss_mb_reg']);

// 회원정보가 없다면 초기 페이지로 이동
if(!$mb['id'])
    goto_url(BV_MURL);

$tb['title'] = '회원가입 완료';
include_once('./_head.php');
include_once(BV_MTHEME_PATH.'/register_result.skin.php');
include_once('./_tail.php');
?>