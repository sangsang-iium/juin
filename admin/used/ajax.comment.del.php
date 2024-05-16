<?php
include_once "./_common.php";

$no = trim($_POST['no']);

$sql = "delete from shop_used_comment where no = '$no'";
sql_query($sql);
echo 'Y';
exit;