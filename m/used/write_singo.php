<?php
include_once "./_common.php";

$pno = trim($_POST['pno']);
$mb_id = trim($_POST['mb_id']);
$category = trim($_POST['category']);
$content = trim($_POST['content']);

$row = sql_fetch("select * from shop_used where no = '$pno'");
if(!$row['no']){
    alert("상품정보가 존재하지 않습니다.");
}

if($row['mb_id'] == $mb_id){
    alert("자신의 글을 신고하실 수 없습니다.");
}

if($mb_id != $member['id']){
    alert("잘못된 접근입니다.");
}

$sql = "insert into shop_used_singo set pno='$pno', mb_id='$mb_id', category='$category', content='$content', regdate='".BV_TIME_YMDHIS."'";
sql_query($sql);
$no = sql_insert_id();

$image_regex = "/(\.(jpg|jpeg|gif|png))$/i"; //대소문자구분안함
$save_dir = BV_DATA_PATH.'/singo/';
$dir = $save_dir.$no;

//폴더생성
if(!is_dir($dir)) {
    @mkdir($dir, BV_DIR_PERMISSION);
    @chmod($dir, BV_DIR_PERMISSION);
}

// 증거 이미지
if(is_uploaded_file($_FILES['img']['tmp_name'])){
	if(preg_match($image_regex, $_FILES['img']['name'])){
	    $exts = explode(".", $_FILES['img']['name']);
		$save_name = $no.'/'.$mb_id.'_'.date('YmdHis').'.'.strtolower($exts[count($exts)-1]);
		$dest_path = $save_dir.$save_name;
		move_uploaded_file($_FILES['img']['tmp_name'], $dest_path);
		chmod($dest_path, BV_FILE_PERMISSION);
		
		sql_query(" update shop_used_singo set img='$save_name' where no = '$no' ");
	}
}

alert("신고가 접수되었습니다.", BV_MURL."/used/view.php?no=".$pno."&r=1");
?>