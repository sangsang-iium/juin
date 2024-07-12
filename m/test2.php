<?php
$url = "http://222.237.78.230:9080/api/v1/center/member/findOfficeList.do";

$ch = curl_init();                               //CURL 세션 초기화
curl_setopt($ch, CURLOPT_URL, $url);             //URL 지정
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);    //connection timeout 3초
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 원격 서버의 인증서가 유효한지 검사 여부

$response = curl_exec($ch); //쿼리 실행
curl_close($ch);

echo $response;

/*
/api/v1/center/member/find.do
/api/v2/center/member/findMember.do

/api/v1/center/member/findOfficeList.do
/api/v1/center/member/findEmployeeList.do
*/