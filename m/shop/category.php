<?php
include_once("./_common.php");

$tb['title'] = '카테고리';
include_once("./_head.php");
?>

<div id="document">
  <!-- AllMenu { -->
  <div class="all-ct-wrap">
    <div class="all-ct">
      <div class="all-ct-left">
        <ul class="all-ct-depth1-list">
          <?php
          // category_depth 1~4까지 있음
            $cateHtml = category_depth('1');
            for ($i = 0; $i < count($cateHtml['html']); $i++) {
              echo $cateHtml['html'][$i];
            }
          ?>

        </ul>
      </div>
      <div class="all-ct-right">
        <!-- 2뎁스 메뉴 { -->
        <?php
          for ($i = 0; $i < count($cateHtml['cateArr']); $i++) {
        ?>
        <ul data-d1="<?php echo $cateHtml['cateArr'][$i] ?>" class="all-ct-depth2-list">
          <?php
            $cateHtml2 = category_depth('2', $cateHtml['cateArr'][$i]);
            for ($j = 0; $j < count($cateHtml2['cateArr']); $j++) {
          ?>
          <li>
            <?php echo $cateHtml2['html_head'][$j]; ?>
            <ul class="all-ct-depth3-list">
              <?php echo $cateHtml2['html'][$j]; ?>
            </ul>
          </li>
          <?php } ?>

        </ul>
        <?php } ?>

        <!-- } 2뎁스 메뉴 -->
      </div>
    </div>
  </div>
  <!-- } AllMenu -->
</div>

<?php
include_once("./tail.sub.php");
?>