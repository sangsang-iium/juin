<?php
include_once "./_common.php";

check_demo();

check_admin_token();

$column = 'cf_'.$code;

sql_query("update shop_config set {$column} = '$category'");

goto_url(BV_ADMIN_URL . "/category.php?code={$code}");
?>