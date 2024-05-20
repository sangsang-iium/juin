<?php
include_once('./_common.php');

// 정렬 방식에 따른 $order_by 설정
$order_by = isset($_GET['sort']) ? $_GET['sort'] : '';

global $member, $gw_star, $pt_id, $default;

$rows = 10;

$sql_common = " from shop_goods_review ";
$sql_search = " where gs_id = '$gs_id' ";

if ($default['de_review_wr_use']) {
    $sql_search .= " and pt_id = '$pt_id' ";
}

if ($order_by == '') {
    $sql_order = " order by index_no desc limit $rows ";
} else if ($order_by == 'last') {
    $sql_order = " order by index_no desc limit $rows ";
} else if ($order_by == 'high') {
    $sql_order = " order by score desc, index_no desc limit $rows ";
} else if ($order_by == 'low') {
    $sql_order = " order by score asc, index_no desc limit $rows ";
}

$sql = " select * $sql_common $sql_search $sql_order ";
$result = sql_query($sql);

$output = '';
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $tmp_date = substr($row['reg_time'], 0, 10);
    $tmp_score = $gw_star[$row['score']];
    $len = strlen($row['mb_id']);
    $str = substr($row['mb_id'], 0, 3);
    $tmp_name = $str . str_repeat("*", $len - 3);
    $hash = md5($row['index_no'] . $row['reg_time'] . $row['mb_id']);
    $reviewImgArr = reviewImg($row['index_no']);
    $reviewOption = reviewGoodOption($gs_id);

    $output .= "<div class='rv-item'>";
    $output .= "<div class='rv-top'>";
    $output .= "<div class='left'>";
    $output .= "<div class='point'>";
    $output .= "<img src='/src/img/icon-point" . $row['score'] . ".svg' alt=''>";
    $output .= "</div>";
    $output .= "<p class='name'>$tmp_name</p>";
    $output .= "</div>";
    $output .= "<div class='right'>";
    $output .= "<p class='date'>$tmp_date</p>";
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
    $output .= "<div class='content'><div class='content_in'>" . $row['memo'] . "</div></div>";
    $output .= "<button type='button' class='cont-more-btn'>더보기+</button>";
    $output .= "</div>";

    if (is_admin() || ($member['id'] == $row['mb_id'])) {
        $output .= "<div class='mngArea'>";
        $output .= "<a href='javascript:void(0);' data-me-id='" . $row['index_no'] . "' class='ui-btn st3 rv-edit-btn'>수정</a>";
        $output .= "<a href='" . BV_MSHOP_URL . "/orderreview_update.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=d&hash=$hash' class='ui-btn st3 itemqa_delete'>삭제</a>";
        $output .= "</div>";
    }

    $output .= "</div>";
}

if ($i == 0) {
    $output .= "<div class='empty_box'>자료가 없습니다</div>";
}

echo $output;
?>