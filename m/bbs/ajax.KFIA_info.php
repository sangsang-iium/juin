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

echo $response;
