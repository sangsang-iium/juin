<?php
include_once "./_common.php";

if(is_numeric($no)){
    $row = sql_fetch("select * from shop_used where no = '$no'");
    if(!$row['no']){
        alert("��ǰ������ �������� �ʽ��ϴ�.");
    }
}

$sql = "insert into shop_used_comment set pno='$no', mb_id='{$member['id']}', content='$content', regdate='".BV_TIME_YMDHIS."'";
sql_query($sql);

goto_url(BV_MURL . "/used/view.php?no=".$no);
?>