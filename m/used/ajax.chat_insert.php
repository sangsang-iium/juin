<?php
include_once('./_common.php');
//include_once G5_LIB_PATH.'/thumbnail.lib.php';

$chatno = trim($_POST['chatno']);
$content = trim($_POST['content']);

sql_query("insert into shop_used_chatd set pno={$chatno}, mb_id='{$member['id']}', content='$content', regdate='".BV_TIME_YMDHIS."'");
sql_query("update shop_used_chat set lasttime='".BV_SERVER_TIME."' where no={$chatno}");
exit;
?>