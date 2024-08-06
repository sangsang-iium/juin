<?php
include_once("./_common.php");
include_once(BV_LIB_PATH."/mailer.lib.php");

check_demo();

check_admin_token();

if($w == "u") {
	// $qa = sql_fetch("select * from shop_qa where index_no='$index_no'");
  // sql 수정 _20240703_SY
  $qa_sql = " SELECT qa.*, mm.index_no AS idx, mm.fcm_token FROM shop_qa AS qa
           LEFT JOIN shop_member AS mm
                  ON (qa.mb_id = mm.id)
               WHERE qa.index_no = '{$index_no}' ";
  $qa = sql_fetch($qa_sql);
	if(!$qa['result_yes']) { // 답변전
		if($qa['email_send_yes'] && $_POST['reply']) {
			$subject = '[1:1문의 답변 알림 메일] '.$config['company_name'];
			mailer($config['company_name'], $super['email'], $qa['email'], $subject, $_POST['reply'], 1);
		}

		if($qa['sms_send_yes'] && $qa['cellphone']) {
			$content = '1:1문의에 답변이 등록되었습니다. '.$config['company_name'];
			icode_direct_sms_send('admin', $qa['cellphone'], $content);
		}
    
    // PUSH 추가 _20240703_SY
    $message = [
      'token' => $qa['fcm_token'], // 수신자의 디바이스 토큰
      'title' => '1:1문의 답변 알림',
      'body' => '문의하셨던 1대1 문의에 답변이 등록되었습니다.'
    ];
    
    if(!empty($qa['fcm_token'])){
      $response = sendFCMMessage($message);
    } else {
      $response = "토큰 없음";
    }

    // logInsert _20240806_SY
    $log_table = "iu_push_log";
    $log_ins['p_mb_id'] = $qa['idx'];
    $log_ins['p_type'] = "1대1문의";
    $log_ins['p_title'] = $message['title'];
    $log_ins['p_contents'] = $message['body'];
    $log_ins['p_response'] = $response;
    $log_ins['wdate'] = date('Y-m-d H:i:s');

    $LOG = new IUD_Model;
    $LOG->insert($log_table, $log_ins);
	}

	unset($value);
	$value['reply'] = $_POST['reply'];
	$value['replyer'] = $_POST['replyer'];
	$value['result_yes'] = 1;
	$value['result_date'] = BV_TIME_YMDHIS;
	update("shop_qa", $value, "where index_no='$index_no'");

	goto_url(BV_ADMIN_URL."/help.php?code=qa_form&w=u&index_no=$index_no$qstr&page=$page");
}
?>