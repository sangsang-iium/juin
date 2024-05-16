<?php
include_once "./_common.php";

$no = trim($_POST['no']);
$img_name = trim($_POST['img_name']);

$row = sql_fetch("select s_img from shop_used where no = '$no'");
$sub_imgs = explode("|", $row['s_img']);
$chk = false;
for($i=0;$i < count($sub_imgs);$i++){
    if($sub_imgs[$i] == $img_name){
        @unlink(BV_DATA_PATH.'/used/'.$sub_imgs[$i]);
        unset($sub_imgs[$i]);
        $chk = true;
        break;
    }
}

if($chk){
    $sub_imgs = array_filter($sub_imgs);
    $sub_imgs = array_values($sub_imgs);
    $sub_img = implode("|", $sub_imgs);
    $sql = "update shop_used set s_img = '$sub_img' where no = '$no'";
    sql_query($sql);
    echo 'Y';
    exit;
} else {
    echo 'N';
    exit;
}