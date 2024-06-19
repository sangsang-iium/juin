<?php
include_once "./_common.php";
$id = $member['id'];
$sql = "select * from shop_member where id='{$id}' ";
$dat = sql_fetch($sql);

$datas = explode("||",$dat['b_addr_req']); 

$data = array(); 
for($i=0;$i<count($datas);$i++){ 
        $data[$i]['idx']=$i;
        $data[$i]['msg'] = $datas[$i]; 
}
die(json_encode($data));
