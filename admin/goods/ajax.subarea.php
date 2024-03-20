<?php
include_once '../../common.php';

$subArea = $_POST['areaname'];
$sql = "SELECT areacode2 , areaname2 FROM `area`
        WHERE areaname = '{$subArea}'
        GROUP BY areacode2";
$res = sql_query($sql);

$data = array();
while ($row = sql_fetch_array($res)) {
  $data[] = $row;
}

echo json_encode($data);