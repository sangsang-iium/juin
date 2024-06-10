<?php
include_once "./_common.php";

$cno = trim($_POST['cno']);
$mb_id = trim($_POST['mb_id']);

if($mb_id != $member['id']) exit;

$sql = "delete from shop_used_comment where no='$cno'";
sql_query($sql);
echo 'Y';
exit;
?>