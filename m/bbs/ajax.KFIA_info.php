<?php // 외식산업중앙회 회원조회 _20240328_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];

$b_no_preg = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $b_no);

// 테스트용 사업자 번호 : 1010185855;

$url = "http://222.237.78.230:9080/api/v1/center/member/find.do?bizNo={$b_no_preg}";

$ch = curl_init();                                 //CURL 세션 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);       //connection timeout 3초
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // 원격 서버의 인증서가 유효한지 검사 여부

$response = curl_exec($ch);                        //쿼리 실행
curl_close($ch);

// echo $response;


// 지회/지부 코드 안 줘서 DB에서 가져옴 _20240722_SY
$responseData = json_decode($response, true);
if($responseData['data']['IRS_NO']) {
  $office_name = $responseData['data']['OFFICE_NAME'];

  $office_sel = " SELECT * FROM kfia_office AS ko
               LEFT JOIN kfia_branch AS kb
                      ON (ko.branch_code = kb.branch_code)
                   WHERE office_name = '{$office_name}' 
                ";
  $office_row = sql_fetch($office_sel);
  $area_idx    = "";
  $branch_code = "";
  $office_code = "";
  if($office_row) {
    $area_idx    = $office_row['area_idx'];
    $branch_code = $office_row['branch_code'];
    $office_code = $office_row['office_code'];
  }


  $responseData['data']['AREA_IDX']    = $area_idx;
  $responseData['data']['OFFICE_CODE'] = $office_code;
  $responseData['data']['BRANCH_CODE'] = $branch_code;
}
$res = json_encode($responseData);
echo $res;
