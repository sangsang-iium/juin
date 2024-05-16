<?php
include_once "./_common.php";

$nos = trim($_POST['nos']);
$nos = explode("|", $nos);

for ($i = 0; $i < count($nos); $i++) {
    // 실제 지우지 않고 상태만 변경
    sql_query("update shop_used set del_yn = 'Y', del_mb_id = '{$member['id']}', deldate = '".BV_TIME_YMDHIS."' where no = '{$nos[$i]}'");
}
echo 'Y';
exit;