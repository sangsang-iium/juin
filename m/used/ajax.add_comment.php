<?php
include_once "./_common.php";

$edit_no = trim($_POST['edit_no']); //ผ๖มค
$pno = trim($_POST['pno']);
$comment = trim($_POST['comment']);
$mb_id = trim($_POST['mb_id']);

if(is_numeric($pno)){
    $row = sql_fetch("select * from shop_used where no = '$pno'");
    if(!$row['no']) exit;
} else {
    exit;
}

if($mb_id != $member['id']) exit;

if($edit_no){
    $sql = "update shop_used_comment set comment='$comment' where no='$edit_no'";
} else {
    $sql = "insert into shop_used_comment set pno='$pno', mb_id='$mb_id', comment='$comment', regdate='".BV_TIME_YMDHIS."'";
}
sql_query($sql);
echo 'Y';
exit;
?>