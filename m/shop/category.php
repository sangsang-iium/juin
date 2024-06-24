<?php
include_once("./_common.php");

$tb['title'] = '카테고리';
include_once("./_head.php");
?>

<div id="document">
  <!-- AllMenu { -->
  <div class="all-ct-wrap">
    <div class="container main_service">
      <div class="main-service_wrap">
        <a href="/m/used/list.php?menu=used" class="box box1">
          <div class="box_in">
            <p class="name">중고장터</p>
          </div>
        </a>
        <a href="/m/store/list.php?menu=store" class="box box2">
          <div class="box_in">
            <p class="name">회원사현황</p>
          </div>
        </a>
        <a href="/m/service/list.php?menu=service" class="box box3">
          <div class="box_in">
            <p class="name">제휴서비스</p>
          </div>
        </a>
      </div>
    </div>
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