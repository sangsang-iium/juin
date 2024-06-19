<?php
include_once "./_common.php";

$b_addr_req = $_POST['b_addr_req'];
$mb_id =  $member['id']; 
$b_addr_req_add = $member['b_addr_req'].$b_addr_req."||";

$sql = "update shop_member 
        set
        b_addr_req = '{$b_addr_req_add}'
        where id='{$mb_id}' ";
        //echo $sql;
sql_query($sql);
die();
