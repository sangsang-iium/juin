<?php //지회 ID 중복체크 _20240514_SY
include_once "./_common.php";

$id = preg_replace("/\s+/", "", $_POST['id']);

$duChk_sel = "  ";