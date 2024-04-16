<?php
include_once "./_common.php";

$depth2 = $_POST['depth2'];

$depth2 = juinGroupInfo(2, $depth2);
$data = array();
for ($d = 0; $d < count($depth2); $d++) {
  $data[] = $depth2[$d];
}

echo json_encode($data);