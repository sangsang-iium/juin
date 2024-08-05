<?php // MEMBER DB UPDATE _SY
include_once "_common.php";

/* 중복 회원 색출 */
// 중복값 색출
// $mem_du_sel = "SELECT ju_b_num, COUNT(*)
//                  FROM shop_member
//                 WHERE ju_b_num <> '' AND ju_b_num <> '000-00-00000'
//              GROUP BY ju_b_num
//                HAVING COUNT(*) > 1 ";
// $mem_du_res = sql_query($mem_du_sel);
// $mem_du_num = sql_num_rows($mem_du_res);

// // 중복맴버 색출
// while($mem_du_row = sql_fetch_array($mem_du_res)) {
//   $mem_sel = " SELECT * FROM shop_member WHERE ju_b_num = '{$mem_du_row['ju_b_num']}' ORDER BY index_no DESC LIMIT 1 ";
//   $mem_sel_row = sql_fetch($mem_sel);

//   $update_query = "UPDATE shop_member 
//                    SET zip = '{$mem_sel_row['zip']}',
//                        ju_cate = '{$mem_sel_row['ju_cate']}',
//                        ju_region3 = '{$mem_sel_row['ju_region3']}',
//                        ju_sectors = '{$mem_sel_row['ju_sectors']}'
//                    WHERE ju_b_num = '{$mem_du_row['ju_b_num']}'
//                    ORDER BY index_no ASC LIMIT 1";
//   sql_query($update_query);
//   $mem_del = sql_query(" DELETE FROM shop_member WHERE ju_b_num = '{$mem_du_row['ju_b_num']}' ORDER BY index_no DESC LIMIT 1 ");
// }



/* 비밀번호 암호화 */
// $mem_sel = " SELECT * FROM shop_member WHERE grade = 6 AND index_no >= 12700 ";
// $mem_res = sql_query($mem_sel);
// while($mem_row = sql_fetch_array($mem_res)) {
//   $pw = get_encrypt_string($mem_row['passwd']);

//   $update_query = " UPDATE shop_member SET 
//                           passwd = '{$pw}'
//                      WHERE index_no = '{$mem_row['index_no']}' ";
//   sql_query($update_query);
// }




/* 지회 지부 코드값으로 변경 */
// UPDATE shop_member AS mm
// JOIN kfia_office AS ko
// ON (mm.ju_region3 = ko.office_name)
// SET mm.ju_region2 = kb.branch_code
// SET mm.ju_region3 = kb.office_code



/* 주소 UPDATE */
// $mem_sel = "SELECT * FROM shop_member WHERE addr1 = '' AND id <> 'admin'";
// $mem_res = sql_query($mem_sel);
// while ($mem_row = sql_fetch_array($mem_res)) {
//     $newAddr = $mem_row['ju_addr_full'];
    
//     // 작은 따옴표를 이스케이프 처리
//     $newAddr = str_replace("'", "''", $newAddr);
    
//     $update_query = "UPDATE shop_member SET addr1 = '{$newAddr}' WHERE index_no = '{$mem_row['index_no']}'";
    
//     sql_query($update_query);
// }



/* grade, reg_time, auth 변경 */
// $mem_sel = " SELECT * FROM shop_manager where index_no >= 1300 ";
// $mem_res = sql_query($mem_sel);
// $now = date('Y-m-d H:i:s');
// while($mem_row = sql_fetch_array($mem_res)) {
//   $grade = 2;

//   $update_query = " UPDATE shop_manager SET 
//                           grade = '{$grade}'
//                           ,reg_time = '{$now}'
//                           ,auth_1 = '1'
//                           ,auth_6 = '1'
//                           ,auth_7 = '1'
//                           ,auth_10 = '1'
//                      WHERE index_no = '{$mem_row['index_no']}' ";
//   sql_query($update_query);
// }



/** 지회 레벨 체크 및 수정 */
// $re_sel = " SELECT * FROM shop_manager WHERE ju_region2 != ju_region3 ";
// $re_res = sql_query($re_sel);
// while($re_row = sql_fetch_array($re_res)) {
// sql_query( " UPDATE shop_manager SET
//                     grade = '3'
//               WHERE index_no = '{$re_row['index_no']}'
//            " 
//          );

// }





/** 지회/지부 0 으로 들어간 오류 값 수정 */

// $update_mem_sel = "SELECT * FROM shop_member WHERE ju_region2 = '0' ";
// $update_mem_sel = " SELECT mm1.*
// FROM shop_member AS mm1
// LEFT JOIN (
//     SELECT mm.*
//     FROM shop_member AS mm
//     JOIN kfia_office AS ko
//     ON mm.ju_region3 = ko.office_code
//     WHERE mm.reg_time > '2024-07-24 00:00:00'
// ) AS mm2
// ON mm1.id = mm2.id
// WHERE mm1.reg_time > '2024-07-24 00:00:00'
// AND mm1.grade = 8
// AND mm2.id IS NULL";
// $update_mem_res = sql_query($update_mem_sel);
// for($i=0; $update_mem_row = sql_fetch_array($update_mem_res); $i++) {
//   $index_no = $update_mem_row['index_no'];
//   $b_no = $update_mem_row['ju_b_num'];  
//   $b_no_preg = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $b_no);
//   $url = "http://222.237.78.230:9080/api/v1/center/member/find.do?bizNo={$b_no_preg}";
  
//   $ch = curl_init();                                 //CURL 세션 초기화
//   curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정
//   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);       //connection timeout 3초
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
//   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // 원격 서버의 인증서가 유효한지 검사 여부
  
//   $response = curl_exec($ch);                        //쿼리 실행
//   curl_close($ch);
  
  
//   $responseData = json_decode($response, true);
//   $office_name = $responseData['data']['OFFICE_NAME'];
  
//   $office_sel = "SELECT * FROM kfia_office WHERE office_name = '{$office_name}' ";
//   $office_row = sql_fetch($office_sel);
//   $branch_code = "";
//   $office_code = "";
//   if($office_row) {
//     $branch_code = $office_row['branch_code'];
//     $office_code = $office_row['office_code'];
//   }
  
//   $upData['ju_region2'] = $branch_code;
//   $upData['ju_region3'] = $office_code;
//   $upWhere =  " WHERE index_no = '{$index_no}' ";
  
//   $UPDATE = new IUD_Model;
//   $UPDATE->update("shop_member", $upData, $upWhere);
  
// }




/** 휴/폐업 체크  */


// $closed_zero_sel = " SELECT * FROM shop_member WHERE ju_closed = '0' and grade = 8 AND ju_b_num <> '' ";
// $closed_zero_res = sql_query($closed_zero_sel);

// for($i=0; $closed_zero_row = sql_fetch_array($closed_zero_res); $i++) {
//   $index_no = $closed_zero_row['index_no'];
//   $b_no     = $closed_zero_row['ju_b_num'];

//   $b_no_preg = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $b_no);
//   $SERVICE_KEY = "KbLqXXzrZexAUdHyQsbODJnS%2FstQ1YF80El%2FWe%2FIkOLg2WASSFAI%2Bkn1ZqhH23%2FO0yNKNL%2FZA%2BevZk0%2BbN0IUQ%3D%3D";
  
//   $url = "https://api.odcloud.kr/api/nts-businessman/v1/status?serviceKey={$SERVICE_KEY}";
  
//   $data = array(
//     'b_no' => [$b_no_preg]
//   );
  
//   // JSON 형식으로 데이터 인코딩
//   $data_json = json_encode($data);
//   // echo $data_json;
  
//   $ch = curl_init();                                 //CURL 세션 초기화
//   curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정
//   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);       //connection timeout 3초
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
//   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // 원격 서버의 인증서가 유효한지 검사 여부
//   curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);  // JSON 형식으로 POST DATA 전송
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//       'Content-Type: application/json',
//       'Content-Length: ' . strlen($data_json))
//   ); // 헤더에 Content-Type 및 Content-Length 추가
//   curl_setopt($ch, CURLOPT_POST, true);              // POST 전송 여부
  
//   $response = curl_exec($ch);                        //쿼리 실행
//   curl_close($ch);
  
//   // API 예시 결과값 기준으로 임시 작업 _20240227_SY
//   /** 휴/폐업 조회 API Response Data
//    * b_no     : ( string ) 사업자등록번호
//    * s_stt    : ( string ) 납세자상태_명칭(01:계속사업자, 02:휴업자, 03:폐업자)
//    * b_stt_cd : ( string ) 납세자상태_코드(01:계속사업자, 02:휴업자, 03:폐업자)
//    * end_dt   : ( string ) 폐업일 (YYYYMMDD)
//    */
  
//   //  echo $response;
//   $responseData = json_decode($response);
//   $decodingData =  $responseData->data[0];
//   $closedStatus = $decodingData->b_stt_cd;

//   $upData['ju_closed'] = $closedStatus;
//   $upWhere =  " WHERE index_no = '{$index_no}' ";
  
//   $UPDATE = new IUD_Model;
//   $UPDATE->update("shop_member", $upData, $upWhere);
  

// }



/** 통계용 쿼리 */

// SELECT 
//    (SELECT kb.branch_name
//      FROM kfia_branch kb
//      WHERE kb.branch_code = sm.ju_region2) AS 지회,
//    (SELECT ko.office_name 
//      FROM kfia_office ko 
//      WHERE ko.office_code = sm.ju_region3) AS 지부,
//     COUNT(*) AS 전체회원수,
//     COUNT(CASE WHEN sm.grade = 6 THEN 1 END) AS 임직원,
//     COUNT(CASE WHEN sm.grade = 8 THEN 1 END) AS 중앙회회원,
//     COUNT(CASE WHEN sm.grade = 9 THEN 1 END) AS 일반회원,
//     COUNT(CASE WHEN sm.mb_agent = 'Windows' THEN 1 ELSE NULL END) AS 웹가입,
//     COUNT(CASE WHEN sm.mb_agent <> 'Windows' AND sm.mb_agent IS NOT NULL THEN 1 ELSE NULL END) AS 앱가입,
//     COUNT(CASE WHEN sm.mb_agent IS NULL THEN 1 ELSE NULL END) AS 확인불가
// FROM shop_member sm 
// WHERE grade >= 6
// -- AND reg_time < '2024-07-25 16:30:00'
// GROUP BY ju_region3 
// ORDER BY ju_region3


/** 회원가입 쿠폰 밀어 넣기 */