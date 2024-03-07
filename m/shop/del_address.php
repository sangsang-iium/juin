<?php
include_once("./_common.php");
//echo test;
if(!$is_member) {
	alert_close("회원 전용 서비스입니다.");
}

// $tb['title'] = '배송지 찾기';
// include_once(BV_MPATH."/head.sub.php");
 $sql = "delete from b_address where wr_id='$wr_id' ";
 sql_query($sql);
// include_once(BV_MPATH."/tail.sub.php");
?>