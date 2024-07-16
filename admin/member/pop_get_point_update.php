<?php
include_once "./_common.php";

$gradeModel = new IUD_Model();
$db_input["gb_category"] = $selectedTags;
$table = "shop_member_grade";
$where = "WHERE gb_no = '{$gb_no}'";

$gradeModel->update($table, $db_input, $where);

goto_url("/admin/member/pop_get_point.php?gb_no={$gb_no}");