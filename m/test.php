<?php
include "./_common.php";

$url = "http://222.237.78.230:9080/api/v1/center/member/findEmployeeList.do";

$ch = curl_init();                               //CURL 세션 초기화
curl_setopt($ch, CURLOPT_URL, $url);             //URL 지정
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);    //connection timeout 3초
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 원격 서버의 인증서가 유효한지 검사 여부

$response = curl_exec($ch); //쿼리 실행
curl_close($ch);

$res = json_decode($response, true);
print_r($res);

// $branchArr = [];
// $officeArr = [];

// foreach($res['list'] as $key => $val){
//   if(isset($val['OFFICE_CODE'])){
//     $officeArr[] = $val;
//     continue;
//   } else {
//     $branchArr[] = $val;
//   }
// }

// function removeText1($text) {
//   return str_replace("지회", "", $text);
// }

// function removeText2($text) {
//   return str_replace("광역시", "", $text);
// }

// for($i=0; $i<count($branchArr); $i++) {

//   $areaText = removeText1($branchArr[$i]['OFFICE_NAME']);
//   $areaText = removeText2($areaText);


//   $re_sel = " SELECT * FROM area WHERE (areaname2 LIKE '%{$areaText}%' OR areaname LIKE '%{$areaText}%')";
//   $re_row = sql_fetch($re_sel);

//   $bIns['branch_code'] = $branchArr[$i]['BRANCH_CODE'];
//   $bIns['branch_name'] = $branchArr[$i]['OFFICE_NAME'];
//   $bIns['branch_wdate'] = date('Y-m-d H:i:s');
//   $bIns['branch_udate'] = date('Y-m-d H:i:s');

//   if($re_row) {
//     $bIns['area_idx'] = $re_row['areacode'];
//   } else {
//     $bIns['area_idx'] = "";
//   }

//   // $BRANCH_INSERT = new IUD_Model;
//   // $BRANCH_INSERT->insert("kfia_branch", $bIns);
// }

// for($i=0; $i<count($officeArr); $i++) {
//   $oIns['branch_code'] = $officeArr[$i]['BRANCH_CODE'];
//   $oIns['office_code'] = $officeArr[$i]['OFFICE_CODE'];
//   $oIns['office_name'] = $officeArr[$i]['OFFICE_NAME'];
//   $oIns['office_wdate'] = date('Y-m-d H:i:s');
//   $oIns['office_udate'] = date('Y-m-d H:i:s');
//   $oIns['auth_idx'] = '1';

//   // $OFFICE_INSERT = new IUD_Model;
//   // $OFFICE_INSERT->insert("kfia_office", $oIns);
// }



/*
/api/v1/center/member/find.do
/api/v2/center/member/findMember.do

/api/v1/center/member/findOfficeList.do
/api/v1/center/member/findEmployeeList.do
*/