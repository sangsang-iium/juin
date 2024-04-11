<?php
include_once("./_common.php");

// 상품 1개 있을 때 SESSION 지우기 _20240411_SY
if(isset($_POST['remove'], $_SESSION['myCart'][$member["id"]]['gs_id']) && count($_SESSION['myCart'][$member["id"]]['gs_id']) == 1) {
  unset($_SESSION['myCart'][$member["id"]]);
}

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