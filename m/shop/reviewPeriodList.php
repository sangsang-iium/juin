<?php
include_once('./_common.php');

$gs_id = isset($_POST['gs_id']) ? $_POST['gs_id'] : '';
$period = isset($_POST['period']) ? (int)$_POST['period'] : 0;

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

global $member, $gw_star, $pt_id, $default;
$sql_common = " from shop_goods_review ";
$sql_search = " where gs_id = '$gs_id' ";

if ($default['de_review_wr_use']) {
    $sql_search .= " and pt_id = '$pt_id' ";
}

if ($period > 0) {
    $sql_search .= " and reg_time >= DATE_SUB(NOW(), INTERVAL $period MONTH) ";
}

$sql_order = " order by index_no desc ";

// 페이징 설정
$rows = 10; // 한 페이지에 보여줄 리뷰 개수
$total_query = "SELECT COUNT(*) as cnt $sql_common $sql_search";
$total = sql_fetch($total_query);
$total_count = $total['cnt'];
$total_page = ceil($total_count / $rows);
$from_record = ($page - 1) * $rows;

$sql = " select * $sql_common $sql_search $sql_order LIMIT $from_record, $rows ";
$result = sql_query($sql);

// $sql = " select * $sql_common $sql_search $sql_order ";
// $result = sql_query($sql);

$output = '';
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $wr_star = $gw_star[$row['score']];
    $wr_id = substr($row['mb_id'], 0, 3) . str_repeat("*", strlen($row['mb_id']) - 3);
    $wr_time = substr($row['reg_time'], 0, 10);
    $hash = md5($row['index_no'] . $row['reg_time'] . $row['mb_id']);
    $reviewImgArr = reviewImg($row['index_no']);
    $reviewOption = reviewGoodOption($gs_id);

    $output .= "<div class='rv-item'>";
    $output .= "<div class='rv-top'>";
    $output .= "<div class='left'>";
    $output .= "<div class='point'>";
    $output .= "<img src='/src/img/icon-point" . $row['score'] . ".svg' alt=''>";
    $output .= "</div>";
    $output .= "<p class='name'>$wr_id</p>";
    $output .= "</div>";
    $output .= "<div class='right'>";
    $output .= "<p class='date'>$wr_time</p>";
    $output .= "</div>";
    $output .= "</div>";

    if ($row['option1'] || $row['option2']) {
        $output .= "<div class='rv-option-wr'>";
        if ($row['option1']) {
            $output .= "<div class='rv-option-item'>";
            $output .= "<p class='tit'>" . $reviewOption[0] . "</p>";
            $output .= "<p class='cont'>" . $row['option1'] . "</p>";
            $output .= "</div>";
        }
        if ($row['option2']) {
            $output .= "<div class='rv-option-item'>";
            $output .= "<p class='tit'>" . $reviewOption[1] . "</p>";
            $output .= "<p class='cont'>" . $row['option2'] . "</p>";
            $output .= "</div>";
        }
        $output .= "</div>";
    }

    $output .= "<div class='rv-content-wr'>";

    if (sizeof($reviewImgArr) > 0) {
        $output .= "<div class='rv-img-list'>";
        foreach ($reviewImgArr as $reviewImg) {
            $output .= "<div class='rv-img-item'>";
            $output .= "<div class='rv-img'>";
            $output .= "<img src='/data/review/" . $reviewImg['thumbnail'] . "' alt=''>";
            $output .= "</div>";
            $output .= "</div>";
        }
        $output .= "</div>";
    }

    $output .= "<div class='content'>" . $row['memo'] . "</div>";

    $output .= "<button type='button' class='cont-more-btn'>더보기+</button>";
    $output .= "</div>";

    if (is_admin() || ($member['id'] == $row['mb_id'])) {
        $output .= "<div class='mngArea'>";
        $output .= "<a href=\"javascript:void(0);\" data-me-id='" . $row['index_no'] . "' class='ui-btn st3 rv-inEdit-btn'>수정</a>";
        $output .= "<a href=\"" . BV_MSHOP_URL . "/orderreview_update.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=d&hash=$hash&p=1\" class='ui-btn st3 itemqa_delete'>삭제</a>";
        $output .= "</div>";
    }

    $output .= "</div>";
}

if ($i == 0) {
    $output .= "<div class='empty_box'>자료가 없습니다</div>";
}

$response = array(
    'reviewHtml' => $output,
    'totalCount' => $total_count,
    'currentPage' => $page,
    'totalPages' => $total_page
);

echo json_encode($response);
?>