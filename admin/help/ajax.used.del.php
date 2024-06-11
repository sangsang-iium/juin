<?php
include_once "./_common.php";

$pno = trim($_POST['pno']);
$sno = trim($_POST['sno']);
// 실제 지우지 않고 상태만 변경
sql_query("update shop_used set del_yn = 'Y', del_mb_id = '{$member['id']}', deldate = '".BV_TIME_YMDHIS."' where no = '{$pno}'");
sql_query("update shop_used_singo set status = 1 where no = '{$sno}'");
echo 'Y';
exit;