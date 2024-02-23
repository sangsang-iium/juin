<?php
include_once "./_common.php";

check_demo();

check_admin_token();

$srcfile     = BV_DATA_PATH . '/category';
$upload_file = new upload_files($srcfile);

if (!is_dir($srcfile)) {
  @mkdir($srcfile, BV_DIR_PERMISSION);
  @chmod($srcfile, BV_DIR_PERMISSION);
}

if ($sel_ca1) {
  $cm_ca_id = $sel_ca1;
}

if ($sel_ca2) {
  $cm_ca_id = $sel_ca2;
}

if ($sel_ca3) {
  $cm_ca_id = $sel_ca3;
}

if ($sel_ca4) {
  $cm_ca_id = $sel_ca4;
}

$sql = "SELECT * FROM shop_category WHERE catecode = '{$cm_ca_id}'";
$row = sql_fetch($sql);

unset($value);
if ($_FILES['headimg']['name']) {
  $value['cm_img'] = $upload_file->upload($_FILES['headimg']);
}
$new_next = get_next_wr_num("iu_category_main", "cm_rank");

$value['cm_ca_id']    = $cm_ca_id;
$value['cm_catename'] = $row['catename'];
$value['cm_rank']     = $new_next;

$table         = "iu_category_main";
$cateMainModel = new IUD_Model();
$cateMainModel->insert($table, $value);

goto_url(BV_ADMIN_URL . "/category.php?$q1");
?>