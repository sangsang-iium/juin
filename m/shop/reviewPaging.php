<?php
include_once('./_common.php');
if (!$cur_page) $cur_page = 1;
if (!$total_page) $total_page = 1;
if ($total_page < 2) return '';

$url = preg_replace('#(&|\?)page=[0-9]*#', '', $url);
$url .= (strpos($url, '?') === false ? '?' : '&') . 'page=';

$str = '';
if ($cur_page > 1) {
    $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(1)\" class=\"pg_page pg_start\">처음</a>" . PHP_EOL;
} else {
    $str .= "<span class=\"pg_start\">처음</span>" . PHP_EOL;
}

$start_page = max(1, $cur_page - floor($write_pages / 2));
$end_page = min($total_page, $start_page + $write_pages - 1);

if ($end_page - $start_page < $write_pages - 1) {
    $start_page = max(1, $end_page - $write_pages + 1);
}

if ($cur_page > 1) {
    $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(" . ($cur_page - 1) . ")\" class=\"pg_page pg_prev\">이전</a>" . PHP_EOL;
} else {
    $str .= "<span class=\"pg_prev\">이전</span>" . PHP_EOL;
}

if ($total_page > 1) {
    for ($k = $start_page; $k <= $end_page; $k++) {
        if ($cur_page != $k) {
            $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage($k)\" class=\"pg_page\">$k<span class=\"sound_only\">페이지</span></a>" . PHP_EOL;
        } else {
            $str .= "<span class=\"sound_only\">열린</span><strong class=\"pg_current\">$k</strong><span class=\"sound_only\">페이지</span>" . PHP_EOL;
        }
    }
}

if ($cur_page < $total_page) {
    $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(" . ($cur_page + 1) . ")\" class=\"pg_page pg_next\">다음</a>" . PHP_EOL;
} else {
    $str .= "<span class=\"pg_next\">다음</span>" . PHP_EOL;
}

if ($cur_page < $total_page) {
    $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage($total_page)\" class=\"pg_page pg_end\">맨끝</a>" . PHP_EOL;
} else {
    $str .= "<span class=\"pg_end\">맨끝</span>" . PHP_EOL;
}


echo "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
?>
