<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가

function reviewImg($index_no) {
  $sql = " SELECT index_no, thumbnail FROM shop_goods_review_img WHERE review_id = '{$index_no}' ORDER BY index_no ASC ";
  $res  = sql_query($sql);
  $reviewImgArr = array();
  while ($reviewRow = sql_fetch_array($res)) {
    $reviewImgArr[] = $reviewRow;
  }

  return $reviewImgArr;
}

function reviewTotalImg($gs_id) {
  // 최대 30개 이미지만 노출 처리 이미지 노출 갯수 변경 가능
  $limit = 30;
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE gs_id = '{$gs_id}' ORDER BY index_no DESC ";
  $sql .= " LIMIT {$limit} "; 
  $res  = sql_query($sql);
  $reviewImgArr = array();
  while ($reviewRow = sql_fetch_array($res)) {
    $reviewImgArr[] = $reviewRow;
  }

  return $reviewImgArr;
}

function reviewOptionCheck($od_no) {
  $sql = " SELECT * FROM shop_cart WHERE od_no = '{$od_no}' ";
  $res  = sql_fetch($sql);

  $rw = get_order($res['od_no']);
  $gs = unserialize($rw['od_goods']);

  $optionArr = array();
  if($res['ct_option'] != get_text($gs['gname'])){
    
    $optionArr = explode("/",$res['ct_option']);

  }
  
  return $optionArr;
}

function reviewGoodOption($index_no) {
  $sql = " SELECT opt_subject FROM shop_goods WHERE index_no = '{$index_no}' ";
  $res  = sql_fetch($sql);

  $optionArr = explode(",",$res['opt_subject']);

  return $optionArr;
}

function reviewImgCheck($review_id, $step) {
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE review_id = '{$review_id}' AND step = '{$step}' ";
  $res  = sql_fetch($sql);

  return $res['thumbnail'];
}

function reviewImgDelete($review_id) {
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE review_id = '{$review_id}' ";
  $res  = sql_query($sql);
  while ($reviewRow = sql_fetch_array($res)) {
    $upl_dir = BV_DATA_PATH."/review";
    $reviewImgUrl = $upl_dir."/".$reviewRow['thumbnail'];
    unlink($reviewImgUrl);
  }

  $deleteSql = " DELETE FROM shop_goods_review_img WHERE review_id = '{$review_id}' ";
  sql_query($deleteSql);
}

function get_paging_popup($write_pages, $cur_page, $total_page, $url, $add="") {
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

  return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
}