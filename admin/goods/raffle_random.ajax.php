<?php
include_once('./_common.php');

$sql = "  SELECT winner_number FROM shop_goods_raffle WHERE index_no = '$raffle_index' ";
$res = sql_fetch($sql);
$raffle_cnt = $res['winner_number'];

$sql = "  SELECT count(*) as cnt FROM shop_goods_raffle_log WHERE raffle_index = '$raffle_index' AND prize = 'Y' ";
$res = sql_fetch($sql);
$raffle_total_cnt = $res['cnt'];
if($raffle_total_cnt >= $raffle_cnt) {

    $returnArr = array('res' => 'N');
    die(json_encode($returnArr));

} else {

    $sql = "  SELECT index_no FROM shop_goods_raffle_log WHERE raffle_index = '$raffle_index' AND prize = 'N' ";
    $res = sql_query($sql);
    $randomArr = array();
    for($i=0; $row=sql_fetch_array($res); $i++) {
        $randomArr[] = $row['index_no'];
    }

    $randomKey = array_rand($randomArr);
    $index_no = $randomArr[$randomKey];

    $sql = "UPDATE shop_goods_raffle_log SET prize = 'Y' WHERE index_no = '$index_no' ";
    sql_query($sql);

    $sql = " SELECT count(*) as cnt FROM shop_goods_raffle_log WHERE raffle_index = '$raffle_index' AND prize = 'Y' ";
    $res = sql_fetch($sql);
    $total_cnt = $res['cnt'];

    $returnArr = array('res' => 'Y','index' => $index_no, 'prize' => 'Y', 'total_cnt' => $total_cnt);

    die(json_encode($returnArr));
}


?>