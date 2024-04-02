<?php
if(!defined('_BLUEVATION_')) exit;
?>

<script src="<?php echo BV_JS_URL; ?>/shop.js"></script>

<form name="fbuyform" method="post">
<input type="hidden" name="gs_id[]" value="<?php echo $index_no; ?>">
<input type="hidden" id="it_price" value="<?php echo get_sale_price($index_no); ?>">
<input type="hidden" name="ca_id" value="<?php echo $gs['ca_id']; ?>">
<input type="hidden" name="sw_direct">

<p class="tit_navi marb15"><?php echo $navi; ?></p>
<div class="vi_info">
	<div class="vi_img_bx" style="width:<?php echo $default['de_item_medium_wpx']; ?>px">
		<?php if($is_social_ing) { include_once(BV_THEME_PATH.'/time.skin.php'); } ?>
		<?php if($is_social_end) { ?><div class="t_social"><?php echo $is_social_txt; ?></div><?php } ?>

		<div class="bimg">
			<?php echo get_it_image($index_no, $gs['simg2'], $default['de_item_medium_wpx'], $default['de_item_medium_hpx'], "id='big'"); ?>
		</div>
		<div class="simg_li">
			<ul>
				<?php
				for($i=2; $i<=6; $i++) {
					$it_image = $gs['simg'.$i];
					if(!$it_image) continue;

					$thumbnails = get_it_image_url($index_no, $it_image, $default['de_item_medium_wpx'], $default['de_item_medium_hpx']);
				?>
				<li><img src="<?php echo $thumbnails; ?>" onmouseover="document.all['big'].src='<?php echo $thumbnails; ?>'"></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="vi_txt_bx">
		<h2 class="tit">
			<?php echo $gs['gname']; ?>
			<?php if(is_admin()) { ?><a href="<?php echo BV_ADMIN_URL; ?>/goods.php?code=form&w=u&gs_id=<?php echo $index_no; ?>" target="_blank" class="btn_small red">수정</a><?php } ?>
			<?php if($gs['explan']) { ?>
			<p class="stxt"><?php echo $gs['explan']; ?></p>
			<?php } ?>
		</h2>
		<?php if(!$is_only) { ?>
		<div class="price_bx">
			<?php if(!$is_pr_msg && !$is_buy_only && !$is_soldout && $gs['normal_price']) { ?>
			<dl>
				<dt>시중가격</dt>
				<dd class="f_price"><?php echo display_price2($gs['normal_price']); ?></dd>
			</dl>
			<?php } ?>
			<dl>
				<dt class="padt5">판매가격</dt>
				<dd class="price"><?php echo get_price($index_no); ?></dd>
			</dl>
			<?php if(is_partner($member['id']) && $config['pf_payment_yes']) { ?>
			<dl>
				<dt class="padt5">판매수익</dt>
				<dd class="pay"><?php echo display_price2(get_payment($index_no)); ?></dd>
			</dl>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="vi_txt_li">
			<dl>
				<dt>상품코드</dt>
				<dd><?php echo $gs['gcode']; ?></dd>
			</dl>
			<?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout && $gpoint) { ?>
			<dl>
				<dt>포인트</dt>
				<dd><?php echo $gpoint; ?></dd>
			</dl>
			<?php } ?>
			<?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout && $cp_used) { ?>
			<dl>
				<dt>쿠폰발급</dt>
				<dd><?php echo $cp_btn; ?></dd>
			</dl>
			<?php } ?>
			<?php if($gs['maker']) { ?>
			<dl>
				<dt>제조사</dt>
				<dd><?php echo $gs['maker']; ?></dd>
			</dl>
			<?php } ?>
			<?php if($gs['origin']) { ?>
			<dl>
				<dt>원산지</dt>
				<dd><?php echo $gs['origin']; ?></dd>
			</dl>
			<?php } ?>
			<?php if($gs['brand_nm']) { ?>
			<dl>
				<dt>브랜드</dt>
				<dd><?php echo $gs['brand_nm']; ?></dd>
			</dl>
			<?php } ?>
			<?php if($gs['model']) { ?>
			<dl>
				<dt>모델명</dt>
				<dd><?php echo $gs['model']; ?></dd>
			</dl>
			<?php } ?>
			<dl>
				<dt>배송비</dt>
				<dd><?php echo get_sendcost_amt(); ?></dd>
			</dl>
			<dl>
				<dt>배송가능지역</dt>
				<dd><?php echo $gs['zone']; ?> <?php echo $gs['zone_msg']; ?></dd>
			</dl>
			<dl>
				<dt>고객상품평</dt>
				<dd>상품평 : <?php echo $item_use_count; ?>건, 평점 : <img src="<?php echo BV_IMG_URL; ?>/sub/view_score_<?php echo $star_score; ?>.gif"></dd>
			</dl>
			<dl>
				<dt>상품URL 소셜 공유</dt>
				<dd><?php echo $sns_share_links; ?></dd>
			</dl>
			<?php if($gs['odr_min']) { ?>
			<dl>
				<dt>최소구매수량</dt>
				<dd><?php echo display_qty($gs['odr_min']); ?></dd>
			</dl>
			<?php } ?>
			<?php if($gs['odr_max']) { ?>
			<dl>
				<dt>최대구매수량</dt>
				<dd><?php echo display_qty($gs['odr_max']); ?></dd>
			</dl>
			<?php } ?>
		</div>

		<?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout) { ?>
		<?php if($option_item || $supply_item) { ?>
		<div class="vi_txt_li">
			<?php if($option_item) { ?>
			<dl>
				<dt>주문옵션</dt>
				<dd>아래옵션은 필수선택 옵션입니다</dd>
			</dl>
			<?php echo $option_item; ?>
			<?php } ?>

			<?php if($supply_item) { ?>
			<dl>
				<dt>추가구성</dt>
				<dd>추가구매를 원하시면 선택하세요</dd>
			</dl>
			<?php echo $supply_item; ?>
			<?php } ?>
		</div>
		<?php } ?>

		<!-- 선택된 옵션 시작 { -->
		<div id="option_set_list">
			<?php if(!$option_item) { ?>
			<ul id="option_set_added">
				<li class="sit_opt_list vi_txt_li">
					<dl>
						<input type="hidden" name="io_type[<?php echo $index_no; ?>][]" value="0">
						<input type="hidden" name="io_id[<?php echo $index_no; ?>][]" value="">
						<input type="hidden" name="io_value[<?php echo $index_no; ?>][]" value="<?php echo $gs['gname']; ?>">
						<input type="hidden" class="io_price" value="0">
						<input type="hidden" class="io_stock" value="<?php echo $gs['stock_qty']; ?>">
						<dt>
							<span class="sit_opt_subj">수량</span>
							<span class="sit_opt_prc"></span>
						</dt>
						<dd class="li_ea">
							<span>
								<button type="button" class="defbtn_minus">감소</button><input type="text" name="ct_qty[<?php echo $index_no; ?>][]" value="<?php echo $odr_min; ?>" class="inp_opt" title="수량설정" size="2"><button type="button" class="defbtn_plus">증가</button>
							</span>
							<span class="marl7">(재고수량 : <?php echo $gs['stock_mod'] ? display_qty($gs['stock_qty']) : '무제한'; ?>)</span>
						</dd>
					</dl>
				</li>
			</ul>
			<script>
			$(function() {
				price_calculate();
			});
			</script>
			<?php } ?>
		</div>
		<!-- } 선택된 옵션 끝 -->
		<div id="sit_tot_views" class="dn">
			<span class="fl">총 합계금액</span>
			<span id="sit_tot_price" class="prdc_price"></span>
		</div>
		<?php } ?>
		<?php if(!$is_pr_msg) { ?>
		<div class="vi_btn">
			<?php echo get_buy_button($script_msg, $index_no); ?>
		</div>
		<?php if($naverpay_button_js) { ?>
		<div class="naverpay-item"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
		<?php } ?>
		<?php } ?>
	</div>
</div>
</form>

<?php
$sql = " select b.*
		   from shop_goods_relation a left join shop_goods b ON (a.gs_id2=b.index_no)
		  where a.gs_id = '{$index_no}'
			and b.shop_state = '0'
			and b.isopen < 3 ";
$res = sql_query($sql);
$rel_count = sql_num_rows($res);
if($rel_count > 0) {
?>
<section class="vi_rel">
	<h3><span>현재상품과 연관된 상품</span></h3>
	<div<?php if($rel_count <= 5) { ?> class="ofh"<?php } ?>>
		<?php
		for($i=0; $row=sql_fetch_array($res); $i++) {
			$it_href = BV_SHOP_URL.'/view.php?index_no='.$row['index_no'];
			$it_image = get_it_image($row['index_no'], $row['simg1'], 174, 174);
			$it_name = cut_str($row['gname'], 100);
			$it_price = get_price($row['index_no']);
			$it_amount = get_sale_price($row['index_no']);
			$it_point = display_point($row['gpoint']);

			// (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
			$it_sprice = $sale = '';
			if($row['normal_price'] > $it_amount && !is_uncase($row['index_no'])) {
				$sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
				$sale = '<p class="sale">'.number_format($sett,0).'<span>%</span></p>';
				$it_sprice = display_price2($row['normal_price']);
			}
		?>
		<dl>
		<a href="<?php echo $it_href; ?>">
			<dt><?php echo $it_image; ?></dt>
			<dd class="pname"><?php echo $it_name; ?></dd>
			<dd class="price"><?php echo $it_sprice; ?><?php echo $it_price; ?></dd>
		</a>
		</dl>
		<?php } ?>
	</div>
	<?php if($rel_count > 5) { ?>
	<script>
	$(document).ready(function(){
		$('.vi_rel div').slick({
			autoplay: false,
			dots: false,
			arrows: true,
			infinite: false,
			slidesToShow: 5,
			slidesToScroll: 1
		});
	});
	</script>
	<?php } ?>
</section>
<?php } ?>

<section class="mart50">
	<a name="tab1"></a>
	<div class="vi_tab">
		<ul>
			<li onclick="javascript:pg_anchor('tab1')" class="on">상품정보</li>
			<li onclick="javascript:pg_anchor('tab2')">상품평</li>
			<li onclick="javascript:pg_anchor('tab3')">상품문의</li>
			<li onclick="javascript:pg_anchor('tab4')">배송/교환/반품안내</li>
		</ul>
	</div>

	<div class="ofh tac padt10 padb10">
		<?php echo get_view_thumbnail(conv_content($gs['memo'], 1), 1000); ?>
	</div>

	<?php
	if($gs['info_value']) {
		$info_data = unserialize(stripslashes($gs['info_value']));
		if(is_array($info_data)) {
			$gubun = $gs['info_gubun'];
			$info_array = $item_info[$gubun]['article'];
	?>
	<div class="mart20 marb30">
		<h2 class="anc_tit">전자상거래 등에서의 상품정보제공고시</h2>
		<div class="tbl_frm01 tbl_wrap">
			<table>
			<colgroup>
				<col width="25%">
				<col width="75%">
			</colgroup>
			<?php
			foreach($info_data as $key=>$val) {
				$ii_title = $info_array[$key][0];
				$ii_value = $val;
			?>
			<tr>
				<th scope="row"><?php echo $ii_title; ?></th>
				<td><?php echo $ii_value; ?></td>
			</tr>
			<?php } //foreach ?>
			</table>
		</div>
	</div>
	<?php
			} //array
		} //if
	?>
</section>

<section class="mart50">
	<a name="tab2"></a>
	<div class="vi_tab">
		<ul>
			<li onclick="javascript:pg_anchor('tab1')">상품정보</li>
			<li onclick="javascript:pg_anchor('tab2')" class="on">상품평</li>
			<li onclick="javascript:pg_anchor('tab3')">상품문의</li>
			<li onclick="javascript:pg_anchor('tab4')">배송/교환/반품안내</li>
		</ul>
	</div>
	<div class="mart15">
		<?php
		include_once(BV_THEME_PATH.'/view_user.skin.php');
		?>
	</div>
</section>

<section class="mart50">
	<a name="tab3"></a>
	<div class="vi_tab">
		<ul>
			<li onclick="javascript:pg_anchor('tab1')">상품정보</li>
			<li onclick="javascript:pg_anchor('tab2')">상품평</li>
			<li onclick="javascript:pg_anchor('tab3')" class="on">상품문의</li>
			<li onclick="javascript:pg_anchor('tab4')">배송/교환/반품안내</li>
		</ul>
	</div>
	<div class="mart15 vi_qa">
		<?php
		include_once(BV_THEME_PATH.'/view_qa.skin.php');
		?>
	</div>
</section>

<section class="mart50">
	<a name="tab4"></a>
	<div class="vi_tab">
		<ul>
			<li onclick="javascript:pg_anchor('tab1')">상품정보</li>
			<li onclick="javascript:pg_anchor('tab2')">상품평</li>
			<li onclick="javascript:pg_anchor('tab3')">상품문의</li>
			<li onclick="javascript:pg_anchor('tab4')" class="on">배송/교환/반품안내</li>
		</ul>
	</div>
	<div class="mart15">
		<?php echo get_view_thumbnail(conv_content(get_policy_content($index_no), 1), 1000); ?>
	</div>
</section>

<script>
// 상품보관
function item_wish(f)
{
	f.action = "./wishupdate.php";
	f.submit();
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

	if($(".sit_opt_list").size() < 1) {
		alert("주문옵션을 선택해주시기 바랍니다.");
		return false;
	}

    var val, io_type, result = true;
    var sum_qty = 0;
	var min_qty = parseInt('<?php echo $odr_min; ?>');
	var max_qty = parseInt('<?php echo $odr_max; ?>');
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주세요.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주세요.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fbuyform_submit(sw_direct)
{
	var f = document.fbuyform;
	f.sw_direct.value = sw_direct;

	if(sw_direct == "cart") {
		f.sw_direct.value = 0;
	} else { // 바로구매
		f.sw_direct.value = 1;
	}

	if($(".sit_opt_list").size() < 1) {
		alert("주문옵션을 선택해주시기 바랍니다.");
		return;
	}

	var val, io_type, result = true;
	var sum_qty = 0;
	var min_qty = parseInt('<?php echo $odr_min; ?>');
	var max_qty = parseInt('<?php echo $odr_max; ?>');
	var $el_type = $("input[name^=io_type]");

	$("input[name^=ct_qty]").each(function(index) {
		val = $(this).val();

		if(val.length < 1) {
			alert("수량을 입력해 주세요.");
			result = false;
			return;
		}

		if(val.replace(/[0-9]/g, "").length > 0) {
			alert("수량은 숫자로 입력해 주세요.");
			result = false;
			return;
		}

		if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
			alert("수량은 1이상 입력해 주세요.");
			result = false;
			return;
		}

		io_type = $el_type.eq(index).val();
		if(io_type == "0")
			sum_qty += parseInt(val);
	});

	if(!result) {
		return;
	}

	if(min_qty > 0 && sum_qty < min_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주세요.");
		return;
	}

	if(max_qty > 0 && sum_qty > max_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주세요.");
		return;
	}

	f.action = "./cartupdate.php";
	f.submit();
}
</script>
