<?php
include_once("./_common.php");

if($code==9){ //환불완료처리
    $chk = explode(",",$_REQUEST['od_id']); 
    for($i=0;$i<count($chk);$i++){
        $od_id = $chk[$i];
        $sql = "update shop_order set dan2='11' where od_id='$od_id' ";
        sql_query($sql);
    }
}

if($code==7){ //반품완료처리
    $chk = explode(",",$_REQUEST['od_id']); 
    for($i=0;$i<count($chk);$i++){
        $od_id = $chk[$i];
        $sql = "update shop_order set dan2='10' where od_id='$od_id' ";
        sql_query($sql);
    }
}

 
if($code==8){ //배송후 교환처리
    $chk = explode(",",$_REQUEST['od_id']); 
    for($i=0;$i<count($chk);$i++){
        $od_id = $chk[$i];
        $sql = "update shop_order set dan2='12' where od_id='$od_id' ";
        sql_query($sql);
    }
}

 
goto_url(BV_ADMIN_URL."/order.php?code=".$code);
?>