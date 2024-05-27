<?php
exit;
//*회원정보에 엑셀로 업로드된 주소정보로 좌표 생성 *//
include_once "./_common.php";

$mb_id = trim($_POST['mb_id']);
$lat = trim($_POST['lat']);
$lng = trim($_POST['lng']);

sql_query("update shop_member set ju_lat='$lat', ju_lng='$lng' where id = '$mb_id'");