<?php
include_once "./_common.php";

$od_pwd = get_encrypt_string($od_pwd);

// 회원인 경우
if ($is_member) {
  $sql_common = " from shop_order_reg a left JOIN toss_transactions b ON ( a.od_id = b.orderId ) where a.mb_id = '{$member['id']}'";
} else {
  goto_url(BV_MBBS_URL . '/login.php?url=' . $urlencode);
}


// 테이블의 전체 레코드수만 얻음
$sql         = " select count(DISTINCT a.od_id) as cnt " . $sql_common;
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

// 비회원 주문확인시 비회원의 모든 주문이 다 출력되는 오류 수정
// 조건에 맞는 주문서가 없다면
if ($total_count == 0) {
  if ($is_member) // 회원일 경우는 메인으로 이동
  {
    alert('주문이 존재하지 않습니다.', '/m/shop/mypage.php');
  } else // 비회원일 경우는 이전 페이지로 이동
  {
    alert('주문이 존재하지 않습니다.');
  }

}

$rows       = 10;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {$page = 1;}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함

if ($from_record < 0) {
  $from_record = 0;
}

$sql_order = " group by od_id order by index_no desc ";

$sql    = " select * $sql_common $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$tb['title'] = '정기결제 내역';
include_once "./_head.php";
echo "
    <script>
        console.log('" . (BV_MTHEME_PATH . "/orderinquiry.skin.php") . "');
    </script>
";
include_once BV_MTHEME_PATH . "/regOrderList.skin.php";
include_once "./_tail.php";
?>