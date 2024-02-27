<?php
include_once("./_common.php");

check_demo();

if($is_member){
    $cp_id = trim($_POST['cp_id']);
    $cp = sql_fetch("select * from shop_coupon where cp_id='$cp_id'");

    insert_used_coupon($member['id'], $member['name'], $cp);

    echo "ok";
}else{
    echo "nomember";
}


?>