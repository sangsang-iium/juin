<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가

$used_categorys = explode("|", $config['cf_used']);
$food_categorys = explode("|", $config['cf_food']);
$singo_categorys = explode("|", $config['cf_singo']);


// 회원이름
function getMemberName($mb_id){
    $sql = "select name from shop_member where id = '$mb_id'";
    $row = sql_fetch($sql);
    return $row['name'];
}


// 중고장터 구분/상태
function getUsedGubunStatus($gubun, $status) {
    $rtn = ['팝니다', '판매중'];
    if($gubun=='1'){
        $rtn = ['삽니다', '-'];
    } else if($status=='1'){
        $rtn[1] = '예약중';
    } else if($status=='1'){
        $rtn[1] = '판매완료';
    }
    
    return $rtn;
}

// 중고장터 댓글수
function getUsedCommentCount($no) {
    $sql = "select count(*) as cnt from shop_used_comment where pno = '$no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

// 중고장터 좋아요(관심상품)수
function getUsedGoodCount($no) {
    $sql = "select count(*) as cnt from shop_used_good where pno = '$no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

// 중고장터 좋아요(관심상품) 등록여부
function getUsedGoodRegister($no, $mb_id) {
    $sql = "select count(*) as cnt from shop_used_good where pno = '$no' and mb_id = '$mb_id'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

// 중고장터 채팅방수
function getUsedChatCount($no) {
    $sql = "select count(*) as cnt from shop_used_chat where pno = '$no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}






// 회원사현황 리스트 가져오기
function getStoreList($lat, $lng, $dong='', $cate=''){
    $lat = (int)$lat;
    $lng = (int)$lng;
    $sql = "SELECT *, ( 6371 * acos( cos( radians({$lat}) ) * cos( radians( ju_lat ) ) * cos( radians( ju_lng ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( ju_lat ) ) ) ) AS distance ";
    $sql .= "FROM shop_member HAVING distance < 25 ORDER BY distance";
    echo $sql;
}