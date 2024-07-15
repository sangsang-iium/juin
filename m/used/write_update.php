<?php
include_once "./_common.php";

if ($w == '') {
    $sub_imgs = [];
    
    $sql = "insert into shop_used set mb_id='{$member['id']}', gubun='$gubun', status='$status', price='$price', category='$category', title='$title', content='$content', address='$address', lat='$lat', lng='$lng', regdate='".BV_TIME_YMDHIS."'";
    sql_query($sql);
    $no = sql_insert_id();

} elseif ($w == 'u') {
    $row = sql_fetch("select * from shop_used where no='$no'");
    if (!$row['no']) {
        alert('존재하지 않는 자료입니다.');
    }
    
    $sub_imgs = explode("|", $row['s_img']);

    $sql = "update shop_used set gubun='$gubun', status='$status', price='$price', category='$category', title='$title', content='$content', address='$address', lat='$lat', lng='$lng' where no='$no'";
    sql_query($sql);

} else {
    alert('제대로 된 값이 넘어오지 않았습니다.');
}


$image_regex = "/(\.(jpg|gif|png))$/i";
$save_dir = BV_DATA_PATH.'/used/';
$dir = $save_dir.$no;

//폴더생성
if(!is_dir($dir)) {
    @mkdir($dir, BV_DIR_PERMISSION);
    @chmod($dir, BV_DIR_PERMISSION);
}

// 대표 이미지
if(is_uploaded_file($_FILES['m_img']['tmp_name'])){
	if(preg_match($image_regex, $_FILES['m_img']['name'])){
	    $exts = explode(".", $_FILES['m_img']['name']);
		$save_name = $no.'/main_image.'.strtolower($exts[count($exts)-1]);
		$dest_path = $save_dir.$save_name;
		move_uploaded_file($_FILES['m_img']['tmp_name'], $dest_path);
		chmod($dest_path, BV_FILE_PERMISSION);
		
		sql_query(" update shop_used set m_img = '$save_name' where no = '$no' ");
	}
}

// 서브 이미지
$idx = time();
for($i=0;$i < count($_FILES['s_img']['tmp_name']);$i++){
    if(is_uploaded_file($_FILES['s_img']['tmp_name'][$i])){
    	if(preg_match($image_regex, $_FILES['s_img']['name'][$i])){
    	    $exts = explode(".", $_FILES['s_img']['name'][$i]);
    		$save_name = $no.'/sub_image_'.$idx.'.'.strtolower($exts[count($exts)-1]);
    		$dest_path = $save_dir.$save_name;
    		move_uploaded_file($_FILES['s_img']['tmp_name'][$i], $dest_path);
    		chmod($dest_path, BV_FILE_PERMISSION);
    		array_push($sub_imgs, $save_name);
    		$idx++;
    	}
    }
}
$sub_imgs = array_filter($sub_imgs);
$sub_imgs = array_values($sub_imgs);
$save_img = implode("|", $sub_imgs);
sql_query(" update shop_used set s_img = '$save_img' where no = '$no' ");

if($my_list){
    goto_url(BV_MURL . "/used/my_list.php");
} else {
    goto_url(BV_MURL . "/used/view.php?no=".$no);
}
?>