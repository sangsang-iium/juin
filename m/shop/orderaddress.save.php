<?php
include_once("./_common.php");
//echo test;
if(!$is_member) {
	alert_close("회원 전용 서비스입니다.");
}
$mb_id = $member['id'];

if($b_wr_id){
	//update
	$sql = "
	 update b_address
		 set
		 mb_id = '$mb_id'
		,b_cellphone = '$b_cellphone'
		,b_telephone = '$b_telephone'
		,b_zip = '$b_zip'
		,b_addr1 = '$b_addr1'
		,b_addr2 = '$b_addr2'
		,b_addr3 = '$b_addr3'
		,b_addr_jibun = '$b_addr_jibun'
		,b_name = '$b_name'
		,b_base = '$b_base'
		,b_addr_jibeon = '$b_addr_jibeon'

		where wr_id = '$b_wr_id'
	";
	sql_query($sql);
	echo "updateok";
}else{
	//	입력
	$sql= "insert into b_address
		set
		mb_id='$mb_id'
		,b_name = '$b_name'
		,b_cellphone = '$b_cellphone'
		,b_zip = '$b_zip'
		,b_addr1 = '$b_addr1'
		,b_addr2 = '$b_addr2'
		,b_base = '$b_base'
	";
	sql_query($sql);
	$wr_id = sql_insert_id();
	if($wr_id){
		if($b_base=='1'){
			sql_query("update b_address set b_base=0 where mb_id='$mb_id' ");

			sql_query("update b_address set b_base=1 where wr_id='$wr_id' ");

		}
		echo "insertok";
	}else{
		echo "fail";
	}
}



?>