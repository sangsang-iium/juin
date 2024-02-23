<?php
include_once("./_common.php");

$sql = "SELECT * FROM iu_category_main WHERE cm_ca_id = '{$catecode}'";
$row = sql_fetch($sql);

echo json_encode($row);