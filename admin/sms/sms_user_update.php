<?php
include_once("./_common.php");

check_demo();

$sms = get_sms('admin');
if(!$sms['cf_sms_use']) {
	alert_close('문자서비스를 사용가능한 설정 상태가 아닙니다.');
}

icode_direct_sms_send('admin', $recv_number, $sms_content);

alert("전송되었습니다.", "./sms_user.php?ph=$ph");
?>