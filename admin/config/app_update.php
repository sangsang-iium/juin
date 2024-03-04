<?php
include_once "./_common.php";

check_demo();

check_admin_token();

unset($value);
$value['ia_aos_ver'] = $_POST['ia_aos_ver'];
$value['ia_aos_url'] = $_POST['ia_aos_url'];
$value['ia_ios_ver'] = $_POST['ia_ios_ver'];
$value['ia_ios_url'] = $_POST['ia_ios_url'];
$value['ia_puse']    = $_POST['ia_puse'];
$value['ia_pname']   = $_POST['ia_pname'];
$value['ia_pvalue']  = $_POST['ia_pvalue'];
$value['ia_iuse']    = $_POST['ia_iuse'];
$value['ia_iname']   = $_POST['ia_iname'];
$value['ia_ivalue']  = $_POST['ia_ivalue'];

$appConfModel = new IUD_Model();
$table = "iu_app";
$where = "WHERE idx = 1";

$appConfModel->update($table, $value, $where);

goto_url(BV_ADMIN_URL . '/config.php?code=app');
?>