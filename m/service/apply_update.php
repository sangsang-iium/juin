<?php
include_once "./_common.php";
include_once '../../include/crypt.php';

// if (empty($b_type)) {
//   alert("정상적인 방법으로 접근해주세요.", "./list.php");
// }

/* ------------------------------------------------------------------------------------- _20240714_SY
  * isset 추가 & 노무 비밀번호 제거
/* ------------------------------------------------------------------------------------- */
$bc_able = isset($bc_able) ? implode("||", $bc_able) : "";
$b_tel   = isset($b_tel) ? implode("-", $b_tel) : "";
$b_phone = isset($b_phone) ? implode("-", $b_phone) : "";

$db_input['mb_id'] = $mb_id;
// 1. 신한체크, 2. 신한신용, 3. 노무, 4, 상조
switch ($b_type) {
  case '1':
  case '2':
    $db_input['b_type']   = $b_type;
    $db_input['bc_gubun'] = $bc_gubun;
    $db_input['bc_card']  = $bc_card;
    $db_input['bc_sale']  = $bc_sale;
    $db_input['bc_birth'] = $bc_birth;
    $db_input['bc_able']  = $bc_able;
    $db_input['c_name']   = $c_name;
    $db_input['b_num']    = $b_num;
    $db_input['b_phone']  = $b_phone;
    $db_input['b_staff']  = $b_staff;
    $db_input['b_agree']  = $b_agree;
    break;
  case '3':
    $db_input['b_type']     = $b_type;
    $db_input['b_addr_zip'] = $b_addr_zip;
    $db_input['b_addr_1']   = $b_addr_1;
    $db_input['b_addr_2']   = $b_addr_2;
    $db_input['b_addr_3']   = $b_addr_3;
    $db_input['b_name']     = $b_name;
    $db_input['b_num']      = $b_num;
    $db_input['c_name']     = $c_name;
    $db_input['b_tel']      = $b_tel;
    $db_input['b_phone']    = $b_phone;
    $db_input['b_contents'] = $b_contents;
    $db_input['b_hope']     = $b_hope;
    // $db_input['b_pw']       = $b_pw;
    $db_input['b_staff']    = $b_staff;
    break;
  case '4':
    $db_input['b_type']         = $b_type;
    $db_input['c_name']         = $c_name;
    $db_input['bc_birth']       = preg_replace('/[^0-9]/', '', $bc_birth);
    $db_input['b_sex']        = $b_sex;
    $db_input['b_addr_zip']     = $b_addr_zip;
    $db_input['b_addr_1']       = $b_addr_1;
    $db_input['b_addr_2']       = $b_addr_2;
    $db_input['b_addr_3']       = $b_addr_3;
    $db_input['b_name']         = $b_name;
    $db_input['b_addr_zip20']   = $b_addr_zip20;
    $db_input['b_addr_21']      = $b_addr_21;
    $db_input['b_addr_22']      = $b_addr_22;
    $db_input['b_addr_23']      = $b_addr_23;
    $db_input['b_tel']          = $b_tel;
    $db_input['b_phone']        = $b_phone;
    $db_input['b_paymethod']    = $b_paymethod;
    if($b_paymethod == '자동이체'){
      $db_input['b_bank']         = $b_bank;
      $db_input['b_account_num']  = preg_replace('/[^0-9]/', '', $b_account_num);
      $db_input['b_account_name'] = $b_account_name;
    } else {
      $db_input['bc_card_com']    = $bc_card_com;
      $db_input['bc_card_num']    = preg_replace('/[^0-9]/', '', $bc_card_num);
      $db_input['bc_card_cvc']    = $bc_card_cvc;
    }
    $db_input['bc_birth2']      = preg_replace('/[^0-9]/', '', $bc_birth2);
    $db_input['bc_relation']    = $bc_relation;
    $db_input['bc_acc']         = $bc_acc;
    $db_input['bc_acc_date']    = $bc_acc_date;
    $db_input['bc_applicant']   = $bc_applicant;
    $db_input['b_sign']         = $sign1;
    $db_input['b_agree']        = $b_agree;
    $db_input['b_agree1']       = $b_agree1;
    $db_input['b_staff']        = $b_staff;

    break;
}

$db_input['wdate'] = date("Y-m-d H:i:s");


$serviceModel = new IUD_Model();
$serviceTable = "iu_service";
$svcIdx = $serviceModel->insert($serviceTable, $db_input);

if($b_type == 4){

  $db_input['b_staff'] = str_replace('E', '', $b_staff);
  $peopleArr           = $db_input;
  $peopleLifeReturn = peopleLifeApi($peopleArr);
  if($peopleLifeReturn->result == 0000){
    $serviceModel4 = new IUD_Model();
    $serviceTable4 = "iu_service";
    $serviceUp4['b_chk'] = 1;
    $serviceWhere = "WHERE idx = '{$svcIdx}'";
    $serviceModel4->update($serviceTable4, $serviceUp4, $serviceWhere);

    alert("정상 등록되었습니다.", "./list.php");
  } else {
    alert("관리자에게 문의해주세요.", "./list.php");
  }
}

function peopleLifeApi($dataArr) {
  $url  = "https://thepeoplelife.co.kr/api/ri/member/data/";
  $jsonData = json_encode($dataArr);

  $ch = curl_init();                                             //CURL 세션 초기화
  curl_setopt($ch, CURLOPT_URL, $url);                           //URL 지정
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);                  //connection timeout 10초
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                //요청 결과를 문자열로 반환
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);               // 원격 서버의 인증서가 유효한지 검사 여부
  curl_setopt($ch, CURLOPT_POST, true);                          // POST 요청 설정
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // POST 데이터 설정
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData))
  );

  $response = curl_exec($ch); // 쿼리 실행
  curl_close($ch);

  return json_decode($response);
}

// 신한카드 데이터 받아오기 ( 안받아오네~ )
// if ($b_type == 1 || $b_type == 2) {
//   // 기본값 설정
//   $P1 = $b_type == 1 ? 1 : "";
//   $P2 = $b_type == 2 ? 2 : "";

// // 배열 생성 및 문자열 조합
// // 지회지부 마지막에 5자리 코드로 전달 해야함
// 20240719 코드 추가 되었어 이거 주석  풀때 꼭 처리해서 보내자~~~
//   $planArr = array(
//     "0000000000000000", // nonce
//     date("YmdHis"),     // 현재 시간
//     $c_name,            // 이름
//     $b_staff,           // 생년월일
//     $b_staff,           // 사업자번호
//     $b_staff,           // 추천인 번호
//     $P1,                // P1 값 신용1 채크2
//     $P2,                // 지회지부코드  office code
//     $P2,                // 지회지부명   한글로
//   );

//   // 문자열 조합
//   $plan = implode("||", $planArr);

//   $enc = encryptSin($plan);
//   $url = "https://food.shinhancard.com/waf/etot00810?P=" . $enc;

//   // cURL로 GET 요청 보내기
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_URL, $url);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//   $response = curl_exec($ch);
//   curl_close($ch);

//   if ($response !== false) {
//     $response = iconv("EUC-KR", "UTF-8", $response);
//     echo "Response: " . $response . "\n";
//   } else {
//     echo "Failed to get response.\n";
//   }
// }
// $dec = decrypt($response);
alert("정상 등록되었습니다.", "./list.php");