<?php
include_once("./_common.php");

if(BV_IS_MOBILE) {
	goto_url(BV_MBBS_URL.'/content.php?co_id='.$co_id);
}

$co	= sql_fetch("select * from shop_content where co_id = '$co_id'");
if(!$co["co_id"]){
	alert('자료가 없습니다.', BV_URL);
}

$tb['title'] = $co['co_subject'];
include_once("./_head.php");
include_once(BV_THEME_PATH.'/content.skin.php');
include_once("./_tail.php");
?>