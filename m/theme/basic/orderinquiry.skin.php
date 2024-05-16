<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents orderList">
  <div class="order-list-wr">
    <div id="smb_order">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++){
        echo '<div class="bottomBlank cp-orderWrap">'.PHP_EOL;
        echo '<div class="container">'.PHP_EOL;

        $sql = " select * from shop_cart where od_id = '$row[od_id]' ";
        $sql.= " group by gs_id order by io_type asc, index_no asc ";
        $res = sql_query($sql);
        for($k=0; $ct=sql_fetch_array($res); $k++) {
          $rw = get_order($ct['od_no']);
          $gs = unserialize($rw['od_goods']);

          $href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

          $dlcomp = explode('|', trim($rw['delivery']));

          $delivery_str = '';
          if($dlcomp[0] && $rw['delivery_no']) {
            $delivery_str = get_text($dlcomp[0]).' '.get_text($rw['delivery_no']);
          }

          $uid = md5($rw['od_id'].$rw['od_time'].$rw['od_ip']);

          if($k == 0) {
      ?>
      <div class="order-info">
        <div class="order-info-box">
          <p class="order-date"><?php echo date("Y.m.d", strtotime($rw['od_time'])); ?></p>
          <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>&list=Y" class="view">
            <span>상세보기</span>
            <span><img src="/src/img/order-view-right.png" alt="상세보기"></span>
          </a>
        </div>
        <div class="order-num-box">
          <p class="text">주문번호</p>
          <p class="num"><?php echo $rw['od_id']; ?></p>
        </div>
      </div>
      <?php } ?>
      <div class="cp-orderItem">
        <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>" class="thumb round60">
          <img src="<?php echo get_it_image_url($ct['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>">
        </a>
        <div class="content">
          <span class="tag <?php echo $gw_status[$rw['dan']] == '배송중'?'on':'off'; ?>"><?php echo $gw_status[$rw['dan']]; ?></span>
          <a href="<?php echo $href; ?>" class="name"><?php echo get_text($gs['gname']); ?></a>
          <div class="info">
            <div class="set">
              <p><?php echo $ct['ct_qty']; ?>개</p>
              <?php if($ct['ct_option'] != get_text($gs['gname'])){ ?>
              <p><?php echo $ct['ct_option']; ?></p>
              <?php } ?>
            </div>
            <p class="price"><?php echo display_price($rw['use_price']); ?></p>
          </div>
        </div>
        <!-- <a href="" class="ui-btn ord-review__btn iq-wbtn">상품후기 작성</a> -->
        <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn" data-gs-id="<?php echo $ct['gs_id'];?>">상품후기 작성</button>
        <button class="ui-btn ord-review__btn iq-wbtn reoder-btn" data-od-id="<?php echo $rw['od_id'];?>">재주문</button>
      </div>
      <?php
        }
        echo '</div>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
      }

      if($i == 0)
        echo '<div class="empty_list">주문 내역이 없습니다.</div>';
      ?>

    </div>

    <?php
      echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
    ?>
  </div>
</div>


<!-- review _20240313_SY -->

<div id="review-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">리뷰 작성</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>

<script type="module">
import * as f from '/src/js/function.js';

// 리뷰 작성 팝업
document.querySelectorAll(".rv-write-btn").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const gsId = event.currentTarget.dataset.gsId;
    const popId = "#review-popup";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });
});


document.querySelectorAll(".reoder-btn").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;
    $.ajax({
      url: "./reOrder.php",
        type: "POST",
        data: { "odId": odId },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
          document.location.href = data.url;
          return false;
        }
    });
    
  });
});
</script>