<?php
include_once("./_common.php");

check_demo();

check_admin_token();

// input vars 체크
check_input_vars();

$upl_dir = BV_DATA_PATH."/raffle";
$upl = new upload_files($upl_dir);

if($_POST['goods_name'] == "") {
	alert("레플명을 입력하세요.");
}

unset($value);
if($_POST['simg_type']) { // URL 입력
	$value['simg1'] = $_POST['simg1'];
	$value['simg2'] = $_POST['simg2'];
	$value['simg3'] = $_POST['simg3'];
	$value['simg4'] = $_POST['simg4'];
	$value['simg5'] = $_POST['simg5'];
	$value['simg6'] = $_POST['simg6'];
} else {
	for($i=1; $i<=6; $i++) {
		if($img = $_FILES['simg'.$i]['name']) {
			if(!preg_match("/\.(gif|jpg|png)$/i", $img)) {
				alert("이미지가 gif, jpg, png 파일이 아닙니다.");
			}
		}
		if($_POST['simg'.$i.'_del']) {
			$upl->del($_POST['simg'.$i.'_del']);
			$value['simg'.$i] = '';
		}
		if($_FILES['simg'.$i]['name']) {
			$value['simg'.$i] = $upl->upload($_FILES['simg'.$i]);
		}
	}
}


$value['goods_name']        =   $_POST['goods_name'];
$value['event_start_date']  =   $_POST['event_start_date'];
$value['event_end_date']    =   $_POST['event_end_date'];
$value['prize_date']        =   $_POST['prize_date'];
$value['prize_start_date']  =   $_POST['prize_start_date'];
$value['prize_end_date']    =   $_POST['prize_end_date'];
$value['market_price']      =   $_POST['market_price'];
$value['raffle_price']      =   $_POST['raffle_price'];
$value['winner_number']     =   $_POST['winner_number'];
$value['entry']             =   $_POST['entry'];
$value['infomation']        =   $_POST['infomation'];
$value['memo']              =   $_POST['memo'];
$value['admin_memo']        =   $_POST['admin_memo'];


if($w == "") {
	$value['reg_time'] = BV_TIME_YMDHIS; //등록일시
	insert("shop_goods_raffle", $value);
	$gs_id = sql_insert_id();

} else if($w == "u") {
	update("shop_goods_raffle", $value," where index_no = '$gs_id'");
}


if($w == "")
    goto_url(BV_ADMIN_URL."/goods.php?code=raffle&w=u&gs_id=$gs_id");
else if($w == "u")
    goto_url(BV_ADMIN_URL."/goods.php?code=raffle&w=u&gs_id=$gs_id$q1&page=$page&bak=$bak");
?>