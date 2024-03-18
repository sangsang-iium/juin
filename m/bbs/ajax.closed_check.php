<?php // 휴/폐업조회 _20240227_SY
include_once("./_common.php");

$b_no = $_POST['b_num'];

// 공공데이터 API _20240318_SY
$b_no_preg = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $b_no);
$SERVICE_KEY = "KbLqXXzrZexAUdHyQsbODJnS%2FstQ1YF80El%2FWe%2FIkOLg2WASSFAI%2Bkn1ZqhH23%2FO0yNKNL%2FZA%2BevZk0%2BbN0IUQ%3D%3D";

$url = "https://api.odcloud.kr/api/nts-businessman/v1/status?serviceKey={$SERVICE_KEY}";

$data = array(
  'b_no' => [$b_no_preg]
);

// JSON 형식으로 데이터 인코딩
$data_json = json_encode($data);

$ch = curl_init();                                 //CURL 세션 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);       //connection timeout 3초
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // 원격 서버의 인증서가 유효한지 검사 여부
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);  // JSON 형식으로 POST DATA 전송
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json))
); // 헤더에 Content-Type 및 Content-Length 추가
curl_setopt($ch, CURLOPT_POST, true);              // POST 전송 여부

$response = curl_exec($ch);                        //쿼리 실행
curl_close($ch);

// API 예시 결과값 기준으로 임시 작업 _20240227_SY
/** 휴/폐업 조회 API Response Data
 * b_no     : ( string ) 사업자등록번호
 * s_stt    : ( string ) 납세자상태_명칭(01:계속사업자, 02:휴업자, 03:폐업자)
 * b_stt_cd : ( string ) 납세자상태_코드(01:계속사업자, 02:휴업자, 03:폐업자)
 * end_dt   : ( string ) 폐업일 (YYYYMMDD)
 */

 echo $response;

// echo json_encode(array("res" => $response, "msg" => $msg));