<?php
define('_PURENESS_', true);
include_once("./_common.php");

// ��ȣ��� ���� �ڵ�
session_unset(); // ��� ���Ǻ����� �������� ������ 
session_destroy(); // ���������� 

// �ڵ��α��� ���� --------------------------------
set_cookie("ck_mb_id", "", 0);
set_cookie("ck_auto", "", 0);
// �ڵ��α��� ���� end --------------------------------

if($url) {
    $p = parse_url($url);
    if($p['scheme'] || $p['host']) {
        alert("url�� �������� ������ �� �����ϴ�.");
    }

    $link = $url;
} else {
    $link = BV_URL;
}

goto_url($link);
?>