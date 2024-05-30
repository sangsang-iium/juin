<?php
include_once("./_common.php");

$mb = get_member($member['id']);

if($mb['id']){
    $no = trim($_POST['no']);
    $inout = trim($_POST['inout']);
    
    if($inout=='in'){
        $sql = "insert into shop_used_good set pno = '$no', mb_id = '{$member['id']}', regdate = '".BV_TIME_YMDHIS."'";
        sql_query($sql);
        echo $inout;
    } else if($inout=='out'){
        $sql = "delete from shop_used_good where pno = '$no' and mb_id = '{$member['id']}'";
        sql_query($sql);
        echo $inout;
    }
}
exit;
?>