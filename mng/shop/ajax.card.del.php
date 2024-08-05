<?php
include_once "./_common.php";

$idx = $_POST['idx'];

$sql = "SELECT * FROM iu_card_reg WHERE idx = '{$idx}'";
$row = sql_fetch($sql);

if($row['idx']){
  $CardDel = new IUD_Model();
  $del_where = "WHERE idx = '{$idx}'";
  $CardDel->delete("iu_card_reg", $del_where);
  echo true;
} else {
  echo false;
}
