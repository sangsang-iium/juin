<?php
include_once "./_common.php";

$seller = trim($_POST['seller']); //�Ǹ���ID
$gno = trim($_POST['gno']);

if($seller != $member['id']){
    echo '�߸��� �����Դϴ�.';
    exit;
}

$real_del = 0;
if($real_del){
    
} else {
    sql_query("update shop_used set del_yn = 'Y', del_mb_id = '$seller', deldate = '".BV_TIME_YMDHIS."' where no = '$gno'");
    echo 'Y';
}
exit;