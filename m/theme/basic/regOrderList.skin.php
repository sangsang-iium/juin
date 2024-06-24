<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents orderList">
  <div class="order-list-wr">
    <div id="smb_order" class="reg-order-list">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++){
        echo '<div class="bottomBlank cp-orderWrap">'.PHP_EOL;
        echo '<div class="container">'.PHP_EOL;

        $sql = " select * from shop_cart where od_id = '$row[od_id]' ";
        $sql.= " group by gs_id order by io_type asc, index_no asc ";
        $res = sql_query($sql);
        for($k=0; $ct=sql_fetch_array($res); $k++) {
          $rw = get_order($ct['od_no'],'*','shop_order_reg');
          $gs = unserialize($rw['od_goods']);

          $href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

          $dlcomp = explode('|', trim($rw['delivery']));

          $delivery_str = '';
          if($dlcomp[0] && $rw['delivery_no']) {
            $delivery_str = get_text($dlcomp[0]).' '.get_text($rw['delivery_no']);
          }

          $uid = md5($rw['od_id'].$rw['od_time'].$rw['od_ip']);

          // 배송기간 추가 _20240624_SY
          $start_date        = $rw['od_begin_date'];
          $delivery_days     = explode(",",$rw['od_wday']);
          $interval_weeks    = $rw['od_week'];
          $total_deliveries  = $rw['od_reg_total_num'];
          $weekday_names     = ['일', '월', '화', '수', '목', '금', '토'];
          
          // 시작일을 타임스탬프로 변환
          $current_date = strtotime($start_date);

          // 초기화
          $occurrences = 0;
          $last_date = null;

          // 총 12번의 배송을 계산
          while ($occurrences < $total_deliveries) {
            foreach ($delivery_days as $day) {
                // 현재 날짜의 요일 인덱스를 구함
                $current_weekday = date('w', $current_date);
        
                // 목표 요일의 인덱스를 구함
                $target_weekday = array_search($day, $weekday_names);
        
                // 목표 요일까지 남은 일수를 계산
                $days_to_add = ($target_weekday + 7 - $current_weekday) % 7;
        
                // 날짜를 목표 요일로 이동
                $current_date = strtotime("+$days_to_add days", $current_date);
        
                // 해당 날짜를 기록
                $last_date = $current_date;
                $occurrences++;
                if ($occurrences >= $total_deliveries) {
                    break 2; // 바깥쪽 반복문도 빠져나옴
                }
            }
            // interval_weeks 주를 더함
            if($interval_weeks > 1) {
              $range_week = $interval_weeks-1;
            } else {
              $range_week = $interval_weeks;
            }
            $current_date = strtotime("+$range_week weeks", $current_date);
          }
          
          // 종료 날짜 출력
          $end_date = date('Y-m-d', $last_date);

          if($rw['od_reg_total_num'] > 0 && $rw['od_begin_date'] != '0000-00-00') {
            $wday = str_replace(",","/", $rw['od_wday']); 
            $delivery_date = $start_date." ~ ".$end_date;
          } else {
            $wday = "";
            $delivery_date = "";
          }
        

         $dan_process =  $row['dan'];
          if($k == 0) {
      ?>
      <div class="order-info">
        <div class="order-info-box">
          <p class="order-date"><?php echo date("Y.m.d", strtotime($rw['od_time'])); ?></p>
          <!-- <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>&list=Y&#38;reg_yn=<?php echo $ct['reg_yn'] ?>" class="view">
            <span>상세보기</span>
            <span><img src="/src/img/order-view-right.png" alt="상세보기"></span>
          </a> -->
        </div>
        <div class="order-num-box">
          <p class="text">주문번호</p>
          <p class="num"><?php echo $rw['od_id']; ?></p>
        </div>
      </div>
      <?php } ?>
      <div class="cp-orderItem">
        <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>&list=Y&#38;reg_yn=<?php echo $ct['reg_yn'] ?>" class="thumb round60">
        <!-- <a href="javascript:void(0)" class="thumb round60"> -->
          <img src="<?php echo get_it_image_url($ct['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>">
        </a>
        <div class="content">
          <span class="tag <?php echo $gw_status[$rw['dan']] == '배송중'?'on':'off'; ?>"><?php echo $gw_status[$rw['dan']]; ?></span>
          <!-- <a href="<?php echo $href; ?>" class="name"> -->
          <a href="javascript:void(0)" class="name">
            <?php echo get_text($gs['gname']); ?>
          </a>
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
        <!-- <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn" data-gs-id="<?php echo $ct['gs_id'];?>" data-od-no="<?php echo $ct['od_no'] ?>">상품후기 작성</button> -->
      </div>
      <?php } ?>
      <!-- 정기결제 배송 정보 { -->
      <div class="reg-info-date-box">
        <div class="reg-info-wr">
          <div class="reg-info-left">
            <p>배송요일</p>
            <input type="text" class="frm-input" value="<?php echo $wday; ?>" readonly>
          </div>
          <div class="reg-info-right">
            <p>배송기간</p>
            <input type="text" class="frm-input" value="<?php echo $delivery_date; ?>" readonly>
          </div>
        </div>
      </div>
      </div>
      <!-- } 정기결제 배송 정보 -->
      <?php
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
    console.log(odId)
    $.ajax({
         url: "./orderinquiry_update.php",
        type: "POST",
        data: { "odId": odId,"evt":"return-money" },
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
//교환  20240527 박원주
document.querySelectorAll(".change-product").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;
    console.log(odId)
    $.ajax({
      url: "./orderinquiry_update.php",
        type: "POST",
        data: { "odId": odId,"evt":"change-product" },
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
//반품 20240527 박원주
document.querySelectorAll(".return-product").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const odId = event.currentTarget.dataset.odId;
    console.log(odId)
    $.ajax({
      url: "./orderinquiry_update.php",
        type: "POST",
        data: { "odId": odId,"evt":"return-product" },
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