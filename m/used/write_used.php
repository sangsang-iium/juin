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
        alert('�������� �ʴ� �ڷ��Դϴ�.');
    }
    
    $sub_imgs = explode("|", $row['s_img']);

    $sql = "update shop_used set gubun='$gubun', status='$status', price='$price', category='$category', title='$title', content='$content', address='$address', lat='$lat', lng='$lng' where no='$no'";
    sql_query($sql);

    // ���ø���Ʈ �ǸſϷ� PUSH _20240705_SY
    if($status == '2') {
      $wish_mem_sel = " SELECT a.mb_id, c.fcm_token AS fcm_token, b.* 
                          FROM shop_used_good a, shop_used b, shop_member c
                         WHERE a.pno   = b.no
                           AND a.mb_id = c.id
                           AND b.`no`  = '{$no}'
                           AND del_yn  = 'N'
                      ORDER BY a.no DESC ";
      $wish_mem_res = sql_query($wish_mem_sel);
      while($wish_mem_row = sql_fetch_array($wish_mem_res)) {
        $max_width    = 15;
        $text_trimmed = mb_strimwidth($wish_mem_row['title'], 0, $max_width, '...', 'utf-8');
        
        $fcm_token    = $wish_mem_row['fcm_token'];
        // $fcm_token    = "dSkWHH6bQ5eq5YWrDuTENF:APA91bF_KsOmrAV_RQv8Q4ajRJdFYFHxRu64Bb-eBoZzdzsAOK2Hlt-sotlNC0CO10GbX5Z7QkZW4adsdAL0B5lptT72syieIQGZ7V_WcfG05gLaOvyjY69OLPp3tnT7Cm8UXG9GKQdG";
        
        $message = [
          'token' => $fcm_token,
          'title' => '�߰����� ��ǰ �Ǹ�',
          'body' => "���ø���Ʈ�� ����� \"{$text_trimmed}\" �߰����� �Խñ� �ǸŰ� �Ϸ�Ǿ����ϴ�."
        ];
        
        $response = sendFCMMessage($message);
      }
    }


} else {
    alert('����� �� ���� �Ѿ���� �ʾҽ��ϴ�.');
}


$image_regex = "/(\.(jpg|gif|png))$/i";
$save_dir = BV_DATA_PATH.'/used/';
$dir = $save_dir.$no;

//��������
if(!is_dir($dir)) {
    @mkdir($dir, BV_DIR_PERMISSION);
    @chmod($dir, BV_DIR_PERMISSION);
}

// ��ǥ �̹���
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

// ���� �̹���
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

goto_url(BV_MURL . "/used/view.php?no=".$no);
?>