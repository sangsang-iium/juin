<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<!-- style 추가 _20240624_SY -->
<style>
  .dlcomp { margin-left: 5px;}
</style>

<div id="contents" class="sub-contents orderList">
  <div class="order-list-wr">
    <div id="smb_order">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++){
        echo '<div class="bottomBlank cp-orderWrap">'.PHP_EOL;
        echo '<div class="container">'.PHP_EOL;

        $org_od_id = $row[od_id];
        $parts = explode('_', $row[od_id]);
        $row[od_id] = $parts[0];
        $sql = " select * from shop_cart where od_id = '$row[od_id]' ";
        $sql.= " group by gs_id order by io_type asc, index_no asc ";
        $res = sql_query($sql);
        for($k=0; $ct=sql_fetch_array($res); $k++) {
          if($ct['reg_yn'] == 1){
            $rw = get_order2($ct['od_no']);
          } else {
            $rw = get_order($ct['od_no']);
          }
          $convertGoods = str_replace("'", '"', $rw['od_goods']);

          $gs = unserialize($convertGoods);

          if($ct['raffle'] == 1) {
            $gs['gname'] = $gs['goods_name'];
          }

          $href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

          $dlcomp = explode('|', trim($rw['delivery']));

          $delivery_str = '';
          if($dlcomp[0] && $rw['delivery_no']) {
            $delivery_str = get_text($dlcomp[0]).' '.get_text($rw['delivery_no']);
          }

         $uid = md5($rw['od_id'].$rw['od_time'].$rw['od_ip']);
         $dan_process =  $row['dan'];
          if($k == 0) {
      ?>
      <div class="order-info">
        <div class="order-info-box">
          <p class="order-date"><?php echo date("Y.m.d", strtotime($rw['od_time'])); ?></p>
          <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>&list=Y&#38;reg_yn=<?php echo $ct['reg_yn'] ?>" class="view">
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
        <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>&list=Y&#38;reg_yn=<?php echo $ct['reg_yn'] ?>" class="thumb round60">
          <?php if($ct['raffle'] == 1) { ?>
            <?php echo get_raffle_img($gs['simg1']) ?>
          <?php } else { ?>
            <img src="<?php echo get_it_image_url($ct['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>">
          <?php } ?>
        </a>
        <div class="content">
          <span class="tag <?php echo $gw_status[$rw['dan']] == '배송중'?'on':'off'; ?>"><?php echo $gw_status[$rw['dan']]; ?></span>
          <!-- 운송장 추가 _20240624_SY -->
          <?php if(!empty($rw['delivery']) && !empty($rw['delivery_no'])) { ?>
            <a href="<?php echo $dlcomp[1].$rw['delivery_no'] ?>" target="_blank" class="dlcomp">
              <span class="tag off"><?php echo $dlcomp[0] ?></span>
            </a>
          <?php } ?>
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

        <?php if($ct['raffle'] != 1) { ?>
        <div class="ord-btn-wr">
          <!-- <a href="" class="ui-btn ord-review__btn iq-wbtn">상품후기 작성</a> -->
          <!-- 상품후기 작성 버튼 조건문 추가 _20240624_SY -->
          <?php if(in_array($dan_process, array('5','7','8','9'))) { ?>
          <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn" data-gs-id="<?php echo $ct['gs_id'];?>" data-od-no="<?php echo $ct['od_no'] ?>">상품후기 작성</button>
          <?php } ?>

          <button class="ui-btn ord-review__btn iq-wbtn reoder-btn" data-od-id="<?php echo $rw['od_id'];?>">재주문</button>
          <?php
            // 환불 버튼 생성  20240527 박원주
            if($dan_process=='3')
            {
              ?>
                <button class="ui-btn ord-review__btn iq-wbtn return-money" data-od-id="<?php echo $rw['od_id'];?>">취소신청</button>
              <?php
            }
          ?>

          <?php
            // 환불 버튼 생성  20240527 박원주
            if($dan_process=='5')
            {
              ?>
                <button class="ui-btn ord-review__btn iq-wbtn return-product" data-od-id="<?php echo $rw['od_id'];?>">반품신청</button>
                <!-- <button class="ui-btn ord-review__btn iq-wbtn change-product" data-od-id="<?php echo $rw['od_id'];?>">교환</button> -->
              <?php
            }
          ?>
        </div>
        <?php } ?>
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
      <p class="tit">리뷰 </p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>

<div id="return-popup2" class="popup type01 add-popup">
      <div class="pop-inner">
        <div class="pop-top">
          <p class="tit return-popup2-title1">취소 사유</p>
        </div>
        <div class="pop-content">
          <form method="post" action="<?php echo BV_MSHOP_URL; ?>/orderinquiry_evt.php" onsubmit="return fcancel_check(this);">
            <input type="hidden" name="odId" id="order_send"  value="<?php echo $od_id; ?>">
            <input type="hidden" name="evt" id="evt"  value="<?php echo $od_id; ?>">
            <div class="form-row">
              <div class="form-head">
                <p class="title return-popup2-title2">취소 사유<b>*</b></p>
              </div>
              <div class="form-body input-button">
                <input type="text" name="return_memo" id="return_memo" required class="frm-input" maxlength="100" placeholder="사유를 입력해주세요.">
                <input type="submit" value="확인" class="ui-btn st3">
              </div>
            </div>

          </form>
        </div>
        <div class="pop-btm">
          <button type="button" class="ui-btn round stBlack close">취소</button>
        </div>
      </div>
</div>



<script type="module">
import * as f from '/src/js/function.js';

// 리뷰 작성 팝업
document.querySelectorAll(".rv-write-btn").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const gsId = event.currentTarget.dataset.gsId;
    const odNo = event.currentTarget.dataset.odNo;
    const popId = "#review-popup";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId, od_no: odNo };

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

//환불  20240527 박원주
document.querySelectorAll(".return-money").forEach(btn => {

  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;

    $("#order_send").prop('value',odId);
    $("#evt").prop('value',"return-money");
    $(".return-popup2-title1,.return-popup2-title2").text("환불사유");
    const popId ="#return-popup2";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { odId: odId};
    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });
  // btn.addEventListener("click", function(event) {
  //   const odId = event.currentTarget.dataset.odId;
  //   console.log(odId)
  //   $.ajax({
  //        url: "./orderinquiry_update.php",
  //       type: "POST",
  //       data: { "odId": odId,"evt":"return-money" },
  //       dataType: "json",
  //       async: false,
  //       cache: false,
  //       success: function(data, textStatus) {
  //         document.location.href = data.url;
  //         return false;
  //       }
  //   });

  // });
});
//교환  20240527 박원주
document.querySelectorAll(".change-product").forEach(btn => {
  // btn.addEventListener("click", function(event) {
  //   const odId = event.currentTarget.dataset.odId;
  //   console.log(odId)
  //   $.ajax({
  //     url: "./orderinquiry_update.php",
  //       type: "POST",
  //       data: { "odId": odId,"evt":"change-product" },
  //       dataType: "json",
  //       async: false,
  //       cache: false,
  //       success: function(data, textStatus) {
  //         document.location.href = data.url;
  //         return false;
  //       }
  //   });

  // });

  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;

    $("#order_send").prop('value',odId);
    $("#evt").prop('value',"change-product");
    $(".return-popup2-title1,.return-popup2-title2").text("교환사유");
    const popId ="#return-popup2";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { odId: odId};
    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });
});
//반품 20240527 박원주
document.querySelectorAll(".return-product").forEach(btn => {
  // btn.addEventListener("click", function(event) {
  //   const odId = event.currentTarget.dataset.odId;
  //   console.log(odId)
  //   $.ajax({
  //     url: "./orderinquiry_update.php",
  //       type: "POST",
  //       data: { "odId": odId,"evt":"return-product" },
  //       dataType: "json",
  //       async: false,
  //       cache: false,
  //       success: function(data, textStatus) {
  //         document.location.href = data.url;
  //         return false;
  //       }
  //   });

  // });
  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;

    $("#order_send").prop('value',odId);
    $("#evt").prop('value',"return-product");
    $(".return-popup2-title1,.return-popup2-title2").text("반품사유");
    const popId ="#return-popup2";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { odId: odId};
    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });
});

</script>