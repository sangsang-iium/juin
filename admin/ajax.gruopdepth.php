<?php
include_once "./_common.php";

// $depth2 = $_POST['depth2'];
$depthNum   = $_POST['depthNum'];
$depthValue = $_POST['depthValue'];

$depth = juinGroupInfo($depthNum, $depthValue);

$data = array();
for ($d = 0; $d < count($depth); $d++) {
  $data[] = $depth[$d];
}

echo json_encode($data);