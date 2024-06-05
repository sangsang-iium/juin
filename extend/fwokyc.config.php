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

// 중고장터 주소 동까지
function getUsedAddress($addr){
    $addrs = explode(" ", trim($addr));
    $rtn = [];
    if(trim($addrs[0])) array_push($rtn, trim($addrs[0]));
    if(trim($addrs[1])) array_push($rtn, trim($addrs[1]));
    if(trim($addrs[2])) array_push($rtn, trim($addrs[2]));
    if(count($rtn)){
        return implode(" ", $rtn);
    } else {
        return '미등록';
    }
}

// 중고장터 주소 동만
function getUsedAddressLast($addr){
    $addrs = explode(" ", trim($addr));
    if(trim($addrs[2])){
        return trim($addrs[2]);
    } else if(trim($addrs[1])){
        return trim($addrs[1]);
    } else if(trim($addrs[0])){
        return trim($addrs[0]);
    } else {
        return '미등록';
    }
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

// 중고장터 마지막 채팅후 지난시간 표시
function getUsedChatPasstime($lasttime){
    if($lasttime==0) return '--';
    
    $diff = BV_SERVER_TIME - (int)$lasttime;

    $s = 60; //1분 = 60초
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 10; //1년 = 1일 * 10일

    if ($diff < $s) {
        $result = $diff . '초전';
    } elseif ($h > $diff && $diff >= $s) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff && $diff >= $h) {
        $result = round($diff/$h) . '시간전';
    } elseif ($y > $diff && $diff >= $d) {
        $result = round($diff/$d) . '일전';
    } else {
    	$result = date('Y.m.d.', strtotime($datetime));
    }

    return $result;
}

// 음식점 좋아요(관심상품)수
// 회원테이블의 index_no 이용
function getStoreGoodCount($index_no) {
    $sql = "select count(*) as cnt from shop_store_good where pno = '$index_no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

// 음식점 좋아요(관심상품) 등록여부
function getStoreGoodRegister($index_no, $mb_id) {
    $sql = "select count(*) as cnt from shop_store_good where pno = '$index_no' and mb_id = '$mb_id'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}