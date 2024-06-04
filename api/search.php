<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

include_once '/home/juin/www/common.php';


$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);

// $queries = array(); // 쿼리스트링 받아올 배열
// parse_str($_SERVER['QUERY_STRING'], $queries);

insert_popular('admin', $decodedData['search']);

http_response_code(200);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
