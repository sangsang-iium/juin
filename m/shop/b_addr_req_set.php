<?php
include_once "./_common.php";

$b_addr_req = $_POST['b_addr_req'];
$mb_id =  $member['id']; 
$b_addr_req_add = $member['b_addr_req'].$b_addr_req."||";
$cd = $_POST['cd'];
if($cd=='set')
{
    $sql = "update shop_member 
        set
        b_addr_req_base = '{$b_addr_req}'
        where id='{$mb_id}' ";
        //echo $sql;
    sql_query($sql);
}
if($cd=='del'){
    $id = $member['id'];
    $sql = "select * from shop_member where id='{$id}' ";
    $dat = sql_fetch($sql); 
    $datas = explode("||",$dat['b_addr_req']);  
    $data = "";
    $idx = $_POST['idx'];
    echo "<br/>";
    echo $idx;
    echo "<br/>";
    for($i=0;$i<count($datas);$i++){
            if($idx==$i)
            { 
            }else{
                $data .= $datas[$i]."||";
            }  
    }
    $sql = "update shop_member 
            set
                b_addr_req = '{$data}'
                where id='{$mb_id}' ";
                echo $sql;
            sql_query($sql);
}
