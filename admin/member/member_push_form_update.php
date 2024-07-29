<?php
include_once "./_common.php";

$targetIdx   = array();
$targetFcm   = array();
$regionGrade = implode(",", $group_code);
$regionMem   = implode(",", $member_code);

if (isset($_POST['group_code'])) {
  for ($i = 0; $i < count($group_code); $i++) {
    $codes = explode("|", $group_code[$i]);
    $AND   = "";

    if ($codes[1] != "all") {
      $AND = " AND ju_region3 = '{$codes[1]}'";
    }

    $sql = "SELECT * FROM shop_member
            WHERE ju_region2 = '{$codes[0]}'
            {$AND}
            AND grade = '{$codes[2]}'";
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
    $targetIdx[] = $member_code[$j];

    $sql = "SELECT * FROM shop_member
            WHERE index_no = '$member_code[$j]}'";
    $res = sql_query($sql);
    while ($row = sql_fetch_array($res)) {
      $targetFcm[] = $row['fcm_token'];
    }
  }
}

if ($push_tm == 1) {
  $resv_date = $resv_date . ":00";
} else {
  $resv_date = "0000-00-00 00:00";
}

$targetIdxs     = array_unique($targetIdx);
$targetFcms     = array_unique($targetFcm);
$claenTargetIdx = implode(",", $targetIdxs);

$wdate = date("Y-m-d H:i:s");

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
$db_ins['p_target']       = $claenTargetIdx;    // idx값 ( 여러 데이터가 들어갈 예정 너무 많으면 곤란한데....)
$db_ins['p_cnt']          = count($targetIdxs); // 발송 수
$db_ins['senddate']       = $resv_date;
$db_ins['wdate']          = $wdate;

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
      ];
    }
    $response = sendFCMMessage2($messages);

    alert("푸시 정상 발송", "/admin/member.php?code=push");
  } else {
    alert("잘못된 접근입니다.");
  }
} else {
  alert("푸시 예약 등록");
}

// 크론텝으로 예약 넣기 ( 이건 예약일때만 )
// 수정 하기