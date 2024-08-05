<?php
include_once "./_common.php";

$idx = $_POST['numberIdx'];

$sql = "SELECT * FROM iu_card_reg WHERE idx = '{$idx}'";
$row = sql_fetch($sql);

if($row['idx']){
  $CardUpdateAllChange = new IUD_Model();
  $db_Allupdate["cr_use"] = "N";
  $up_Allwhere            = "WHERE mb_id = '{$member['id']}'";
  $CardUpdateAllChange->update("iu_card_reg", $db_Allupdate, $up_Allwhere);

  $CardUpdate = new IUD_Model();
  $db_update["cr_use"] = "Y";
  $up_where = "WHERE idx = '{$idx}'";
  $CardUpdate->update("iu_card_reg", $db_update, $up_where);
  echo true;
} else {
  echo false;
}
