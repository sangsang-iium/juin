<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가

class review {
  public function reviewImg($index_no) {
    $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE review_id = '{$index_no}' ORDER BY index_no ASC ";
      $res  = sql_query($sql);
      $reviewImgArr = array();
      while ($reviewRow = sql_fetch_array($res)) {
        $reviewImgArr[] = $reviewRow;
      }

      return $reviewImgArr;
  }
}