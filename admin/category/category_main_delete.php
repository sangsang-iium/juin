<?php
include_once "./_common.php";

if(empty($idx)){
  alert('카테고리를 선택해주세요.',BV_ADMIN_URL . "/category.php?code=main");
  exit;
}

$srcfile     = BV_DATA_PATH . '/category';
$upload_file = new upload_files($srcfile);


$sql = "SELECT * FROM iu_category_main WHERE idx = '{$idx}'";
$row = sql_fetch($sql);

if ($row['cm_img'] != null) {
  $upload_file->del($row['cm_img']);
}

$table         = "iu_category_main";
$where         = "WHERE idx = '{$idx}'";
$cateMainModel = new IUD_Model();
$cateMainModel->delete($table, $where);

goto_url(BV_ADMIN_URL . "/category.php?code=main");
?>