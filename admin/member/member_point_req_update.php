<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$_POST = array_map('trim', $_POST);

$mb_id = $_POST['mb_id'];
$po_point = $_POST['po_point'];
$po_content = $_POST['po_content'];
$expire = preg_replace('/[^0-9]/', '', $_POST['po_expire_term']);

$mb = get_member($mb_id, "id, point");

if(!$mb['id'])
    alert("존재하는 회원아이디가 아닙니다.");

if(($po_point < 0) && ($po_point * (-1) > $mb['point']))
    alert("포인트를 차감하는 경우 현재 포인트보다 작으면 안됩니다.");

insert_point($mb_id, $po_point, $po_content, '@passive', $mb_id, $member['id'].'-'.uniqid(''), $expire);

alert('정상적으로 처리 되었습니다.','replace');
?>