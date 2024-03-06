<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

include_once '/home/juin/www/common.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$encodedData = file_get_contents('php://input');
//바디로 받는 값 decodedData
$decodedData = json_decode($encodedData, true);

$queries = array(); // 쿼리스트링 받아올 배열
parse_str($_SERVER['QUERY_STRING'], $queries);

$sql = "SELECT * FROM iu_app WHERE idx = 1";
$row = sql_fetch($sql);
$row['ia_result'] = $row['ia_result'] == 0?true:false;

$data = array(
  'result'     => $row['ia_result'],
  'aos_ver'    => $row['ia_aos_ver'],
  'aos_url'    => $row['ia_aos_url'],
  'ios_ver'    => $row['ia_ios_ver'],
  'ios_url'    => $row['ia_ios_url'],
  'Policy'     => array(
    'policy_use' => $row['ia_puse'],
    'name'       => $row['ia_pname'],
    'value'      => $row['ia_pvalue'],
  ),
  'Inspection' => array(
    'inspection_use' => $row['ia_iuse'],
    'name'           => $row['ia_iname'],
    'value'          => $row['ia_ivalue'],
  ),
  'keyword' => array (
    '미국산','고기','소고기'
  )
);
header('Content-Type: application/json');

if (in_array($requestMethod, ["GET"])) {
  http_response_code(200);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
  $returnArray = '405';
  http_response_code(405);
  echo json_encode($returnArray);
}
