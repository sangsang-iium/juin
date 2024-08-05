<?php
include_once("./_common.php");

check_demo();

$_POST = array_map('trim', $_POST);

if($_POST["token"] && get_session("ss_token") == $_POST["token"]) {
	// 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
	set_session("ss_token", "");
} else {
	alert("잘못된 접근 입니다.");
	exit;
}

if(substr_count($_POST['memo'], "&#") > 50) {
    alert("내용에 올바르지 않은 코드가 다수 포함되어 있습니다.");
}

if(!$_POST['subject'])
	alert("제목을 입력하세요.");

if(!$_POST['writer_s'])
	alert("작성자명이 없습니다.");

$writer = 0;

if($_POST['havehtml']!='Y')	$_POST['havehtml'] = "N";
if($_POST['btype']!='1') $_POST['btype'] = '2';
if($_POST['issecret']!='Y') $_POST['issecret'] = "N";
if($member['id']) $writer = $member['index_no'];

if($is_member)
	$writer = $mb_no;

if($w == "") {
	$fid = get_next_num("shop_board_{$boardid}");
	$sql_common = " btype		= '$_POST[btype]',
					ca_name		= '$_POST[ca_name]',
					issecret	= '$_POST[issecret]',
					havehtml	= '$_POST[havehtml]',
					writer      = '$writer',
					writer_s	= '$_POST[writer_s]',
					subject		= '$_POST[subject]',
					memo		= '$_POST[memo]',
					passwd      = '$_POST[passwd]',
					average		= '$_POST[average]',
					product		= '$_POST[product]',
					pt_id		= '$pt_id' ";

	$sql = " insert into shop_board_{$boardid}
				set fid = '$fid',
					wdate = '".BV_SERVER_TIME."',
					wip = '{$_SERVER['REMOTE_ADDR']}',
					thread = 'A',
					$sql_common ";
	sql_query($sql);

  /* ------------------------------------------------------------------------------------- _20240713_SY 
    * 첨부파일 추가
  /* ------------------------------------------------------------------------------------- */
  $idx = sql_insert_id();
  $uploadDir = "../../data/board/{$boardid}/"; // 업로드 디렉토리 경로
  	
	$fileName = $_FILES["imgUpload1"]["name"];
	$fileTmpName = $_FILES["imgUpload1"]["tmp_name"];
	$fileSize = $_FILES["imgUpload1"]["size"];
	$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	if (in_array($fileExtension, $allowedExtensions)) {
    // 새로운 파일 이름을 생성합니다.
    $newFileName = uniqid() . "." . $fileExtension;
    $uploadPath = $uploadDir . $newFileName;

    // 임시 파일의 경로를 UTF-8로 변환합니다.
    $utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');

    // 파일을 이동시킵니다.
    if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
    echo "파일 업로드 성공: " . $newFileName;
    $newFileName1 = $newFileName;		
    } else {
    echo "파일 업로드 실패.";
    }
	}  

  $imgUp['fileurl1'] = $newFileName1;
  $imgWhere = " WHERE index_no = {$idx} ";
  $IMG_UPDATE = new IUD_Model;
  $IMG_UPDATE->update("shop_board_{$boardid}", $imgUp, $imgWhere);



	goto_url(BV_MBBS_URL."/board_list.php?boardid=$boardid");

} else if($w == "u") {
	$sql = "select * from shop_board_{$boardid} where index_no='$index_no'";
	$row = sql_fetch($sql);

	$m = 2;
	if(is_admin())
	{	$m = 1;	}
	else
	{
		if($row['writer']==0) {
			if($_POST['passwd'] != $row['passwd']) {
				alert('비밀번호가 맞지않습니다.');
			}
			$m = 1;
		} else {
			if($row['writer']==$mb_no)
			{	$m = 1;	}
		}
	}

	if($m==1) {
		$sql = " update shop_board_{$boardid}
					set writer_s	= '$_POST[writer_s]',
						btype		= '$_POST[btype]',
						ca_name		= '$_POST[ca_name]',
						issecret	= '$_POST[issecret]',
						havehtml	= '$_POST[havehtml]',
						subject		= '$_POST[subject]',
						memo		= '$_POST[memo]',
						average		= '$_POST[average]',
						product		= '$_POST[product]'
				  where index_no	= '$index_no'";
		$r = sql_query($sql);

      
    /* ------------------------------------------------------------------------------------- _20240731_SY 
      * 첨부파일 추가
    /* ------------------------------------------------------------------------------------- */
    
    $uploadDir = "../../data/board/{$boardid}/"; // 업로드 디렉토리 경로
      
    $fileName = $_FILES["imgUpload1"]["name"];
    $fileTmpName = $_FILES["imgUpload1"]["tmp_name"];
    $fileSize = $_FILES["imgUpload1"]["size"];
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
      // 새로운 파일 이름을 생성합니다.
      $newFileName = uniqid() . "." . $fileExtension;
      $uploadPath = $uploadDir . $newFileName;

      // 임시 파일의 경로를 UTF-8로 변환합니다.
      $utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');

      // 파일을 이동시킵니다.
      if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
      echo "파일 업로드 성공: " . $newFileName;
      $newFileName1 = $newFileName;		
      } else {
      echo "파일 업로드 실패.";
      }
    }  

    $imgUp['fileurl1'] = $newFileName1;
    $imgWhere = " WHERE index_no = {$index_no} ";
    $IMG_UPDATE = new IUD_Model;
    $IMG_UPDATE->update("shop_board_{$boardid}", $imgUp, $imgWhere);

		// goto_url(BV_MBBS_URL."/board_write.php?w=u&index_no=$index_no&boardid=$boardid&page=$page");
		goto_url(BV_MBBS_URL."/board_read.php?index_no=$index_no&boardid=$boardid&page=$page");
	}

} else if($w == "r") {
	$sql = "select fid,thread,passwd from shop_board_{$boardid} where index_no=$index_no";
	$res = sql_query($sql);
	$row = sql_fetch_row($res);
	$fid = $row[0];
	$thread = $row[1];
	$passwd = $row[2];

	$sql = "select thread,right(thread,1)
			  from shop_board_{$boardid}
			 where fid = '$fid'
			   and length(thread) = length('$thread')+1
			   and locate('$thread',thread) = 1
			 order by thread desc limit 1 ";
	$r = sql_query($sql);
	if(!$r)
		alert('리플글 작성에 실패 하였습니다.');

	$rows = sql_num_rows($r);
	if($rows) {
		$row = sql_fetch_row($r);
		$thread_head = substr($row[0],0,-1);
		$thread_foot = ++$row[1];
		$new_thread = $thread_head . $thread_foot;
	} else {
		$new_thread = $thread . "A";
	}

	$sql_common = " btype		= '$_POST[btype]',
					ca_name		= '$_POST[ca_name]',
					issecret	= '$_POST[issecret]',
					havehtml	= '$_POST[havehtml]',
					writer      = '$writer',
					writer_s	= '$_POST[writer_s]',
					subject		= '$_POST[subject]',
					memo		= '$_POST[memo]',
					passwd      = '$passwd',
					average		= '$_POST[average]',
					product		= '$_POST[product]',
					pt_id		= '$pt_id' ";

	$sql = " insert into shop_board_{$boardid}
				set fid = '$fid',
					wdate = '".BV_SERVER_TIME."',
					wip = '{$_SERVER['REMOTE_ADDR']}',
					thread = '$new_thread',
					$sql_common ";
	sql_query($sql);

	goto_url(BV_MBBS_URL."/board_list.php?boardid=$boardid");

} else {
	alert("정상적인 접근이 아닌것 같습니다.");
}
?>