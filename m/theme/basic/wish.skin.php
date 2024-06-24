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
      <div class="txt-board-cnt">총 <span class="cnt"><?php echo number_format($wish_count1); ?></span>건</div>

      <div class="ws_wrap">
        <div class="used-prod_list">
        <?php
        if($wish_count1 == 0){
            echo '<p class="empty_list">\'중고장터\' 보관함이 비었습니다.</p>';
        } else {
            while($row=sql_fetch_array($result1)){
                if($row['m_img']){
                    $thumb = BV_DATA_URL.'/used/'.$row['m_img'];
                } else {
                    $thumb = '/src/img/used/t-item_thumb1.jpg';
                }
                $gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
                
                echo '<div class="used-item">';
                echo '<a href="/m/used/view.php?no='.$row['no'].'" class="used-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['title'].'"></a>';
                echo '<div class="used-item_txtBox">';
                echo '<a href="/m/used/view.php?no='.$row['no'].'" class="tRow2 title"><span class="cate">['.$row['category'].']</span><span class="subj">'.$row['title'].'</span></a>';
                echo '<p class="writer"><span>'.getMemberName($row['mb_id']).'</span><span>'.getUsedAddress($row['address']).'</span></p>';
                echo '<ul class="inf"><li><p class="prc">'.number_format($row['price']).'<span class="won">원</span></p></li>';
                if($row['gubun']){
                    echo '<li><span class="status ing">'.$gubun_status[0].'</span></li></ul>';
                } else if($row['status']=='1'){
                    echo '<li><span class="status resv">'.$gubun_status[1].'</span></li></ul>';
                } else if($row['status']=='2'){
                    echo '<li><span class="status end">'.$gubun_status[1].'</span></li></ul>';
                } else {
                    echo '<li><span class="status ing">'.$gubun_status[1].'</span></li></ul>';
                }
                echo '<ul class="extra">';
                echo '<li class="hit"><span class="icon"><img src="/src/img/used/icon_hit.png" alt="조회수"></span><span class="text">'.$row['hit'].'</span></li>';
                echo '<li class="like"><span class="icon"><img src="/src/img/used/icon_like.png" alt="좋아요수"></span><span class="text">'.getUsedGoodCount($row['no']).'</span></li>';
                echo '<li class="reply"><span class="icon"><img src="/src/img/used/icon_chat.png" alt="채팅수"></span><span class="text">'.getUsedChatCount($row['no']).'</span></li>';
                echo '</ul>';
                echo '<button type="button" class="ui-btn wish-btn on used-wish-btn" data-no="'.$row['no'].'" title="관심상품 삭제하기"></button>';
                echo '</div></div>';
            }
        }
        ?>
        </div>
      </div>
    </div>
    <!-- } Tab.중고장터 -->

    <!-- Tab.매장 { -->
    <div id="mp-wish_store" class="mp-wish_ct">
      <div class="txt-board-cnt">총 <span class="cnt"><?php echo number_format($wish_count2); ?></span>건</div>

      <div class="ws_wrap">
        <div class="store-prod_list">
        <?php
        if($wish_count2 == 0){
            echo '<p class="empty_list">\'매장\' 보관함이 비었습니다.</p>';
        } else {
            while($row=sql_fetch_array($result2)){
                if($row['ju_mimg']){
                    $thumb = BV_DATA_URL.'/member/'.$row['ju_mimg'];
                } else {
                    $thumb = '/src/img/store/t-store_thumb2.jpg';
                }
                
                echo '<div class="store-item">';
                echo '<a href="/m/store/view.php?no='.$row['index_no'].'" class="store-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['ju_restaurant'].'"></a>';
                echo '<div class="store-item_txtBox">';
                echo '<a href="/m/store/view.php?no='.$row['index_no'].'" class="tRow2 title"><span class="cate">['.$row['ju_cate'].']</span><span class="subj">'.$row['ju_restaurant'].'</span></a>';
                echo '<p class="address">'.$row['ju_addr_full'].'</p>';
                echo '<a href="tel:'.$row['ju_tel'].'" class="tel">'.$row['ju_tel'].'</a>';
                echo '<ul class="extra">';
                echo '<li class="hit"><span class="icon"><img src="/src/img/store/icon_hit.png" alt="조회수"></span><span class="text">'.$row['ju_hit'].'</span></li>';
                echo '<li class="like"><span class="icon"><img src="/src/img/store/icon_like.png" alt="좋아요수"></span><span class="text">'.getStoreGoodCount($row['index_no']).'</span></li>';
                echo '</ul>';
                echo '<button type="button" class="ui-btn wish-btn on store-wish-btn" data-no="'.$row['index_no'].'" title="관심상품 제거하기"></button>';
                echo '</div></div>';        
            }
        }
        ?>
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

//중고장터 좋아요 삭제
let wish_count1 = Number(<?php echo $wish_count1 ?>);
$(".used-wish-btn").click(function(){
    var el = $(this);
    var no = el.data("no");
    var inout = 'out';
    $.post("/m/used/ajax.used_good.php", {no:no, inout:inout}, function(obj){
        el.parents(".used-item").remove();
        wish_count1--;
        $(".cnt").eq(1).html(wish_count1);
        if(wish_count1==0){
            $(".used-prod_list").html('<p class="empty_list">\'중고장터\' 보관함이 비었습니다.</p>');
        }
    });
});

//매장 좋아요 삭제
let wish_count2 = Number(<?php echo $wish_count2 ?>);
$(".store-wish-btn").click(function(){
    var el = $(this);
    var no = el.data("no");
    var inout = 'out';
    $.post("/m/store/ajax.store_good.php", {no:no, inout:inout}, function(obj){
        el.parents(".store-item").remove();
        wish_count2--;
        $(".cnt").eq(2).html(wish_count2);
        if(wish_count2==0){
            $(".store-prod_list").html('<p class="empty_list">\'매장\' 보관함이 비었습니다.</p>');
        }
    });
});
//-->
</script>
