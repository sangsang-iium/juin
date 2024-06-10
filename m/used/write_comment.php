<?php
include_once "./_common.php";

$pno = trim($_POST['pno']);
$mb_id = trim($_POST['mb_id']);
$comment = trim($_POST['comment']);

$row = sql_fetch("select * from shop_used where no = '$pno'");
if(!$row['no']){
    alert("상품정보가 존재하지 않습니다.");
}

if($mb_id != $member['id']){
    alert("잘못된 접근입니다.");
}

$sql = "insert into shop_used_comment set pno='$pno', mb_id='$mb_id', comment='$comment', regdate='".BV_TIME_YMDHIS."'";
sql_query($sql);

goto_url(BV_MURL . "/used/view.php?no=".$pno."&c=1&m=1");
?>