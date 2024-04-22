<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js" integrity="sha512-NQfB/bDaB8kaSXF8E77JjhHG5PM6XVRxvHzkZiwl3ddWCEPBa23T76MuWSwAJdMGJnmQqM0VeY9kFszsrBEFrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div id="sit_coupon">
  <div class="cp-cart coupon-item">
    <div class="cp-cart-item">
      <div class="cp-cart-body">
        <div class="thumb round60">
          <img src="<?php echo get_it_image_url($gs['index_no'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
        </div>
        <div class="content">
          <p class="name"><?php echo get_text($gs['gname']); ?></p>
          <div class="info">
            <p class="price"><?php echo mobile_price($gs['index_no']); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="coupon_cau">
    이 상품 구매시, 사용하실 수 있는 할인쿠폰입니다.<br>
    다운로드 받은 후 주문시 사용하세요!<br>
    발행된 쿠폰은 마이페이지에서 확인 할 수 있습니다.
  </div>


  <div class="cp-list-wrap">
    <?php
    if(!$total_count) {
      echo "<p class=\"empty_list\">사용가능한 쿠폰이 없습니다.</p>";
    } else {
    ?>
    <div class="cp-list">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++) {
        $cp_id = $row['cp_id'];

        $str  = "";
        // $str .= "<div>&#183; <strong>".get_text($row['cp_subject'])."</strong></div>";

        // 혜택
        if(!$row['cp_sale_type']) {
          if($row['cp_sale_amt_max'] > 0)
            $cp_sale_amt_max = "&nbsp;<span class=\"unit\">(최대 ".display_price($row['cp_sale_amt_max']).")</span>";
          else
            $cp_sale_amt_max = "";

          // $str .= $row['cp_sale_percent']. '% 할인' . $cp_sale_amt_max;
          $str .= "<p class=\"rate\">".$row['cp_sale_percent']."<span class=\"unit\">%</span>".$cp_sale_amt_max."</p>";
        } else {
          // $str .= display_price($row['cp_sale_amt']);
          $str .= "<p class=\"rate\">".number_format($row['cp_sale_amt'])."<span class=\"unit\">원</span></p>";
        }

        // 사용가능대상
        $str .= "<div class='text01'>".$gw_usepart[$row['cp_use_part']]."</div>";

        // 최대금액
        if($row['cp_low_amt'] > 0) {
          $str .= "<div class='text01'>".display_price($row['cp_low_amt'])." 이상 구매시</div>";
        }

        // 쿠폰발행 기간
        $str .= "<div class='text01'>사용기간 : ";
        if($row['cp_type'] != '3') {
          if($row['cp_pub_sdate'] == '9999999999') $cp_pub_sdate = '';
          else $cp_pub_sdate = $row['cp_pub_sdate'];

          if($row['cp_pub_edate'] == '9999999999') $cp_pub_edate = '';
          else $cp_pub_edate = $row['cp_pub_edate'];

          if($row['cp_pub_sdate'] == '9999999999' && $row['cp_pub_edate'] == '9999999999')
            $str .= "무제한";
          else
            $str .= $cp_pub_sdate." ~ ".$cp_pub_edate;

          // 쿠폰발행 요일
          if($row['cp_type'] == '1') {
            $str .= "&nbsp;(".$row['cp_week_day'].")";
          }
        } else {
          $str .= "생일 (".$row['cp_pub_sday']."일 전 ~ ".$row['cp_pub_eday']."일 이후까지)";
        }
        $str .= "</div>";



        $s_upd = "<button type=\"button\" onclick=\"post_update2('".BV_MSHOP_URL."/pop_coupon_update.php', '$cp_id');\" class=\"ui-btn cp-coupon-download\"><i class=\"icon\"></i><p class=\"txt\">다운받기</p></button>";
      ?>
      <div class="cp-list-item on <?php //echo $_GET['sca'] == 1 ? '':'on' ?>">
        <div class="coupon-lt">
          <p class="cp-name"><?php echo get_text($row['cp_subject']); ?></p>
        <?php echo $str; ?>
        </div>
        <div class="coupon-rt">
          <div class="btn-flex">
            <?php echo $s_upd; ?>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
	<?php
	}
	?>

	<?php echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?gs_id='.$gs_id.'&page='); ?>
</div>

<script>
function callDatas (popid, rqurl, rqm, rqd, shouldOpenPopup = false) {
  let result = "";

  if(rqm == "GET") {
    $.get(rqurl, rqd)
    .done(function(data, status) {
      result = data;

      if (shouldOpenPopup) {
        $(popid).find(".pop-content-in").html(data);
        $(".popDim").show().css({"z-index":"560"});
        $(popid).fadeIn(200).addClass("on")
      }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.error('Request failed:', textStatus, errorThrown);
    });
  } else if(rqm == "POST") {
    $.post(rqurl, rqd)
    .done(function(data, status) {
      result = data;

      if (shouldOpenPopup) {
        $(popid).find(".pop-content-in").html(data);
        $(".popDim").show().css({"z-index":"560"});
        $(popid).fadeIn(200).addClass("on")
      }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.error('Request failed:', textStatus, errorThrown);
    });
  }

  return result;
}
function post_update2(action_url, val) {
//	var f = document.fpost;
//	f.cp_id.value = val;
//	f.action = action_url;
//	f.submit();

        $.ajax({
            type:"POST",
            url:"./pop_coupon_update_ajax.php",
            data: {
                "cp_id": val,
            },
            dataType:"text",
            success:function(result){
                console.log(result);
				if(result=="ok")
					{
						alert("쿠폰발행이 정상적으로 처리 되었습니다\\n\\n발급 된 쿠폰은 마이페이서 확인 가능합니다");
						cupondownladbtnevt();
						return false;
					}

            }
        });


}

function cupondownladbtnevt(){
	  const gsId = "<?php echo $gs_id;?>";

    const popId = "#coupon-popup";
    const reqPathUrl = "./pop_coupon.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId };

    callDatas(popId, reqPathUrl, reqMethod, reqData, true);
}
</script>

<form name="fpost" method="post">
<input type="hidden" name="gs_id" value="<?php echo $gs_id; ?>">
<input type="hidden" name="page"  value="<?php echo $page; ?>">
<input type="hidden" name="token" value="<?php echo $token; ?>">
<input type="hidden" name="cp_id">
</form>
