<?php
include_once('./_common.php');

$chatno = trim($_POST['chatno']);
$seller = trim($_POST['seller']); //판매자ID

if($seller != $member['id']){
    echo '잘못된 접근입니다.';
    exit;
}

$sql = "update shop_used_chat set block = 1, blockdate = '".BV_TIME_YMDDHIS."' where no = {$chatno}";
sql_query($sql);
echo 'Y';
exit;
?>