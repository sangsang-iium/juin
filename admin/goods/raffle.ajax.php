<?php
include_once('./_common.php');

if($check == 'Y') {
    $sql = "UPDATE shop_goods_raffle_log SET prize = 'N' WHERE index_no = '$index_no' ";

} else {
    $sql = "UPDATE shop_goods_raffle_log SET prize = 'Y' WHERE index_no = '$index_no' ";

}

// echo '<xmp>'; print_r($sql); echo '</xmp>';


$retrunArr = array('res' => $index_no);


die(json_encode($retrunArr));

?>