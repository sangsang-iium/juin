<?php
include_once("./_common.php");
    //echo $odId;
    //echo $evt;
    //환불
    $od_id=$odId;
    if($evt=='return-money'){
        $csql = "update shop_order
                 set
                 dan = '9'
                 where od_id='$od_id'
        ";
    }
    //교환
    if($evt=='change-product'){
        $csql = "update shop_order
        set
        dan = '8'
        where od_id='$od_id'
        ";
    }
    //반품
    if($evt=='return-product'){
        $csql = "update shop_order
        set
        dan = '7'
        where od_id='$od_id'
        ";
    }
    sql_query($csql);
    //echo $csql;
    $url = "/m/shop/orderinquiry.php";
    die(json_encode(array('url'=>$url)));
?>