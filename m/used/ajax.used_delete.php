<?php
include_once "./_common.php";

$seller = trim($_POST['seller']); //판매자ID
$gno = trim($_POST['gno']);

if($seller != $member['id']){
    echo '잘못된 접근입니다.';
    exit;
}

$real_del = 0;
if($real_del){
    
} else {
    sql_query("update shop_used set del_yn = 'Y', del_mb_id = '$seller', deldate = '".BV_TIME_YMDHIS."' where no = '$gno'");
    echo 'Y';
}
exit;