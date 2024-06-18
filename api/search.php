<?php

include_once '/home/juin/www/common.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');


$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);
log_write($decodedData);
$queries = array(); // 쿼리스트링 받아올 배열
parse_str($_SERVER['QUERY_STRING'], $queries);

insert_popular('admin', $queries['search']);

http_response_code(200);
echo json_encode($queries, JSON_UNESCAPED_UNICODE);
