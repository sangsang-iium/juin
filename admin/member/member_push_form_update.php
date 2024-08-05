<?php
include_once "./_common.php";

$targetIdx   = array();
$targetFcm   = array();
$regionGrade = implode(",", $group_code);
$regionMem   = implode(",", $member_code);

$wdate = date("Y-m-d H:i:s");

if (isset($_POST['group_code'])) {
  for ($i = 0; $i < count($group_code); $i++) {
    $codes = explode("|", $group_code[$i]);
    $AND   = "";

    if ($codes[1] != "all") {
      $AND = " AND ju_region3 = '{$codes[1]}'";
    }

    // AND fcm_token <> ''  추가 _20240731_SY
    $sql = "SELECT * FROM shop_member
            WHERE ju_region2 = '{$codes[0]}'
            {$AND}
            AND grade = '{$codes[2]}' 
            AND fcm_token <> '' ";
    $res = sql_query($sql);
    while ($row = sql_fetch_array($res)) {
      $targetIdx[] = $row['index_no'];
      $targetFcm[] = $row['fcm_token'];
    }
  }
}

// member_code  일반 회원 데이터값
// group_code   지회 지부
if (isset($_POST['member_code'])) {
  for ($j = 0; $j < count($member_code); $j++) {
    // $targetIdx[] = $member_code[$j];

    // AND fcm_token <> '' 및 targetIdx 추가 _20240731_SY
    $sql = "SELECT * FROM shop_member
            WHERE index_no = '{$member_code[$j]}' 
            AND fcm_token <> '' ";
    $res = sql_query($sql);
    while ($row = sql_fetch_array($res)) {
      $targetIdx[] = $row['index_no'];
      $targetFcm[] = $row['fcm_token'];
    }
  }
}

if ($push_tm == 1) {
  $resv_date = $resv_date . ":00";
} else {
  $resv_date = $wdate;
}

$targetIdxs     = array_values(array_unique(array_filter($targetIdx)));
$targetFcms     = array_values(array_unique(array_filter($targetFcm)));
$claenTargetIdx = implode(",", $targetIdxs);


// push_tm = 0: 즉시 // 1: 예약
// $db_ins['p_tmp_file']       = $p_tmp_file;
// $db_ins['p_orgin_file']       = $p_orgin_file;
$db_ins['idx']            = $idx;
$db_ins['p_title']        = $push_subject;
$db_ins['p_content']      = $push_contents;
$db_ins['p_link']         = $push_url;
$db_ins['p_send_time']    = $push_tm;
$db_ins['P_type']         = "";
$db_ins['p_region_grade'] = $regionGrade;
$db_ins['p_region_mem']   = $regionMem;
$db_ins['p_sender']       = $member['id'];    // idx값 ( 여러 데이터가 들어갈 예정 너무 많으면 곤란한데....)
$db_ins['p_target']       = $claenTargetIdx;    // idx값 ( 여러 데이터가 들어갈 예정 너무 많으면 곤란한데....)
$db_ins['p_cnt']          = count($targetIdxs); // 발송 수
$db_ins['senddate']       = $resv_date;
$db_ins['wdate']          = $wdate;

$push_image = "";
if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { 
  $push_image = "https://juinjang.kr/data/category/gWfvPVEQ7T8cPJyUX8uSnSwHmk2zkg.png";
}

$pushModel = new IUD_Model();
$table     = "iu_push";

$inputIndex = $pushModel->insert($table, $db_ins);

if($push_tm == "0"){
  if (!empty($inputIndex)) {
    $messages = [];
    for ($i = 0; $i < count($targetFcms); $i++) {
      $messages[] = [
        'token' => $targetFcms[$i], // 수신자의 디바이스 토큰
        'title' => "{$push_subject}",
        'body'  => "{$push_contents}",
        'link'  => "{$push_url}",
        'image' => "{$push_image}",
      ];
    }

    $response = sendFCMMessage2($messages);

    // push_log _20240730_SY
    // 문제점 : 토큰 없는 사람의 log 도 쌓이게 됨
    $logModel = new IUD_Model;
    $logTable = "iu_push_log";

    $log_ins['p_idx']      = $inputIndex;
    $log_ins['p_type']     = "즉시발송";
    $log_ins['p_title']    = $push_subject;
    $log_ins['p_contents'] = $push_contents;
    $log_ins['wdate']      = $wdate;
    for($k=0; $k<count($targetFcms); $k++) {
      $log_ins['p_mb_id']  = $targetIdxs[$k];
      $logModel->insert($logTable, $log_ins);
    }
  
    alert("푸시 정상 발송", "/admin/member.php?code=push");
  } else {
    alert("잘못된 접근입니다.");
  }
} else {
  alert("푸시 예약 등록");
}

// 크론텝으로 예약 넣기 ( 이건 예약일때만 )
// 수정 하기