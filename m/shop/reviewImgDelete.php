<?php
include_once "./_common.php";

$sql = " SELECT thumbnail FROM shop_goods_review_img WHERE index_no = '{$index_no}' ";
$res  = sql_fetch($sql);

$upl_dir = BV_DATA_PATH."/review";
$reviewImgUrl = $upl_dir."/".$res['thumbnail'];
unlink($reviewImgUrl);

$deleteSql = " DELETE FROM shop_goods_review_img WHERE index_no = '{$index_no}' ";
sql_query($deleteSql);

?>