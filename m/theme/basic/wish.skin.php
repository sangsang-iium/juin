<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents mpWish">
  <div id="sod_ws" class="container">
    <div class="cp-tab-menu2 col3 mp-wish_tab">
      <div class="inner">
        <button type="button" class="ui-btn tab-btn on" data-tab-id="mp-wish_prod">상품</button>
        <button type="button" class="ui-btn tab-btn" data-tab-id="mp-wish_used">중고장터</button>
        <button type="button" class="ui-btn tab-btn" data-tab-id="mp-wish_store">매장</button>
      </div>
    </div>
    <!-- Tab.상품(기본) : 기본기능으로 백엔드 개발안해도됨 { -->
    <div id="mp-wish_prod" class="mp-wish_ct">
      <div class="txt-board-cnt">총 <span class="cnt"><?php echo number_format($wish_count); ?></span>건</div>

      <form name="fwishlist" id="fwishlist" method="post">
        <input type="hidden" name="act" value="multi">
        <input type="hidden" name="sw_direct">

        <?php 
        if(!$wish_count) {
          echo "<p class=\"empty_list\">'상품' 보관함이 비었습니다.</p>";
        } else {
        ?>
        <div class="ws_wrap">
          <table>
          <tbody>
          <?php
          for($i=0; $row=sql_fetch_array($result); $i++) {
            $out_cd = '';
            $sql = " select count(*) as cnt from shop_goods_option where gs_id = '{$row['gs_id']}' and io_type = '0' ";
            $tmp = sql_fetch($sql);
            if($tmp['cnt'])
              $out_cd = 'no';

            if($row['price_msg']) {
              $out_cd = 'price_msg';
            }
          ?>
          <tr>
            <th>
              <?php if(is_soldout($row['gs_id'])) { ?>
              <span class="fc_red tx_small">품절</span>
              <?php } else { ?>
              <div class="frm-choice">
                <input type="checkbox" name="chk_gs_id[<?php echo $i;?>]" value="1" id="ct_chk_<?php echo $i;?>" onclick="out_cd_check(this, '<?php echo $out_cd;?>');">
                <label for="ct_chk_<?php echo $i;?>"></label>
              </div>
              <?php } ?>
              <input type="hidden" name="gs_id[<?php echo $i;?>]" value="<?php echo $row['gs_id'];?>">
              <input type="hidden" name="io_type[<?php echo $row['gs_id'];?>][0]" value="0">
              <input type="hidden" name="io_id[<?php echo $row['gs_id']; ?>][0]" value="">
              <input type="hidden" name="io_value[<?php echo $row['gs_id'];?>][0]" value="<?php echo $row['gname'];?>">
              <input type="hidden" name="ct_qty[<?php echo $row['gs_id'];?>][0]" value="1">
            </th>
            <td class="wish_img">
              <a href="<?php echo BV_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id'];?>" class="thumb round60">
                <img src="<?php echo get_it_image_url($row['gs_id'], $row['simg1'], 140, 140); ?>" alt="<?php echo get_text($row['gname']); ?>" class="fitCover">
              </a>
            </td>
            <td class="wish_info">
              <div class="wish_gname">
                <a href="<?php echo BV_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id'];?>" class="gname"><?php echo cut_str($row['gname'],60);?></a>
                <div class="gprc"><?php echo mobile_price($row['gs_id']);?></div>
              </div>
              <a href="<?php echo BV_MSHOP_URL; ?>/wishupdate.php?w=d&wi_id=<?php echo $row['wi_id'];?>" class="ui-btn wish_del">삭제</a>
            </td>
          </tr>
          <?php } ?>
          </tbody>
          </table>
        </div>

        <div class="btn_confirm">
          <button type="button" onclick="return fwishlist_check(document.fwishlist,'');" class="ui-btn round stBlack cart-btn">장바구니</button>
          <!-- <button type="button" onclick="return fwishlist_check(document.fwishlist,'direct_buy');" class="ui-btn round stWhite buy-btn">바로구매</button> -->
        </div>
        <?php } ?>

      </form>
    </div>
    <!-- } Tab.상품(기본) -->

    <!-- Tab.중고장터 { -->
    <div id="mp-wish_used" class="mp-wish_ct">
      <div class="txt-board-cnt">총 <span class="cnt">0</span>건</div>

      <div class="ws_wrap">
        <!-- 데이터가 없을 경우
        <p class="empty_list">'중고장터' 보관함이 비었습니다.</p> 
        -->
        <div class="used-prod_list">
          <div class="used-item">
            <a href="상세링크 연결" class="used-item_thumbBox">
              <img src="https://juinjang.kr/data/used/4/main_image.jpg" class="fitCover" alt="예쁜 반팔셔츠 실착 1회">
            </a>
            <div class="used-item_txtBox">
              <a href="상세링크 연결" class="tRow2 title">
                <span class="cate">[여성의류]</span><span class="subj">예쁜 반팔셔츠 실착 1회</span>
              </a>
              <p class="writer"><span>관리자</span><span>대전 대덕구 계족로</span></p>
              <ul class="inf">
                <li>
                  <p class="prc">35,000<span class="won">원</span></p>
                </li>
                <li><span class="status ing">판매중</span></li>
              </ul>
              <ul class="extra">
                <li class="hit">
                  <span class="icon">
                    <img src="/src/img/used/icon_hit.png" alt="조회수">
                  </span>
                  <span class="text">0</span>
                </li>
                <li class="like">
                  <span class="icon">
                    <img src="/src/img/used/icon_like.png" alt="좋아요수">
                  </span>
                  <span class="text">0</span>
                </li>
                <li class="reply">
                  <span class="icon">
                    <img src="/src/img/used/icon_chat.png" alt="채팅수">
                  </span>
                  <span class="text">0</span>
                </li>
              </ul>
              <button type="button" class="ui-btn wish-btn on" data-no="4" title="관심상품 등록하기"></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- } Tab.중고장터 -->

    <!-- Tab.매장 { -->
    <div id="mp-wish_store" class="mp-wish_ct">
      <div class="txt-board-cnt">총 <span class="cnt">0</span>건</div>

      <div class="ws_wrap">
        <!-- 데이터가 없을 경우
        <p class="empty_list">'매장' 보관함이 비었습니다.</p>
        -->
        <div class="store-prod_list">
          <div class="store-item">
            <a href="상세링크 연결" class="store-item_thumbBox">
              <img src="/src/img/store/t-store_thumb1.jpg" class="fitCover" alt="쥔장네 돈까스">
            </a>
            <div class="store-item_txtBox">
              <a href="./view.php" class="tRow2 title">
                <i class="recom"><img src="/src/img/store/recom_label.png" alt=""></i>
                <span class="cate">[한식]</span>
                <span class="subj">쥔장네 돈까스</span>
              </a>
              <p class="address">대전 유성구 동서대로656번길</p>
              <a href="tel:070-0000-0000" class="tel">070-0000-0000</a>
              <ul class="extra">
                <li class="hit">
                  <span class="icon">
                    <img src="/src/img/store/icon_hit.png" alt="조회수">
                  </span>
                  <span class="text">0</span>
                </li>
                <li class="like">
                  <span class="icon">
                    <img src="/src/img/store/icon_like.png" alt="좋아요수">
                  </span>
                  <span class="text">0</span>
                </li>
              </ul>
              <button type="button" class="ui-btn wish-btn on" title="관심상품 등록하기"></button>
            </div>
          </div>
          <div class="store-item">
            <a href="상세링크 연결" class="store-item_thumbBox">
              <img src="/src/img/store/t-store_thumb2.jpg" class="fitCover" alt="주인장 초밥">
            </a>
            <div class="store-item_txtBox">
              <a href="./view.php" class="tRow2 title">
                <span class="cate">[일식]</span>
                <span class="subj">주인장 초밥</span>
              </a>
              <p class="address">대전 유성구 동서대로656번길</p>
              <a href="tel:070-0000-0000" class="tel">070-0000-0000</a>
              <ul class="extra">
                <li class="hit">
                  <span class="icon">
                    <img src="/src/img/store/icon_hit.png" alt="조회수">
                  </span>
                  <span class="text">0</span>
                </li>
                <li class="like">
                  <span class="icon">
                    <img src="/src/img/store/icon_like.png" alt="좋아요수">
                  </span>
                  <span class="text">0</span>
                </li>
              </ul>
              <button type="button" class="ui-btn wish-btn on" title="관심상품 등록하기"></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- } Tab.매장 -->
  </div>
</div>

<script>
$(document).ready(function(){
  let wishTabId = "";
  $(".mp-wish_tab .tab-btn").on('click', function(){
    wishTabId = $(this).data('tab-id');

    $(this).addClass('on').siblings('.tab-btn').removeClass('on');
    $(".mp-wish_ct").hide();
    $(`#${wishTabId}`).show();
  });
});

<!--
function out_cd_check(fld, out_cd)
{
	if(out_cd == 'no'){
		alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
		fld.checked = false;
		return;
	}

	if(out_cd == 'price_msg'){
		alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
		fld.checked = false;
		return;
	}
}

function fwishlist_check(f, act)
{
	var k = 0;
	var length = f.elements.length;

	for(i=0; i<length; i++) {
		if(f.elements[i].checked) {
			k++;
		}
	}

	if(k == 0)
	{
		alert("상품을 하나 이상 체크 하십시오");
		return false;
	}

	if(act == "direct_buy")
	{
		f.sw_direct.value = 1;
	}
	else
	{
		f.sw_direct.value = 0;
	}

	f.action = "./cartupdate.php";
	f.submit();
}
//-->
</script>
