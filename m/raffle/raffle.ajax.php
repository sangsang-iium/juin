<?php
include_once('./_common.php');

if($member['id']) {
  $rafflePrizeCheck = rafflePrizeCheck($index_no);
  if($rafflePrizeCheck) {
    $sql = " INSERT INTO shop_goods_raffle_log SET
            raffle_index = '$index_no',
            mb_id = '{$member['id']}',
            mb_name = '{$member['name']}',
            reg_time = '".BV_TIME_YMDHIS."',
            prize = 'N' ";
            sql_query($sql);
    $returnArr = array('res' => 'Y');
  } else {
    $returnArr = array('res' => 'N');
  }
}
die(json_encode($returnArr));
?>