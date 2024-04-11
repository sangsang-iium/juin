<?php
include_once("./_common.php");

if(empty($_POST['gs_id'])){
  $test = $_SESSION['myCart'];
  $myCartArr = $test;
} else {
  $test = $_POST;
  $myCartArr = array($member['id'] => $test);
  set_session('myCart', $myCartArr);
}

echo json_encode($_SESSION['myCart']);
?>