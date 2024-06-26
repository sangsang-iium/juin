<?php
include_once("./_common.php");
include_once(BV_LIB_PATH."/mailer.lib.php");

if(!$is_member) {
	goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);
}

if($_POST['mode'] == 'w') {
	check_demo();

	if($_POST["token"] && get_session("ss_token") == $_POST["token"]) {
		// 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
		set_session("ss_token", "");
	} else {
		alert("잘못된 접근 입니다.");
		exit;
	}

	$subject = trim(strip_tags($_POST['subject']));

	if(substr_count($_POST['memo'], "&#") > 50) {
		alert("내용에 올바르지 않은 코드가 다수 포함되어 있습니다.");
	}

	if(!get_magic_quotes_gpc()) {
		$_POST['memo'] = addslashes($_POST['memo']);
	}


	// 업로드 디렉토리를 설정합니다.
$uploadDir = "../../data/qa/"; // 업로드 디렉토리 경로
$maxFileSize = 10 * 1024 * 1024; // 5MB

	// 업로드된 파일의 정보를 가져옵니다.
	$fileName = $_FILES["imgUpload1"]["name"];
	$fileTmpName = $_FILES["imgUpload1"]["tmp_name"];
	$fileSize = $_FILES["imgUpload1"]["size"];

	// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
	$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	if (in_array($fileExtension, $allowedExtensions)) {
		// 파일 크기를 체크하고 원하는 크기로 제한합니다.
		if ($fileSize <= $maxFileSize) {
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
		} else {
			echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
		}
	}  


		// 업로드된 파일의 정보를 가져옵니다.
		$fileName = $_FILES["imgUpload2"]["name"];
		$fileTmpName = $_FILES["imgUpload2"]["tmp_name"];
		$fileSize = $_FILES["imgUpload2"]["size"];
	
		// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
		$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
		$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	
		if (in_array($fileExtension, $allowedExtensions)) {
			// 파일 크기를 체크하고 원하는 크기로 제한합니다.
			if ($fileSize <= $maxFileSize) {
				// 새로운 파일 이름을 생성합니다.
				$newFileName = uniqid() . "." . $fileExtension;
				$uploadPath = $uploadDir . $newFileName;
	
				// 임시 파일의 경로를 UTF-8로 변환합니다.
				$utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');
	
				// 파일을 이동시킵니다.
				if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
				echo "파일 업로드 성공: " . $newFileName;
				$newFileName2 = $newFileName;		
				} else {
				echo "파일 업로드 실패.";
				}
			} else {
				echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
			}
		}
		
		// 업로드된 파일의 정보를 가져옵니다.
		$fileName = $_FILES["imgUpload3"]["name"];
		$fileTmpName = $_FILES["imgUpload3"]["tmp_name"];
		$fileSize = $_FILES["imgUpload3"]["size"];
	
		// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
		$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
		$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	
		if (in_array($fileExtension, $allowedExtensions)) {
			// 파일 크기를 체크하고 원하는 크기로 제한합니다.
			if ($fileSize <= $maxFileSize) {
				// 새로운 파일 이름을 생성합니다.
				$newFileName = uniqid() . "." . $fileExtension;
				$uploadPath = $uploadDir . $newFileName;
	
				// 임시 파일의 경로를 UTF-8로 변환합니다.
				$utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');
	
				// 파일을 이동시킵니다.
				if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
				echo "파일 업로드 성공: " . $newFileName;
				$newFileName3 = $newFileName;		
				} else {
				echo "파일 업로드 실패.";
				}
			} else {
				echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
			}
		}

		// 업로드된 파일의 정보를 가져옵니다.
		$fileName = $_FILES["imgUpload4"]["name"];
		$fileTmpName = $_FILES["imgUpload4"]["tmp_name"];
		$fileSize = $_FILES["imgUpload4"]["size"];
	
		// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
		$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
		$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	
		if (in_array($fileExtension, $allowedExtensions)) {
			// 파일 크기를 체크하고 원하는 크기로 제한합니다.
			if ($fileSize <= $maxFileSize) {
				// 새로운 파일 이름을 생성합니다.
				$newFileName = uniqid() . "." . $fileExtension;
				$uploadPath = $uploadDir . $newFileName;
	
				// 임시 파일의 경로를 UTF-8로 변환합니다.
				$utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');
	
				// 파일을 이동시킵니다.
				if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
				echo "파일 업로드 성공: " . $newFileName;
				$newFileName4 = $newFileName;		
				} else {
				echo "파일 업로드 실패.";
				}
			} else {
				echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
			}
		}

		// 업로드된 파일의 정보를 가져옵니다.
		$fileName = $_FILES["imgUpload5"]["name"];
		$fileTmpName = $_FILES["imgUpload5"]["tmp_name"];
		$fileSize = $_FILES["imgUpload5"]["size"];
	
		// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
		$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
		$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	
		if (in_array($fileExtension, $allowedExtensions)) {
			// 파일 크기를 체크하고 원하는 크기로 제한합니다.
			if ($fileSize <= $maxFileSize) {
				// 새로운 파일 이름을 생성합니다.
				$newFileName = uniqid() . "." . $fileExtension;
				$uploadPath = $uploadDir . $newFileName;
	
				// 임시 파일의 경로를 UTF-8로 변환합니다.
				$utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');
	
				// 파일을 이동시킵니다.
				if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
				echo "파일 업로드 성공: " . $newFileName;
				$newFileName5 = $newFileName;		
				} else {
				echo "파일 업로드 실패.";
				}
			} else {
				echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
			}
		}

	unset($value);
	$value['mb_id']			 = $member['id'];
	$value['subject']		 = $subject;
	$value['memo']			 = $_POST['memo'];
	$value['catename']		 = $_POST['catename'];
	$value['email']			 = $_POST['email'];
	$value['email_send_yes'] = $_POST['email_send_yes'];
	$value['cellphone']		 = replace_tel($_POST['cellphone']);
	$value['sms_send_yes']	 = $_POST['sms_send_yes'];
	$value['ip']			 = $_SERVER['REMOTE_ADDR'];
	$value['wdate']			 = BV_TIME_YMDHIS;
	$value['cellphone']		 = $_POST['cellphone1'].'-'.$_POST['cellphone2'].'-'.$_POST['cellphone3'];
	$value['imgUpload1']	 = $newFileName1;
	$value['imgUpload2']	 = $newFileName2;
	$value['imgUpload3']	 = $newFileName3;
	$value['imgUpload4']	 = $newFileName4;
	$value['imgUpload5']	 = $newFileName5;

	insert("shop_qa", $value);

	

	$wr_subject = get_text(stripslashes($subject));
	$wr_content = conv_content(conv_unescape_nl(stripslashes($_POST['memo'])), 0);
	$wr_name = get_text($member['name']);
	$subject = $wr_name.'님께서 1:1상담문의에 새글을 작성하셨습니다.';

	if($email) {
		ob_start();
		include_once(BV_BBS_PATH.'/write_update_mail.php');
		$content = ob_get_contents();
		ob_end_clean();

		mailer($wr_name, $email, $super['email'], $subject, $content, 1);
	}

	// 최고 관리자에게 문자전송
	icode_direct_sms_send('admin', $super_hp, $subject);

	alert("정상적으로 접수 되었습니다. 빠른 시간안에 답변드리겠습니다", BV_MBBS_URL."/qna_list.php");
}

$tb['title'] = '1:1 상담문의';
include_once("./_head.php");

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$form_action_url = BV_HTTPS_MBBS_URL.'/qna_write.php';
//echo(BV_MTHEME_PATH.'/qna_write.skin.php');
///home/juin/www/m/theme/basic/qna_write.skin.php

include_once(BV_MTHEME_PATH.'/qna_write.skin.php');

include_once("./_tail.php");
?>