<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents orderDetail">
  <div id="sod_fin">

    <!-- 주문 완료 { -->
    <div id="orderComplete">
      <div class="container">
        <p class="od-cmp_tit"><span>주문완료</span> 되었습니다.</p>
        <div class="od-cmp-info">
          <ul>
            <li>
              <p class="lt-txt">주문번호</p>
              <p class="rt-txt"><?php echo $od_id; ?></p>
            </li>
            <li>
              <p class="lt-txt">배송지</p>
              <p class="rt-txt"><?php echo get_text(sprintf("(%s)", $od['zip']).' '.print_address($od['addr1'], $od['addr2'], $od['addr3'], $od['addr_jibeon'])); ?></p>
            </li>
            <li>
              <p class="lt-txt">결제방식</p>
              <p class="rt-txt"><?php echo ($easy_pay_name ? $easy_pay_name.'('.$od['paymethod'].')' : $od['paymethod']); ?></p>
            </li>
            <li>
              <p class="lt-txt">결제금액</p>
              <p class="rt-txt"><?php echo display_price2($stotal['useprice']); ?></p>
            </li>
          </ul>
        </div>
        <div class="od-cmp_btns">
          <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiry.php" class="ui-btn stWhite detail-btn">주문내역 확인</a>
          <a href="<?php echo BV_MURL; ?>" class="ui-btn stBlack shopping-btn">쇼핑 계속하기</a>
        </div>
        <p class="od-comp-t">주문하신 내역은 마이페이지 > 주문조회에서 확인하실 수 있습니다.</p>
      </div>
    </div>
    <!-- } 주문 완료 -->

    <div id="sod_fin_list" class="bottomBlank">
      <div class="order-list-wr">
        <div class="container">
          <div class="cp-cart order">
            <!-- loop -->
            <?php
            $st_count1 = $st_count2 = $st_cancel_price = 0;
            $custom_cancel = false;

            $sql = " select * from shop_cart where od_id = '$od_id' group by gs_id order by index_no ";
            $result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++) {
              $rw = get_order($row['od_no']);
              $gs = unserialize($rw['od_goods']);

              $hash = md5($rw['gs_id'].$rw['od_no'].$rw['od_id']);
              $dlcomp = explode('|', trim($rw['delivery']));
              $href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

              unset($it_name);
              $it_options = mobile_print_complete_options($row['gs_id'], $row['od_id']);
              if($it_options){
                $it_name = '<div class="li_name_od">'.$it_options.'</div>';
              }

              $li_btn = '';
              if($rw['dan'] == 5) {
                if(is_null_time($rw['user_date']))
                  $li_btn .= '<a href="javascript:final_confirm(\''.$hash.'\');" class="btn_ssmall red">구매확정</a>'.PHP_EOL;
                $li_btn .= '<a href="'.BV_MSHOP_URL.'/orderreview.php?gs_id='.$rw['gs_id'].'" onclick="win_open(this, \'winorderreview\');return false;" class="btn_ssmall bx-white">구매후기</a>'.PHP_EOL;
              }

              if($dlcomp[1] && $rw['delivery_no']) {
                $li_btn .= get_delivery_inquiry($rw['delivery'], $rw['delivery_no'], 'btn_ssmall bx-white');
              }

              if($li_btn)
                $li_btn = '<div class="li_btn">'.$li_btn.'</div>';
            ?>
            <div class="cp-cart-item">

              <div class="order-info">
                <div class="order-info-box">
                  <p class="order-date"><?php echo date("Y.m.d", strtotime($rw['od_time'])); ?></p>
                </div>
                <div class="order-num-box">
                  <p class="text">주문번호</p>
                  <p class="num"><?php echo $rw['od_id']; ?></p>
                  <span class="tag <?php echo $gw_status[$rw['dan']] == '배송완료'?'on':'off'; ?>"><?php echo $gw_status[$rw['dan']]; ?></span>
                </div>
              </div>

              <div class="cp-cart-body">
                <div class="thumb round60">
                  <img src="<?php echo get_it_image_url($rw['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>">
                </div>
                <div class="content">
                  <a href="<?php echo $href; ?>" class="name"><?php echo get_text($gs['gname']); ?></a>
                  <div class="info">
                    <div class="set">
                      <p><?php echo number_format($rw['sum_qty']); ?>개</p>
                      <?php if($row['ct_option'] != get_text($gs['gname'])){ ?>
                      <p><?php echo $row['ct_option']; ?></p>
                      <?php } ?>
                    </div>
                    <p class="price"><?php echo number_format($rw['goods_price']); ?>원</p>
                  </div>
                </div>
              </div>

            </div>
            <!-- loop -->
            <?php
              $st_count1++;
              if(in_array($rw['dan'], array('1','2','3')))
                $st_count2++;

              $st_cancel_price += $rw['cancel_price'];
            }

            // 주문상태가 배송중 이전 단계이면 고객 취소 가능
            if($st_count1 > 0 && $st_count1 == $st_count2)
              $custom_cancel = true;
            ?>
          </div>
        </div>
      </div>
    </div>

    <div id="sod_fin_pay" class="bottomBlank">
      <div class="container">
        <div class="arcodianBtn od-top active">
          <button type="button" class="ui-btn od-toggle-btn">
            <span class="od-tit">주문총액</span>
          </button>
        </div>
        <div class="od-ct">
          <ul class="prc-tot">
            <li>
              <span class="lt-txt">총 상품금액</span>
              <span class="rt-txt"><?php echo display_price($stotal['useprice']); ?></span>
            </li>
            <li>
              <span class="lt-txt">포인트 사용</span>
              <span class="rt-txt"></span>
            </li>
            <li>
              <span class="lt-txt">포인트 적립</span>
              <span class="rt-txt"></span>
            </li>
            <li class="rst">
              <span class="lt-txt">최종 결제금액</span>
              <span class="rt-txt"><?php echo display_price($stotal['useprice']); ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div id="sod_fin_pay_method" class="bottomBlank">
      <div class="container">
        <div class="arcodianBtn od-top active">
          <button type="button" class="ui-btn od-toggle-btn">
            <span class="od-tit">결제정보</span>
          </button>
        </div>
        <div class="od-ct">
          <ul class="prc-tot wl330">
            <li>
              <span class="lt-txt">결제방식</span>
              <span class="rt-txt"><?php echo ($easy_pay_name ? $easy_pay_name.'('.$od['paymethod'].')' : $od['paymethod']); ?></span>
            </li>
            <?php
            if(!is_null_time($od['receipt_time'])) {
            ?>
            <li>
              <span class="lt-txt">결제일시</span>
              <span class="rt-txt"><?php echo $od['receipt_time']; ?></span>
            </li>
            <?php
            }
            // 승인번호, 휴대폰번호, 거래번호
            if($app_no_subj) {
            ?>
            <li>
              <span class="lt-txt"><?php echo $app_no_subj; ?></span>
              <span class="rt-txt"><?php echo $app_no; ?></span>
            </li>
            <?php
            }

            // 계좌정보
            if($disp_bank) {
            ?>
            <li>
              <span class="lt-txt">입금자명</span>
              <span class="rt-txt"><?php echo get_text($od['deposit_name']); ?></span>
            </li>
            <li>
              <span class="lt-txt">입금계좌</span>
              <span class="rt-txt"><?php echo get_text($od['bank']); ?></span>
            </li>
            <?php
            }

            if($disp_receipt) {
            ?>
            <li>
              <span class="lt-txt">영수증</span>
              <span class="rt-txt">
                <?php
                if($od['paymethod'] == '휴대폰')
                {
                  if($od['od_pg'] == 'lg') {
                    require_once BV_SHOP_PATH.'/settle_lg.inc.php';
                    $LGD_TID      = $od['od_tno'];
                    $LGD_MERTKEY  = $default['de_lg_mid'];
                    $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                    $hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
                  } else if($od['od_pg'] == 'inicis') {
                    $hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
                  } else if($od['od_pg'] == 'kcp') {
                    $hp_receipt_script = 'window.open(\''.BV_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$stotal['useprice'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
                  }
                ?>
                <a href="javascript:;" onclick="<?php echo $hp_receipt_script; ?>" class="btn_small">영수증 출력</a>
                <?php
                }

                if($od['paymethod'] == '신용카드' || $od['paymethod'] == '삼성페이')
                {
                  if($od['od_pg'] == 'lg') {
                    require_once BV_SHOP_PATH.'/settle_lg.inc.php';
                    $LGD_TID      = $od['od_tno'];
                    $LGD_MERTKEY  = $default['de_lg_mid'];
                    $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                    $card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
                  } else if($od['od_pg'] == 'inicis') {
                    $card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
                  } else if($od['od_pg'] == 'kcp') {
                    $card_receipt_script = 'window.open(\''.BV_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$stotal['useprice'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
                  }
                ?>
                <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>" class="btn_small">영수증 출력</a>
                <?php
                }

                if($od['paymethod'] == 'KAKAOPAY')
                {
                  $card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
                ?>
                <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>" class="btn_small">영수증 출력</a>
                <?php
                }
                ?>
              </span>
            </li>
            <?php
            }

            // 현금영수증 발급을 사용하는 경우에만
            if($default['de_taxsave_use']) {
              // 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
              if(!is_null_time($od['receipt_time']) && ($od['paymethod'] == '무통장' || $od['paymethod'] == '계좌이체' || $od['paymethod'] == '가상계좌')) {
            ?>
            <li>
              <span class="lt-txt">현금영수증</span>
              <span class="rt-txt">
                <?php
                if($od['od_cash'])
                {
                  if($od['od_pg'] == 'lg') {
                    require_once BV_SHOP_PATH.'/settle_lg.inc.php';

                    switch($od['paymethod']) {
                      case '계좌이체':
                        $trade_type = 'BANK';
                        break;
                      case '가상계좌':
                        $trade_type = 'CAS';
                        break;
                      default:
                        $trade_type = 'CR';
                        break;
                    }
                    $cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
                  } else if($od['od_pg'] == 'inicis') {
                    $cash = unserialize($od['od_cash_info']);
                    $cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
                  } else if($od['od_pg'] == 'kcp') {
                    require_once BV_SHOP_PATH.'/settle_kcp.inc.php';

                    $cash = unserialize($od['od_cash_info']);
                    $cash_receipt_script = 'window.open(\''.BV_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
                  }
                ?>
                  <a href="javascript:;" onclick="<?php echo $cash_receipt_script; ?>" class="ui-btn stBlack sizeS round25">현금영수증 확인하기</a>
                <?php
                }
                else {
                ?>
                  <a href="javascript:;" onclick="window.open('<?php echo BV_MSHOP_URL; ?>/taxsave.php?od_id=<?php echo $od_id; ?>', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');" class="ui-btn stBlack sizeS round25">현금영수증 발급하기</a>
                <?php } ?>
              </span>
            </li>
            <?php
              }
            }
            ?>
          </ul>
        </div>
      </div>
    </div>

    <div id="sod_fin_orderer" style="display: none;">
      <div class="container">
        <div class="arcodianBtn od-top active">
          <button type="button" class="ui-btn od-toggle-btn">
            <span class="od-tit">주문정보</span>
          </button>
        </div>
        <div class="od-ct">
          <ul class="prc-tot wl330">
            <li>
              <span class="lt-txt">이름</span>
              <span class="rt-txt"><?php echo get_text($od['name']); ?></span>
            </li>
            <li>
              <span class="lt-txt">전화번호</span>
              <span class="rt-txt"><?php echo get_text($od['telephone']); ?></span>
            </li>
            <li>
              <span class="lt-txt">핸드폰</span>
              <span class="rt-txt"><?php echo get_text($od['cellphone']); ?></span>
            </li>
            <li>
              <span class="lt-txt">주 소</span>
              <span class="rt-txt"><?php echo get_text(sprintf("(%s)", $od['zip']).' '.print_address($od['addr1'], $od['addr2'], $od['addr3'], $od['addr_jibeon'])); ?></span>
            </li>
            <li>
              <span class="lt-txt">이메일</span>
              <span class="rt-txt"><?php echo get_text($od['email']); ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div id="sod_fin_receiver">
      <div class="container">
        <div class="arcodianBtn od-top active">
          <button type="button" class="ui-btn od-toggle-btn">
            <span class="od-tit">배송정보</span>
          </button>
        </div>
        <div class="od-ct">
          <ul class="prc-tot wl330">
            <li>
              <span class="lt-txt">이름</span>
              <span class="rt-txt"><?php echo get_text($od['b_name']); ?></span>
            </li>
            <li>
              <span class="lt-txt">전화번호</span>
              <span class="rt-txt"><?php echo get_text($od['b_telephone']); ?></span>
            </li>
            <li>
              <span class="lt-txt">핸드폰</span>
              <span class="rt-txt"><?php echo get_text($od['b_cellphone']); ?></span>
            </li>
            <li>
              <span class="lt-txt">주 소</span>
              <span class="rt-txt"><?php echo get_text(sprintf("(%s)", $od['b_zip']).' '.print_address($od['b_addr1'], $od['b_addr2'], $od['b_addr3'], $od['b_addr_jibeon'])); ?></span>
            </li>
            <?php if($od['memo']) { ?>
            <li>
              <span class="lt-txt">배송메모</span>
              <span class="rt-txt"><?php echo conv_content($od['memo'], 0); ?></span>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="cp-btnbar__btns">
      <div class="container <?php echo $st_cancel_price == 0 && $custom_cancel ? '':'oneBtn'; ?>">
        <a href="<?php echo BV_MSHOP_URL; ?>/orderinquiry.php" class="ui-btn round stWhite">목록</a>
        <?php
        // 취소한 내역이 없다면
        if($st_cancel_price == 0 && $custom_cancel) {
        ?>
        <!-- <button type="button" onclick="document.getElementById('sod_fin_cancelfrm').style.display='block';" class="ui-btn round stBlack">주문 취소하기</button> -->
        <button type="button" class="ui-btn round stBlack order-cancel-btn">주문 취소하기</button>
      </div>
      <?php } ?>
    </div>

    <?php
    // 취소한 내역이 없다면
    if($st_cancel_price == 0 && $custom_cancel) {
    ?>
    <!-- <section id="sod_fin_cancel">
      <h2>주문취소</h2>
      <button type="button" onclick="document.getElementById('sod_fin_cancelfrm').style.display='block';" class="btn_medium wset">주문 취소하기</button>

      <div id="sod_fin_cancelfrm">
        <form method="post" action="<?php echo BV_MSHOP_URL; ?>/orderinquirycancel.php" onsubmit="return fcancel_check(this);">
        <input type="hidden" name="od_id"  value="<?php echo $od_id; ?>">
        <input type="hidden" name="token"  value="<?php echo $token; ?>">
        <label for="cancel_memo">취소사유</label>
        <input type="text" name="cancel_memo" id="cancel_memo" required class="frm_input required" maxlength="100">
        <input type="submit" value="확인" class="btn_small">
        </form>
      </div>
    </section> -->

    <div class="popup type01" id="sod_fin_cancelfrm">
      <div class="pop-inner">
        <div class="pop-top">
          <p class="tit">취소 사유</p>
        </div>
        <div class="pop-content">
          <form method="post" action="<?php echo BV_MSHOP_URL; ?>/orderinquirycancel.php" onsubmit="return fcancel_check(this);">
            <input type="hidden" name="od_id"  value="<?php echo $od_id; ?>">
            <input type="hidden" name="token"  value="<?php echo $token; ?>">
            <!-- <label for="cancel_memo">취소사유</label>
            <input type="text" name="cancel_memo" id="cancel_memo" required class="frm_input required" maxlength="100">
            <input type="submit" value="확인" class="btn_small"> -->
            <div class="form-row">
              <div class="form-head">
                <p class="title">취소 사유<b>*</b></p>
              </div>
              <div class="form-body input-button">
                <input type="text" name="cancel_memo" id="cancel_memo" required class="frm-input" maxlength="100" placeholder="취소사유를 입력해주세요.">
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
    <?php } ?>

    <!-- <section id="sod_fin_list">
          <h2>주문하신 상품</h2>
          <ul id="sod_list_inq" class="sod_list">
          <?php
          $st_count1 = $st_count2 = $st_cancel_price = 0;
          $custom_cancel = false;

          $sql = " select * from shop_cart where od_id = '$od_id' group by gs_id order by index_no ";
          $result = sql_query($sql);
          for($i=0; $row=sql_fetch_array($result); $i++) {
            $rw = get_order($row['od_no']);
            $gs = unserialize($rw['od_goods']);

            $hash = md5($rw['gs_id'].$rw['od_no'].$rw['od_id']);
            $dlcomp = explode('|', trim($rw['delivery']));
            $href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

            unset($it_name);
            $it_options = mobile_print_complete_options($row['gs_id'], $row['od_id']);
            if($it_options){
              $it_name = '<div class="li_name_od">'.$it_options.'</div>';
            }

            $li_btn = '';
            if($rw['dan'] == 5) {
              if(is_null_time($rw['user_date']))
                $li_btn .= '<a href="javascript:final_confirm(\''.$hash.'\');" class="btn_ssmall red">구매확정</a>'.PHP_EOL;
              $li_btn .= '<a href="'.BV_MSHOP_URL.'/orderreview.php?gs_id='.$rw['gs_id'].'" onclick="win_open(this, \'winorderreview\');return false;" class="btn_ssmall bx-white">구매후기</a>'.PHP_EOL;
            }

            if($dlcomp[1] && $rw['delivery_no']) {
              $li_btn .= get_delivery_inquiry($rw['delivery'], $rw['delivery_no'], 'btn_ssmall bx-white');
            }

            if($li_btn)
              $li_btn = '<div class="li_btn">'.$li_btn.'</div>';
            ?>
            <li class="sod_li">
                      <div class="li_opt"><a href="<?php echo $href; ?>"><?php echo get_text($gs['gname']); ?></a></div>
              <?php echo $it_name; ?>
              <?php echo $li_btn; ?>
                      <div class="li_prqty">
                          <span class="prqty_price li_prqty_sp"><span>상품금액 </span><?php echo number_format($rw['goods_price']); ?></span>
                          <span class="prqty_qty li_prqty_sp"><span>수량 </span><?php echo number_format($rw['sum_qty']); ?></span>
                          <span class="prqty_sc li_prqty_sp"><span>배송비 </span><?php echo number_format($rw['baesong_price']); ?></span>
                          <span class="prqty_stat li_prqty_sp"><span>상태 </span><?php echo $gw_status[$rw['dan']]; ?></span>
                      </div>
                      <div class="li_total" style="padding-left:60px;height:auto !important;height:50px;min-height:50px;">
                          <a href="<?php echo $href; ?>" class="total_img"><?php echo get_od_image($rw['od_id'], $gs['simg1'], 50, 50); ?></a>
                          <span class="total_price total_span"><span>결제금액 </span><?php echo number_format($rw['use_price']); ?></span>
                          <span class="total_point total_span"><span>적립포인트 </span><?php echo number_format($rw['sum_point']); ?></span>
                      </div>
              <?php if($dlcomp[0] && $rw['delivery_no']) { ?>
              <div class="li_dvr">
                <strong class="fc_107">배송정보</strong>
                <?php echo $dlcomp[0]; ?>(송장번호 : <?php echo $rw['delivery_no']; ?>)
              </div>
              <?php } ?>
              </li>
              <?php
          $st_count1++;
          if(in_array($rw['dan'], array('1','2','3')))
            $st_count2++;

          $st_cancel_price += $rw['cancel_price'];
        }

        // 주문상태가 배송중 이전 단계이면 고객 취소 가능
        if($st_count1 > 0 && $st_count1 == $st_count2)
          $custom_cancel = true;
        ?>
        </ul>

        <dl id="sod_bsk_tot">
            <dt class="sod_bsk_dvr"><span>주문총액</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['price']); ?></strong></dd>

            <?php if($stotal['coupon']) { ?>
            <dt class="sod_bsk_dvr"><span>쿠폰할인</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['coupon']); ?></strong></dd>
            <?php } ?>

            <?php if($stotal['usepoint']) { ?>
            <dt class="sod_bsk_dvr"><span>포인트결제</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_point($stotal['usepoint']); ?></strong></dd>
            <?php } ?>

            <?php if($stotal['baesong']) { ?>
            <dt class="sod_bsk_dvr"><span>배송비</span></dt>
            <dd class="sod_bsk_dvr"><strong><?php echo display_price($stotal['baesong']); ?></strong></dd>
            <?php } ?>

            <dt class="sod_bsk_cnt"><span>총계</span></dt>
            <dd class="sod_bsk_cnt"><strong><?php echo display_price($stotal['useprice']); ?></strong></dd>

            <dt class="sod_bsk_point"><span>포인트적립</span></dt>
            <dd class="sod_bsk_point"><strong><?php echo display_point($stotal['point']); ?></strong></dd>
        </dl>
    </section> -->

    <!-- <section id="sod_fin_pay">
      <h3 class="anc_tit">결제정보</h3>
      <div class="odf_tbl">
        <table>
        <colgroup>
          <col class="w70">
          <col>
        </colgroup>
        <tbody>
        <tr>
          <th scope="row">주문번호</th>
          <td><?php echo $od_id; ?></td>
        </tr>
        <tr>
          <th scope="row">주문일시</th>
          <td><?php echo $od['od_time']; ?></td>
        </tr>
        <tr>
          <th scope="row">결제방식</th>
          <td><?php echo ($easy_pay_name ? $easy_pay_name.'('.$od['paymethod'].')' : $od['paymethod']); ?></td>
        </tr>
        <tr>
          <th scope="row">결제금액</th>
          <td><?php echo display_price($stotal['useprice']); ?></td>
        </tr>
        <?php
        if(!is_null_time($od['receipt_time'])) {
        ?>
        <tr>
          <th scope="row">결제일시</th>
          <td><?php echo $od['receipt_time']; ?></td>
        </tr>
        <?php
        }

        // 승인번호, 휴대폰번호, 거래번호
        if($app_no_subj) {
        ?>
        <tr>
          <th scope="row"><?php echo $app_no_subj; ?></th>
          <td><?php echo $app_no; ?></td>
        </tr>
        <?php
        }

        // 계좌정보
        if($disp_bank) {
        ?>
        <tr>
          <th scope="row">입금자명</th>
          <td><?php echo get_text($od['deposit_name']); ?></td>
        </tr>
        <tr>
          <th scope="row">입금계좌</th>
          <td><?php echo get_text($od['bank']); ?></td>
        </tr>
        <?php
        }

        if($disp_receipt) {
        ?>
        <tr>
          <th scope="row">영수증</th>
          <td>
            <?php
            if($od['paymethod'] == '휴대폰')
            {
              if($od['od_pg'] == 'lg') {
                require_once BV_SHOP_PATH.'/settle_lg.inc.php';
                $LGD_TID      = $od['od_tno'];
                $LGD_MERTKEY  = $default['de_lg_mid'];
                $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                $hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
              } else if($od['od_pg'] == 'inicis') {
                $hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
              } else if($od['od_pg'] == 'kcp') {
                $hp_receipt_script = 'window.open(\''.BV_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$stotal['useprice'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
              }
            ?>
            <a href="javascript:;" onclick="<?php echo $hp_receipt_script; ?>" class="btn_small">영수증 출력</a>
            <?php
            }

            if($od['paymethod'] == '신용카드' || $od['paymethod'] == '삼성페이')
            {
              if($od['od_pg'] == 'lg') {
                require_once BV_SHOP_PATH.'/settle_lg.inc.php';
                $LGD_TID      = $od['od_tno'];
                $LGD_MERTKEY  = $default['de_lg_mid'];
                $LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

                $card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
              } else if($od['od_pg'] == 'inicis') {
                $card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
              } else if($od['od_pg'] == 'kcp') {
                $card_receipt_script = 'window.open(\''.BV_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$stotal['useprice'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
              }
            ?>
            <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>" class="btn_small">영수증 출력</a>
            <?php
            }

            if($od['paymethod'] == 'KAKAOPAY')
            {
              $card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
            ?>
            <a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>" class="btn_small">영수증 출력</a>
            <?php
            }
            ?>
          </td>
        </tr>
        <?php
        }

        // 현금영수증 발급을 사용하는 경우에만
        if($default['de_taxsave_use']) {
          // 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
          if(!is_null_time($od['receipt_time']) && ($od['paymethod'] == '무통장' || $od['paymethod'] == '계좌이체' || $od['paymethod'] == '가상계좌')) {
        ?>
        <tr>
          <th scope="row">현금영수증</th>
          <td>
          <?php
          if($od['od_cash'])
          {
            if($od['od_pg'] == 'lg') {
              require_once BV_SHOP_PATH.'/settle_lg.inc.php';

              switch($od['paymethod']) {
                case '계좌이체':
                  $trade_type = 'BANK';
                  break;
                case '가상계좌':
                  $trade_type = 'CAS';
                  break;
                default:
                  $trade_type = 'CR';
                  break;
              }
              $cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
            } else if($od['od_pg'] == 'inicis') {
              $cash = unserialize($od['od_cash_info']);
              $cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
            } else if($od['od_pg'] == 'kcp') {
              require_once BV_SHOP_PATH.'/settle_kcp.inc.php';

              $cash = unserialize($od['od_cash_info']);
              $cash_receipt_script = 'window.open(\''.BV_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
            }
          ?>
            <a href="javascript:;" onclick="<?php echo $cash_receipt_script; ?>" class="btn_small">현금영수증 확인하기</a>
          <?php
          }
          else {
          ?>
            <a href="javascript:;" onclick="window.open('<?php echo BV_MSHOP_URL; ?>/taxsave.php?od_id=<?php echo $od_id; ?>', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');" class="btn_small">현금영수증 발급하기</a>
          <?php } ?>
          </td>
        </tr>
        <?php
          }
        }
        ?>
        </tbody>
        </table>
      </div>
    </section> -->

    <!-- <section id="sod_fin_orderer">
      <h3 class="anc_tit">주문하신 분</h3>
      <div class="odf_tbl">
        <table>
        <colgroup>
          <col class="w70">
          <col>
        </colgroup>
        <tbody>
        <tr>
          <th scope="row">이 름</th>
          <td><?php echo get_text($od['name']); ?></td>
        </tr>
        <tr>
          <th scope="row">전화번호</th>
          <td><?php echo get_text($od['telephone']); ?></td>
        </tr>
        <tr>
          <th scope="row">핸드폰</th>
          <td><?php echo get_text($od['cellphone']); ?></td>
        </tr>
        <tr>
          <th scope="row">주 소</th>
          <td><?php echo get_text(sprintf("(%s)", $od['zip']).' '.print_address($od['addr1'], $od['addr2'], $od['addr3'], $od['addr_jibeon'])); ?></td>
        </tr>
        <tr>
          <th scope="row">E-mail</th>
          <td><?php echo get_text($od['email']); ?></td>
        </tr>
        </tbody>
        </table>
      </div>
    </section> -->

    <!-- <section id="sod_fin_receiver">
      <h3 class="anc_tit">받으시는 분</h3>
      <div class="odf_tbl">
        <table>
        <colgroup>
          <col class="w70">
          <col>
        </colgroup>
        <tbody>
        <tr>
          <th scope="row">이 름</th>
          <td><?php echo get_text($od['b_name']); ?></td>
        </tr>
        <tr>
          <th scope="row">전화번호</th>
          <td><?php echo get_text($od['b_telephone']); ?></td>
        </tr>
        <tr>
          <th scope="row">핸드폰</th>
          <td><?php echo get_text($od['b_cellphone']); ?></td>
        </tr>
        <tr>
          <th scope="row">주 소</th>
          <td><?php echo get_text(sprintf("(%s)", $od['b_zip']).' '.print_address($od['b_addr1'], $od['b_addr2'], $od['b_addr3'], $od['b_addr_jibeon'])); ?></td>
        </tr>
        <?php if($od['memo']) { ?>
        <tr>
          <th scope="row">전하실 말씀</th>
          <td><?php echo conv_content($od['memo'], 0); ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
      </div>
    </section> -->

  </div>
</div>

<script>
const popUp = () => {
  let popBtn = $('.order-cancel-btn'); // 팝업 버튼
  let popLayer = $('#sod_fin_cancelfrm'); // 팝업 레이어
  let popDim = $('.popDim'); // 팝업 배경
  let popClose = popLayer.find('.close'); // 팝업 닫기 버튼

  popBtn.on('click',function(){
    popDim.show();
    popLayer.fadeIn(200);
  });

  popClose.on('click',function(){
    popDim.hide();
    popLayer.hide();
  });
}

function fcancel_check(f)
{
    if(!confirm("주문을 정말 취소하시겠습니까?"))
        return false;

    var memo = f.cancel_memo.value;
    if(memo == "") {
        alert("취소사유를 입력해 주십시오.");
        return false;
    }

    return true;
}

popUp();
</script>
