<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가

$used_categorys = explode("|", $config['cf_used']);
$food_categorys = explode("|", $config['cf_food']);
$singo_categorys = explode("|", $config['cf_singo']);

// 중고장터 구분/상태
function getUsedGubunStatus($gubun, $status) {
    $rtn = ['팝니다', '판매중'];
    if($gubun=='1'){
        $rtn = ['삽니다', '-'];
    } else if($status=='1'){
        $rtn[1] = '판매 완료';
    }
    
    return $rtn;
}

// 중고장터 댓글수
function getUsedCommentCount($no) {
    $sql = "select count(*) as cnt from shop_used_comment where pno = '$no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

// 중고장터 좋아요(관심)
function getUsedGoodCount($no) {
    $sql = "select count(*) as cnt from shop_used_good where pno = '$no'";
    $row = sql_fetch($sql);

    return $row['cnt'];
}