<?php
include_once "./_common.php";

$mb_id = trim($_POST['mb_id']);
$img_name = trim($_POST['img_name']);

$row = sql_fetch("select ju_simg from shop_member where id = '$mb_id'");
$sub_imgs = explode("|", $row['ju_simg']);
$chk = false;
for($i=0;$i < count($sub_imgs);$i++){
    if($sub_imgs[$i] == $img_name){
        @unlink(BV_DATA_PATH.'/member/'.$sub_imgs[$i]);
        unset($sub_imgs[$i]);
        $chk = true;
        break;
    }
}

if($chk){
    $sub_imgs = array_filter($sub_imgs);
    $sub_imgs = array_values($sub_imgs);
    $sub_img = implode("|", $sub_imgs);
    $sql = "update shop_member set ju_simg = '$sub_img' where id = '$mb_id'";
    sql_query($sql);
    echo 'Y';
    exit;
} else {
    echo 'N';
    exit;
}