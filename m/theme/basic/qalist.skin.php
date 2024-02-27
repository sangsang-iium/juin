<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="sit_qa_list">
  <div class="iq-list">
    <?php echo mobile_goods_qa("Q&A", $itemqa_count, $gs_id); ?>
  </div>
</div>