<?php
if(!defined('_BLUEVATION_')) exit;

if($w == "") {
	$gs['mb_id']		= 'admin';
	$gs['gcode']		= time();
	$gs['sc_type']		= 0; // 배송비 유형	0:공통설정, 1:무료배송, 2:조건부 무료배송, 3:유료배송
	$gs['sc_method']	= 0; // 배송비 결제	0:선불, 1:착불, 2:사용자선택
	$gs['stock_mod']	= 0;
	$gs['noti_qty']		= 999;
	$gs['simg_type']	= 0;
	$gs['isopen']		= 1;
	$gs['reg_yn']		= 2;
	$gs['notax']		= 1;
	$gs['ppay_type']	= 0;
	$gs['ppay_rate']	= 0;
	$gs['zone']			= '전국';


} else if($w == "u") {
	$gs = get_goods($gs_id);
    if(!$gs)
        alert("존재하지 않은 상품 입니다.");

	$readonly = " readonly style='background-color:#ddd;'";

	if(is_null_time($gs['sb_date'])) $gs['sb_date'] = '';
	if(is_null_time($gs['eb_date'])) $gs['eb_date'] = '';
}

if(isset($sel_ca1))			$qstr .= "&sel_ca1=$sel_ca1";
if(isset($sel_ca2))			$qstr .= "&sel_ca2=$sel_ca2";
if(isset($sel_ca3))			$qstr .= "&sel_ca3=$sel_ca3";
if(isset($sel_ca4))			$qstr .= "&sel_ca4=$sel_ca4";
if(isset($sel_ca5))			$qstr .= "&sel_ca5=$sel_ca5";
if(isset($q_date_field))	$qstr .= "&q_date_field=$q_date_field";
if(isset($q_brand))			$qstr .= "&q_brand=$q_brand";
if(isset($q_zone))			$qstr .= "&q_zone=$q_zone";
if(isset($q_stock_field))	$qstr .= "&q_stock_field=$q_stock_field";
if(isset($fr_stock))		$qstr .= "&fr_stock=$fr_stock";
if(isset($to_stock))		$qstr .= "&to_stock=$to_stock";
if(isset($q_price_field))	$qstr .= "&q_price_field=$q_price_field";
if(isset($fr_price))		$qstr .= "&fr_price=$fr_price";
if(isset($to_price))		$qstr .= "&to_price=$to_price";
if(isset($q_isopen))		$qstr .= "&q_isopen=$q_isopen";
if(isset($q_option))		$qstr .= "&q_option=$q_option";
if(isset($q_supply))		$qstr .= "&q_supply=$q_supply";
if(isset($q_notax))			$qstr .= "&q_notax=$q_notax";

include_once(BV_LIB_PATH.'/goodsinfo.lib.php');
include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$frm_submit = '<div class="btn_confirm">
    <input type="submit" value="저장" class="btn_large" accesskey="s">';
if($w == "u" && $bak) {
    $frm_submit .= PHP_EOL.'<a href="./goods.php?code='.$bak.$qstr.'&page='.$page.'" class="btn_large bx-white">목록</a>';
	$frm_submit .= '<a href="./goods.php?code=form" class="btn_large bx-red">추가</a>'.PHP_EOL;
}
$frm_submit .= '</div>';

// 임시저장 _20240612_SY
$frm_submit2 = '<div class="btn_confirm">
    <input type="submit" value="임시저장" class="btn_large" accesskey="s">';
if($w == "u" && $bak) {
    $frm_submit2 .= PHP_EOL.'<a href="./goods.php?code='.$bak.$qstr.'&page='.$page.'" class="btn_large bx-white">목록</a>';
	$frm_submit2 .= '<a href="./goods.php?code=form" class="btn_large bx-red">추가</a>'.PHP_EOL;
}
$frm_submit2 .= '</div>';

$pg_anchor = <<<EOF
<div class="tap_box mart20 marb20">
    <ul class="taps type3">
    <li><a href="#anc_sitfrm_ini">기본정보</a></li>
    <li><a href="#anc_sitfrm_cate">카테고리</a></li>
        <li><a href="#anc_sitfrm_option">옵션정보</a></li>
        <li><a href="#anc_sitfrm_cost">가격및재고</a></li>
        <!-- <li><a href="#anc_sitfrm_pay">가맹점수수료</a></li> -->
        <li><a href="#anc_sitfrm_sendcost">배송정보</a></li>
        <li><a href="#anc_sitfrm_compact">상품정보</a></li>
        <li><a href="#anc_sitfrm_relation">관련상품</a></li>
        <li><a href="#anc_sitfrm_img">상품이미지</a></li>
    </ul>
</div>
EOF;


// 정산방식 추가 _20240426_SY
// $normal_price = $gs['normal_price'];
$goods_price  = $gs['goods_price'];   // 판매가
$supply_price = $gs['supply_price'];  // 매입가

$income_per = ($supply_price / $goods_price) * 100;

?>

<script src="<?php echo BV_JS_URL; ?>/categoryform.js?ver=<?php echo BV_JS_VER; ?>"></script>

<form name="fregform" method="post" onsubmit="return fregform_submit(this)" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="gs_id" value="<?php echo $gs_id; ?>">
<input type="hidden" name="q1" value="<?php echo $qstr; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="bak" value="<?php echo $bak; ?>">
<input type="hidden" name="ca_id" value="">
<input type="hidden" name="ca_id2" value="">
<input type="hidden" name="ca_id3" value="">
<input type="hidden" name="in_type" value="">
<input type="hidden" name="in_per_type" value="">
<input type="hidden" name="in_price" value="">
<input type="hidden" name="in_per" value="" >
<style>
	.icon-plus {
  width: 47px;
  height: 47px;

  &.w25 {
    width: 25px;
    height: 25px;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;

    &:after {
      width: 18px;
      height: 4px;
      left: 4px;
      top: 11px;
    }

    &:before {
      width: 4px;
      height: 18px;
      left: 11px;
      top: 4px;
    }
  }

  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;

  position: relative;

  &.orange {
    background: #FD7901;
  }

  &.blue {
    background: #7c7c7d;
  }

  &:after, &:before {
    content: '';
    position: absolute;
    background: #FFF;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
  }

  &:after {
    width: 25px;
    height: 6px;
    left: 11px;
    top: 20px;
  }

  &:before {
    width: 6px;
    height: 25px;
    left: 20px;
    top: 11px;
  }
}
.icon-miners {
  width: 47px;
  height: 47px;
	margin-left: 6px;

  &.w25 {
    width: 25px;
    height: 25px;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;

    &:after {
      width: 18px;
      height: 4px;
      left: 4px;
      top: 11px;
    }

    /* &:before {
      width: 4px;
      height: 18px;
      left: 11px;
      top: 4px;
    } */
  }

  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;

  position: relative;

  &.orange {
    background: #FD7901;
  }

  &.blue {
    background: #7c7c7d;
  }

  &:after, &:before {
    content: '';
    position: absolute;
    background: #FFF;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
  }

  &:after {
    width: 25px;
    height: 6px;
    left: 11px;
    top: 20px;
  }

  /* &:before {
    width: 6px;
    height: 25px;
    left: 20px;
    top: 11px;
  } */
}
</style>


<section id="anc_sitfrm_cate">
    <h5 class="htag_title">카테고리</h5>
<?php echo $pg_anchor; ?>
<div class="local_desc02 local_desc">
	<p>선택된 카테고리에 <span class="fc_084">최상위 카테고리는 대표 카테고리로 자동설정</span>되며, 최소 1개의 카테고리는 등록하셔야 합니다.</p>
</div>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">카테고리 선택</th>
		<td>
			<div class="sub_frm01">
				<table>
				<tr>
					<td class="w20p bg1">
						<?php echo get_category_select_1('sel_ca1', '', ' size="10" class="multiple-select"'); ?>
					</td>
					<td class="w20p bg1">
						<?php echo get_category_select_2('sel_ca2', '', ' size="10" class="multiple-select"'); ?>
					</td>
					<td class="w20p bg1">
						<?php echo get_category_select_3('sel_ca3', '', ' size="10" class="multiple-select"'); ?>
					</td>
					<!-- <td class="w20p bg1">
						<?php //echo get_category_select_4('sel_ca4', '', ' size="10" class="multiple-select"'); ?>
					</td>
					<td class="w20p bg1">
						<?php //echo get_category_select_5('sel_ca5', '', ' size="10" class="multiple-select"'); ?>
					</td> -->
				</tr>
				</table>
			</div>
			<div class="btn_confirm02">
				<button type="button" class="btn_lsmall blue" onclick="category_add();">카테고리 추가</button>
			</div>
			<script>
			$(function() {
				$("#sel_ca1").multi_select_box("#sel_ca",5,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca2").multi_select_box("#sel_ca",5,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca3").multi_select_box("#sel_ca",5,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca4").multi_select_box("#sel_ca",5,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca5").multi_select_box("#sel_ca",5,"","=카테고리선택=");
			});
			</script>
		</td>
	</tr>
	<tr>
		<th scope="row">선택된 카테고리<br><span class="fc_red">(복수 카테고리 최대 3개까지만 등록)</span></th>
		<td>
			<select name="sel_ca_id" id="sel_ca_id" size="5" class="multiple-select">
			<?php
			if($w == "u") {
				if($ca_id1 = adm_category_navi($gs['ca_id']))
					echo '<option value="'.$gs['ca_id'].'">' .$ca_id1. '</option>'.PHP_EOL;
				if($ca_id2 = adm_category_navi($gs['ca_id2']))
					echo '<option value="'.$gs['ca_id2'].'">'.$ca_id2.'</option>'.PHP_EOL;
				if($ca_id3 = adm_category_navi($gs['ca_id3']))
					echo '<option value="'.$gs['ca_id3'].'">'.$ca_id3.'</option>'.PHP_EOL;
			}
			?>
			</select>
			<div class="btn_confirm02">
				<!-- <button type="button" class="btn_lsmall bx-white" onclick="category_move('sel_ca_id', 'prev');">▲ 위로</button>
				<button type="button" class="btn_lsmall bx-white" onclick="category_move('sel_ca_id', 'next');">▼ 아래로</button> -->
				<button type="button" class="btn_lsmall frm_option_del red">카테고리 삭제</button>
			</div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
</section>


<?php echo $frm_submit2; ?>
<p class="gap70"></p>
<section id="anc_sitfrm_ini">
    <h5 class="htag_title">기본정보</h5>
    <?php echo $pg_anchor; ?>
<?php if($w == 'u') { ?>
<div class="local_desc02 local_desc">
	<p>상품 등록일시 : <b><?php echo $gs['reg_time']; ?></b>, 최근 수정일시 : <b><?php echo $gs['update_time']; ?></b></p>
</div>
<?php } ?>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col style="width:220px">
		<col>
		<col style="width:220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">업체검색<span>(*)</span></th>
		<td>
            <div class="write_address">
                <div class="file_wrap address">
                    <input type="text" name="mb_id" value="<?php echo $gs['mb_id']; ?>" required itemname="업체코드" class="required frm_input">
                    <a href="./supply.php" onclick="win_open(this,'pop_supply','550','500','no');return false" class="btn_file">업체선택</a>
                </div>
            </div>
		</td>
        <th scope="row">업체명</th>
        <td>
      <input type="text" name="name" value="<?php echo $gs['name']; ?>" itemname="공급사명" class="frm_input" readonly style='background-color:#ddd;'>
      <?php echo help('업체선택 시 자동으로 기입됩니다.'); ?>
        </td>
	</tr>
	<tr>
		<th scope="row">상품코드</th>
		<td>
			<input type="text" name="gcode" value="<?php echo $gs['gcode']; ?>" required itemname="상품코드" class="required frm_input"<?php echo $readonly; ?>>
			<?php if($w == "u") { ?><a href="<?php echo BV_SHOP_URL; ?>/view.php?index_no=<?php echo $gs_id; ?>" target="_blank" class="btn_large">미리보기</a><?php } ?>
      <?php echo help('상품코드는 자동으로 생성됩니다.'); ?>
		</td>
        <th scope="row">가맹점 상품코드</th>
        <td>
            <input type="text" name="sgcode" value="<?php echo $gs['sgcode']; ?>" itemname="가맹점 상품코드" class="frm_input"<?php //echo $readonly; ?>>
        </td>
	</tr>
	<tr>
		<th scope="row">상품명<span>(*)</span></th>
		<td><input type="text" name="gname" value="<?php echo $gs['gname']; ?>" required itemname="상품명" class="required frm_input" size="80"></td>
        <th scope="row">검색키워드<span>(*)</span></th>
        <td>
            <input type="text" name="keywords" value="<?php echo $gs['keywords']; ?>" class="frm_input wfull">
            <?php echo help('단어와 단어 사이는 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑'); ?>
        </td>
	</tr>
	<!-- <tr>
		<th scope="row">짧은설명</th>
		<td><input type="text" name="explan" value="<?php echo $gs['explan']; ?>" class="frm_input" size="80"></td>
	</tr> -->
	<tr>
		<th scope="row">브랜드</th>
		<td>
            <div class="chk_select">
                <select name="brand_uid">
                    <option value="">선택</option>
                    <?php
                    $sql = "select *
                              from shop_brand
                             where br_user_yes = 0 or (br_user_yes = 1 and mb_id = '$gs[mb_id]')
                             order by br_name asc ";
                    $res = sql_query($sql);
                    while($row = sql_fetch_array($res)){
                        echo option_selected($row['br_id'], $gs['brand_uid'], $row['br_name']);
                    }
                    ?>
                </select>
            </div>
		</td>
        <th scope="row">모델명</th>
        <td><input type="text" name="model" value="<?php echo $gs['model']; ?>" class="frm_input"></td>
	</tr>
	<tr>
		<th scope="row">원산지</th>
		<td><input type="text" name="origin" value="<?php echo $gs['origin']; ?>" class="frm_input"></td>
        <th scope="row">업체</th>
        <td><input type="text" name="maker" value="<?php echo $gs['maker']; ?>" class="frm_input"></td>
	</tr>
	<tr>
		<th scope="row">과세설정<span>(*)</span></th>
		<td class="td_label">
            <div class="radio_group">
                <?php echo radio_checked('notax', $gs['notax'], '1', '과세'); ?>
                <?php echo radio_checked('notax', $gs['notax'], '0', '면세'); ?>
            </div>
		</td>
        <th scope="row">판매여부</th>
        <td class="td_label">
            <div class="radio_group">
                <?php echo radio_checked('isopen', $gs['isopen'], '1', '공급가능'); ?>
                <?php echo radio_checked('isopen', $gs['isopen'], '2', '일시중단'); ?>
                <?php //echo radio_checked('isopen', $gs['isopen'], '3', '단종'); ?>
                <?php echo radio_checked('isopen', $gs['isopen'], '4', '공급중단'); ?>
            </div>
        </td>
	</tr>

	<tr>
		<!-- <th scope="row">일반/정기배송 구분</th> -->
		<th scope="row">유형</th>
		<td class="td_label" colspan="3">
            <div class="radio_group">
                <?php echo radio_checked('reg_yn', $gs['reg_yn'], '2', '일반배송'); ?>
                <?php echo radio_checked('reg_yn', $gs['reg_yn'], '1', '정기배송'); ?>
                <!-- reg_yn == 3 | 렌탈 추가 _20240701_SY -->
                <?php echo radio_checked('reg_yn', $gs['reg_yn'], '3', '렌탈'); ?>
            </div>
		</td>
	</tr>
	<!-- <tr>
		<th scope="row">네이버쇼핑 상품ID</th>
		<td>
			<input type="text" name="ec_mall_pid" value="<?php //echo $gs['ec_mall_pid']; ?>" id="ec_mall_pid" class="frm_input">
			<?php //echo help("네이버쇼핑에 입점한 경우 네이버쇼핑 상품ID를 입력하시면 네이버페이와 연동됩니다.<br>일부 쇼핑몰의 경우 네이버쇼핑 상품ID 대신 쇼핑몰 상품ID를 입력해야 하는 경우가 있습니다.<br>네이버페이 연동과정에서 이 부분에 대한 안내가 이뤄지니 안내받은 대로 값을 입력하시면 됩니다."); ?>
		</td>
	</tr> -->
	</tbody>
	</table>
</div>
</section>

<?php echo $frm_submit2; ?>


<p class="gap70"></p>
<section id="anc_sitfrm_option">
<h5 class="htag_title">옵션정보</h5>
<?php echo $pg_anchor; ?>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<?php
	$opt_subject = explode(',', $gs['opt_subject']);
	?>
	<tr>
		<th scope="row">상품 주문옵션</th>
		<td>
			<p class="mart5">옵션항목은 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑</p>
			<table class="mart7">
			<colgroup>
				<col width="220px">
				<col>
				<col width="220px">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">옵션1</th>
				<td><input type="text" name="opt1_subject" value="<?php echo $opt_subject[0]; ?>" id="opt1_subject" class="frm_input wfull"></td>
				<th scope="row">옵션1 항목</th>
				<td><input type="text" name="opt1" id="opt1" value="" class="frm_input wfull"></td>
			</tr>
			<tr>
				<th scope="row">옵션2</th>
				<td><input type="text" name="opt2_subject" value="<?php echo $opt_subject[1]; ?>" id="opt2_subject" class="frm_input wfull"></td>
				<th scope="row">옵션2 항목</th>
				<td><input type="text" name="opt2" id="opt2" value="" class="frm_input wfull"></td>
			</tr>
			<tr>
				<th scope="row">옵션3</th>
				<td><input type="text" name="opt3_subject" value="<?php echo $opt_subject[2]; ?>" id="opt3_subject" class="frm_input wfull"></td>
				<th scope="row">옵션3 항목</th>
				<td><input type="text" name="opt3" id="opt3" value="" class="frm_input wfull"></td>
			</tr>
			</tbody>
			</table>
			<p class="btn_confirm02"><button type="button" id="option_table_create" class="btn_large red">옵션목록생성</button></p>

			<div id="sit_option_frm">
				<?php include_once(BV_ADMIN_PATH.'/goods/goods_option.php'); ?>
			</div>

			<script>
			$(function() {
				<?php if($gs['index_no'] && $po_run) { ?>
				//옵션항목설정
				var arr_opt1 = new Array();
				var arr_opt2 = new Array();
				var arr_opt3 = new Array();
				var opt1 = opt2 = opt3 = '';
				var opt_val;

				$(".opt-cell").each(function() {
					opt_val = $(this).text().split(" > ");
					opt1 = $.trim(opt_val[0]);
					opt2 = $.trim(opt_val[1]);
					opt3 = $.trim(opt_val[2]);

					if(opt1 && $.inArray(opt1, arr_opt1) == -1)
						arr_opt1.push(opt1);

					if(opt2 && $.inArray(opt2, arr_opt2) == -1)
						arr_opt2.push(opt2);

					if(opt3 && $.inArray(opt3, arr_opt3) == -1)
						arr_opt3.push(opt3);
				});

				$("input[name=opt1]").val(arr_opt1.join());
				$("input[name=opt2]").val(arr_opt2.join());
				$("input[name=opt3]").val(arr_opt3.join());
				<?php } ?>

				// 옵션목록생성
				$("#option_table_create").click(function() {
					var gs_id = $.trim($("input[name=gs_id]").val());
					var opt1_subject = $.trim($("#opt1_subject").val());
					var opt2_subject = $.trim($("#opt2_subject").val());
					var opt3_subject = $.trim($("#opt3_subject").val());
					var opt1 = $.trim($("#opt1").val());
					var opt2 = $.trim($("#opt2").val());
					var opt3 = $.trim($("#opt3").val());
					var $option_table = $("#sit_option_frm");

					if(!opt1_subject || !opt1) {
						alert("옵션명과 옵션항목을 입력해 주십시오.");
						return false;
					}

					$.post(
						bv_admin_url+"/goods/goods_option.php",
						{ gs_id: gs_id, w: "<?php echo $w; ?>", opt1_subject: opt1_subject, opt2_subject: opt2_subject, opt3_subject: opt3_subject, opt1: opt1, opt2: opt2, opt3: opt3 },
						function(data) {
							$option_table.empty().html(data);
						}
					);
				});

				// 모두선택
				$(document).on("click", "input[name=opt_chk_all]", function() {
					if($(this).is(":checked")) {
						$("input[name='opt_chk[]']").attr("checked", true);
					} else {
						$("input[name='opt_chk[]']").attr("checked", false);
					}
				});

				// 선택삭제
				$(document).on("click", "#sel_option_delete", function() {
					var $el = $("input[name='opt_chk[]']:checked");
					if($el.size() < 1) {
						alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
						return false;
					}

					$el.closest("tr").remove();
				});

				// 일괄적용
				$(document).on("click", "#opt_value_apply", function() {
					if($(".opt_com_chk:checked").size() < 1) {
						alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
						return false;
					}

					var opt_supply_price = $.trim($("#opt_com_supply_price").val());
					var opt_price = $.trim($("#opt_com_price").val());
					var opt_stock = $.trim($("#opt_com_stock").val());
					var opt_noti = $.trim($("#opt_com_noti").val());
					var opt_use = $("#opt_com_use").val();
					var $el = $("input[name='opt_chk[]']:checked");

					// 체크된 옵션이 있으면 체크된 것만 적용
					if($el.size() > 0) {
						var $tr;
						$el.each(function() {
							$tr = $(this).closest("tr");

							if($("#opt_com_supply_price_chk").is(":checked"))
								$tr.find("input[name='opt_supply_price[]']").val(opt_supply_price);

							if($("#opt_com_price_chk").is(":checked"))
								$tr.find("input[name='opt_price[]']").val(opt_price);

							if($("#opt_com_stock_chk").is(":checked"))
								$tr.find("input[name='opt_stock_qty[]']").val(opt_stock);

							if($("#opt_com_noti_chk").is(":checked"))
								$tr.find("input[name='opt_noti_qty[]']").val(opt_noti);

							if($("#opt_com_use_chk").is(":checked"))
								$tr.find("select[name='opt_use[]']").val(opt_use);
						});
					} else {
						if($("#opt_com_supply_price_chk").is(":checked"))
							$("input[name='opt_supply_price[]']").val(opt_supply_price);

						if($("#opt_com_price_chk").is(":checked"))
							$("input[name='opt_price[]']").val(opt_price);

						if($("#opt_com_stock_chk").is(":checked"))
							$("input[name='opt_stock_qty[]']").val(opt_stock);

						if($("#opt_com_noti_chk").is(":checked"))
							$("input[name='opt_noti_qty[]']").val(opt_noti);

						if($("#opt_com_use_chk").is(":checked"))
							$("select[name='opt_use[]']").val(opt_use);
					}
				});
			});
			</script>
		</td>
	</tr>
	<?php
	$spl_subject = explode(',', $gs['spl_subject']);
	$spl_count = count($spl_subject);
	?>
	<tr>
		<th scope="row">상품 추가옵션</th>
		<td>
			<p>
				<span class="mart7 fl">옵션항목은 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑</span>
				<button type="button" id="add_supply_row" class="btn_large blue marb5 fr">옵션추가</button>
			</p>
			<div id="sit_supply_frm">
				<table>
				<colgroup>
					<col width="60px">
					<col width="150px">
					<col width="85px">
					<col>
					<col width="65px">
				</colgroup>
				<?php
				$i = 0;
				do {
					$seq = $i + 1;
				?>
				<tr>
					<th scope="row">추가<?php echo $seq; ?></th>
					<td><input type="text" name="spl_subject[]" value="<?php echo $spl_subject[$i]; ?>" id="spl_subject_<?php echo $seq; ?>" class="frm_input wfull"></td>
					<th scope="row">추가<?php echo $seq; ?> 항목</th>
					<td><input type="text" name="spl[]" id="spl_item_<?php echo $seq; ?>" value="" class="frm_input wfull"></td>
					<td class="tac">
					<?php
					if($i > 0)
						echo '<button type="button" id="del_supply_row" class="btn_ssmall bx-white">삭제</button>';
					?>
					</td>
				</tr>
				<?php
					$i++;
				} while($i < $spl_count);
				?>
				</table>
				<p class="btn_confirm02"><button type="button" id="supply_table_create" class="btn_lsmall red">옵션목록생성</button></p>
			</div>
			<div id="sit_option_addfrm">
				<?php include_once(BV_ADMIN_PATH.'/goods/goods_spl.php'); ?>
			</div>

			<script>
			$(function() {
				<?php if($gs['index_no'] && $ps_run) { ?>
				// 추가옵션의 항목 설정
				var arr_subj = new Array();
				var subj, spl;

				$("input[name='spl_subject[]']").each(function() {
					subj = $.trim($(this).val());
					if(subj && $.inArray(subj, arr_subj) == -1)
						arr_subj.push(subj);
				});

				for(i=0; i<arr_subj.length; i++) {
					var arr_spl = new Array();
					$(".spl-subject-cell").each(function(index) {
						subj = $.trim($(this).text());
						if(subj == arr_subj[i]) {
							spl = $.trim($(".spl-cell:eq("+index+")").text());
							arr_spl.push(spl);
						}
					});

					$("input[name='spl[]']:eq("+i+")").val(arr_spl.join());
				}
				<?php } ?>
				// 입력필드추가
				$("#add_supply_row").click(function() {
					var $el = $("#sit_supply_frm tr:last");
					var fld = "<tr>\n";
					fld += "<th scope=\"row\"><label for=\"\">추가</label></th>\n";
					fld += "<td><input type=\"text\" name=\"spl_subject[]\" value=\"\" class=\"frm_input wfull\"></td>\n";
					fld += "<th scope=\"row\" class=\"ssupply_type\"><label for=\"\">추가 항목</label></th>\n";
					fld += "<td><input type=\"text\" name=\"spl[]\" value=\"\" class=\"frm_input wfull\"></td>\n";
					fld += "<td class=\"tac\"><button type=\"button\" id=\"del_supply_row\" class=\"btn_ssmall bx-white\">삭제</button></td>\n";
					fld += "</tr>";

					$el.after(fld);

					supply_sequence();
				});

				// 입력필드삭제
				$(document).on("click", "#del_supply_row", function() {
					$(this).closest("tr").remove();

					supply_sequence();
				});

				// 옵션목록생성
				$("#supply_table_create").click(function() {
					var gs_id = $.trim($("input[name=gs_id]").val());
					var subject = new Array();
					var supply = new Array();
					var subj, spl;
					var count = 0;
					var $el_subj = $("input[name='spl_subject[]']");
					var $el_spl = $("input[name='spl[]']");
					var $supply_table = $("#sit_option_addfrm");

					$el_subj.each(function(index) {
						subj = $.trim($(this).val());
						spl = $.trim($el_spl.eq(index).val());

						if(subj && spl) {
							subject.push(subj);
							supply.push(spl);
							count++;
						}
					});

					if(!count) {
						alert("추가옵션명과 추가옵션항목을 입력해 주십시오.");
						return false;
					}

					$.post(
						bv_admin_url+"/goods/goods_spl.php",
						{ gs_id: gs_id, w: "<?php echo $w; ?>", 'subject[]': subject, 'supply[]': supply },
						function(data) {
							$supply_table.empty().html(data);
						}
					);
				});

				// 모두선택
				$(document).on("click", "input[name=spl_chk_all]", function() {
					if($(this).is(":checked")) {
						$("input[name='spl_chk[]']").attr("checked", true);
					} else {
						$("input[name='spl_chk[]']").attr("checked", false);
					}
				});

				// 선택삭제
				$(document).on("click", "#sel_supply_delete", function() {
					var $el = $("input[name='spl_chk[]']:checked");
					if($el.size() < 1) {
						alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
						return false;
					}

					$el.closest("tr").remove();
				});

				// 일괄적용
				$(document).on("click", "#spl_value_apply", function() {
					if($(".spl_com_chk:checked").size() < 1) {
						alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
						return false;
					}

					var spl_supply_price = $.trim($("#spl_com_supply_price").val());
					var spl_price = $.trim($("#spl_com_price").val());
					var spl_stock = $.trim($("#spl_com_stock").val());
					var spl_noti = $.trim($("#spl_com_noti").val());
					var spl_use = $("#spl_com_use").val();
					var $el = $("input[name='spl_chk[]']:checked");

					// 체크된 옵션이 있으면 체크된 것만 적용
					if($el.size() > 0) {
						var $tr;
						$el.each(function() {
							$tr = $(this).closest("tr");

							if($("#spl_com_supply_price_chk").is(":checked"))
								$tr.find("input[name='spl_supply_price[]']").val(spl_supply_price);

							if($("#spl_com_price_chk").is(":checked"))
								$tr.find("input[name='spl_price[]']").val(spl_price);

							if($("#spl_com_stock_chk").is(":checked"))
								$tr.find("input[name='spl_stock_qty[]']").val(spl_stock);

							if($("#spl_com_noti_chk").is(":checked"))
								$tr.find("input[name='spl_noti_qty[]']").val(spl_noti);

							if($("#spl_com_use_chk").is(":checked"))
								$tr.find("select[name='spl_use[]']").val(spl_use);
						});
					} else {
						if($("#spl_com_supply_price_chk").is(":checked"))
							$("input[name='spl_supply_price[]']").val(spl_supply_price);

						if($("#spl_com_price_chk").is(":checked"))
							$("input[name='spl_price[]']").val(spl_price);

						if($("#spl_com_stock_chk").is(":checked"))
							$("input[name='spl_stock_qty[]']").val(spl_stock);

						if($("#spl_com_noti_chk").is(":checked"))
							$("input[name='spl_noti_qty[]']").val(spl_noti);

						if($("#spl_com_use_chk").is(":checked"))
							$("select[name='spl_use[]']").val(spl_use);
					}
				});
			});

			function supply_sequence()
			{
				var $tr = $("#sit_supply_frm tr");
				var seq;
				var th_label, td_label;

				$tr.each(function(index) {
					seq = index + 1;
					$(this).find("th label").attr("for", "spl_subject_"+seq).text("추가"+seq);
					$(this).find("td input").attr("id", "spl_subject_"+seq);
					$(this).find("th.ssupply_type label").attr("for", "spl_item_"+seq);
					$(this).find("th.ssupply_type label").text("추가"+seq+" 항목");
					$(this).find("td input").attr("id", "spl_item_"+seq);
				});
			}
			</script>
		</td>
	</tr>
	</tbody>
	</table>
</div>
</section>

<?php echo $frm_submit2; ?>
<p class="gap70"></p>
<section id="anc_sitfrm_cost">
    <h5 class="htag_title">가격 및 재고</h5>
<?php echo $pg_anchor; ?>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
  <tr>
		<th scope="row">정산방식</th>
		<td>
            <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="supply_type" value="2" id="income_type0"<?php echo ($w == '') ? "checked" : get_checked('2', $gs['supply_type']); ?> >
                    <label for="income_type0" class="marr10">업체 정산 설정에 따름</label>
                </li>
                <li class="radios">
                    <input type="radio" name="supply_type" value="0" id="income_type1"<?php echo get_checked('0', $gs['supply_type']); ?> >
                    <label for="income_type1" class="marr10">매입가 정산 지급</label>
                </li>
                <li class="rdaios">
                    <input type="radio" name="supply_type" value="1" id="income_type2"<?php echo get_checked('1', $gs['supply_type']); ?> >
                    <label for="income_type2" class="marr10">수수료 정산 지급</label>
                </li>
            </ul>
		</td>
	</tr>
  <?php
    $display = ($w == '' || $gs['supply_type'] == '0' || $gs['supply_type'] == '2') ? "display: none;" : "";
  ?>
  <!-- 수수료(정액/정률) 추가 _20240508_SY -->
  <tr id="incomePer_type" style="<?php echo $display ?>">
    <th scope="row">지급방식</th>
    <td>
        <ul class="radio_group">
            <li class="radios">
                <input type="radio" name="incomePer_type" value="0" id="incomePer_type1" <?php echo ($w == '') ? "checked" : get_checked('0', $gs['income_per_type']); ?>>
                <label for="incomePer_type1" class="marr10">정액지급<b class="incomePer_type1"></b> </label>
            </li>
            <li class="radios">
                <input type="radio" name="incomePer_type" value="1" id="incomePer_type2" <?php echo ($w == '') ? "" : get_checked('1', $gs['income_per_type']); ?>>
                <label for="incomePer_type2" class="marr10">정률지급<b class="incomePer_type2"></b> </label>
            </li>
        </ul>
    </td>
  </tr>
	<tr class="supply_tr">
		<th scope="row">매입가격</th>
		<td>
			<input type="text" name="supply_price" id="supply_price" value="<?php echo number_format($gs['supply_price']); ?>" class="frm_input w80" onkeyup="addComma(this); zeroVal(this);"> 원
			<span class="fc_197 marl5">사입처에서 공급받은 가격</span>
		</td>
	</tr>
	<tr class="incomePer_tr" id="incomePer_sub1" style="<?php echo ($gs['income_per_type'] == 1) ? 'display:none;' : '' ?>">
		<th scope="row">수수료(정액)</th>
		<td>
			<input type="text" name="income_price"  value="<?php echo ($w == 'u' && $gs['supply_type'] == '1' && $gs['income_per_type'] == '0') ? number_format($gs['supply_price']) : 0 ?>" class="frm_input w80" onkeyup="addComma(this); zeroVal(this);"> 원
			<span class="fc_197 marl5">이익률</span>
		</td>
	</tr>
	<tr class="incomePer_tr" id="incomePer_sub2" style="<?php echo ($gs['income_per_type'] == 0) ? 'display:none;' : '' ?>">
		<th scope="row">수수료(정률)</th>
		<td>
			<input type="text" name="income_per"  value="<?php echo ($w == 'u' && $gs['income_per_type'] == '1') ? $income_per: 0 ?>" class="frm_input w80" onkeyup="addComma(this); zeroVal(this);"> %
			<span class="fc_197 marl5">이익률</span>
		</td>
	</tr>
  <tr>
		<th scope="row">판매가격</th>
		<td>
			<input type="text" name="goods_price" id="goods_price" value="<?php echo number_format($gs['goods_price']); ?>" class="frm_input w80" onkeyup="addComma(this); zeroVal(this);"> 원
			<span class="fc_197 marl5">실제 판매가 입력 (대표가격으로 사용)</span>
		</td>
	</tr>
  <tr>
		<th scope="row">시중가격</th>
		<td>
			<input type="text" name="normal_price" id="normal_price" value="<?php echo number_format($gs['normal_price']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 원
			<span class="fc_197 marl5">시중에 판매되는 가격 (판매가보다 크지않으면 시중가 표시안함)</span>
		</td>
	</tr>

	<tr style='display:none'>
		<th scope="row">포인트</th>
		<td>
			<input type="text" name="gpoint" value="<?php echo number_format($gs['gpoint']); ?>" class="frm_input w80" onkeyup="addComma(this);"> P
			<input type="text" name="marper" class="frm_input w50"> %
		</td>
	</tr>
	<tr>
		<th scope="row">가격 대체문구</th>
		<td>
			<input type="text" name="price_msg" value="<?php echo $gs['price_msg']; ?>" class="frm_input">
			<span class="fc_197 marl5">가격대신 보여질 문구를 노출할 때 입력, 주문불가</span>
		</td>
	</tr>
	<tr>
		<th scope="row">수량</th>
		<td>
			<input type="radio" name="stock_mod" value="0" id="ids_stock_mode1"<?php echo get_checked('0', $gs['stock_mod']); ?> onclick="chk_stock(0);">
			<label for="ids_stock_mode1" class="marr10">무제한</label>
			<input type="radio" name="stock_mod" value="1" id="ids_stock_mode2"<?php echo get_checked('1', $gs['stock_mod']); ?> onclick="chk_stock(1);">
			<label for="ids_stock_mode2">한정</label>
			<input type="text" name="stock_qty" value="<?php echo number_format($gs['stock_qty']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 개,
			<b class="marl10">재고 통보수량</b> <input type="text" name="noti_qty" value="<?php echo number_format($gs['noti_qty']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 개
			<p class="fc_197 mart7">상품의 재고가 통보수량보다 작을 때 상품 재고관리에 표시됩니다.<br>옵션이 있는 상품은 개별 옵션의 통보수량이 적용됩니다. 설정이 무제한이면 재고관리에 표시되지 않습니다.</p>
		</td>
	</tr>
	<tr>
		<th scope="row">주문한도</th>
		<td>
			최소 <input type="text" name="odr_min" value="<?php echo $gs['odr_min']; ?>" class="frm_input w80"> ~
			최대 <input type="text" name="odr_max" value="<?php echo $gs['odr_max']; ?>" class="frm_input w80">
			<span class="fc_197 marl5">미입력시 무제한</span>
		</td>
	</tr>
	<tr>
		<th scope="row">판매기간 설정</th>
		<td>
			<label for="sb_date" class="sound_only">시작일</label>
			<input type="text" name="sb_date" value="<?php echo $gs['sb_date']; ?>" id="sb_date" class="frm_input w80" maxlength="10"> ~
			<label for="eb_date" class="sound_only">종료일</label>
			<input type="text" name="eb_date" value="<?php echo $gs['eb_date']; ?>" id="eb_date" class="frm_input w80" maxlength="10">
			<a href="javascript:void(0);" class="btn_large is_reset">기간초기화</a>
			<div class="fc_197 mart7">
				설정된 기간 동안만 판매 가능하며, 설정된 종료일 이후에는 판매되지 않습니다.<br>
				일시 판매중지 처리하실 경우, 종료일을 현재날짜 이전의 과거 날짜를 넣어주시면 됩니다.
			</div>
			<script>
			$(function(){
				// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
				$("#sb_date,#eb_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99"});

				// 기간초기화
				$(document).on("click", ".is_reset", function() {
					$("#sb_date, #eb_date").val("");
				});
			});
			</script>
		</td>
	</tr>
	<tr>
		<th scope="row">구매가능 레벨</th>
		<td>
			<?php echo get_goods_level_select('buy_level', $gs['buy_level']); ?>
			<label class="marl5"><input type="checkbox" name="buy_only" value="1"<?php echo get_checked('1', $gs['buy_only']); ?>> 현재 레벨이상 가격공개</label>
		</td>
	</tr>
	</tbody>
	</table>
</div>
</section>

<script>
  // 정산방식 추가 _20240425_SY

  function stringNumberToInt(stringNumber){
      return parseFloat(stringNumber.replace(/,/g , ''));
  }

  function zeroVal(input) {
    if (input.value.trim() === '') {
        input.value = '0';
    }
  }

  // let income_type1   = $('.income_type1');
  // let income_type2   = $('.income_type2');

  let supply_price  = 0;
  let goods_price   = 0;
  let income_price  = 0;
  let income_per    = 0;

  $(function() {

    // 정산방식 > 업제청산
    if ($('#income_type0').is(':checked')) {
      $('.incomePer_tr').hide();
      $('#incomePer_sub2').hide();
      $('#incomePer_sub1').hide();
      // 20240603_SY
      // $('#goods_price').keyup(function() {
      //   zeroVal(this);
      //   let seller_code  = $('input[name=mb_id]').val();
      //   let in_type      = $('input[name=in_type]').val();
      //   let in_per_type  = $('input[name=in_per_type]').val();
      //   let in_price     = $('input[name=in_price]').val();
      //   let in_per       = $('input[name=in_per]').val();
      //   let total_price  = 0;

      //   // admin이면 해당 로직 안 탐 _20240612_SY
      //   if(seller_code != "admin") {
      //     if(in_type == 1) {
      //       if(in_per_type == 1) {
      //         total_price = stringNumberToInt($('#goods_price').val()) * (1 - in_per/ 100);
      //         $('#supply_price').val(total_price.toFixed(0));
      //       } else {
      //         total_price = stringNumberToInt($('#goods_price').val()) - in_price;
      //         $('#supply_price').val(total_price);
      //       }
      //     } else {
      //       total_price = stringNumberToInt($('#goods_price').val()) - in_price;
      //       $('#supply_price').val(total_price);
      //     }
      //   }
      // })

      // 수정 (매입가) - (수수료) = (판매가격) _20240617_SY -> 수정 (매입가) + (수수료) = (판매가격) _20240620_SY
      $('#supply_price').keyup(function() {
        zeroVal(this);
        let seller_code  = $('input[name=mb_id]').val();
        let in_type      = $('input[name=in_type]').val();
        let in_per_type  = $('input[name=in_per_type]').val();
        let in_price     = $('input[name=in_price]').val();
        let in_per       = $('input[name=in_per]').val();
        let total_price  = 0;

        // admin이면 해당 로직 안 탐 _20240612_SY
        if(seller_code != "admin") {
          if(in_type == 1) {
            if(in_per_type == 1) {
              total_price = stringNumberToInt($('#supply_price').val()) * (1 + in_per/ 100);
              $('#goods_price').val(total_price.toFixed(0));
            } else {
              total_price = stringNumberToInt($('#supply_price').val()) + in_price;
              $('#goods_price').val(total_price);
            }
          } else {
            total_price = stringNumberToInt($('#supply_price').val()) + in_price;
            $('#goods_price').val(total_price);
          }
        }
      })
    }

    $('#income_type0').change(function() {
      $('.incomePer_tr').hide();
      $('#incomePer_type').hide();
    });

    // 정산방식 > 매입가
    if ($('#income_type1').is(':checked')) {
      $('.incomePer_tr').hide();
      $('#incomePer_sub2').hide();
      $('#incomePer_sub1').hide();
      $('.supply_tr').show();
    }

    $('#income_type1').change(function() {
      $('.incomePer_tr').hide();
      $('#incomePer_type').hide();
      $('.supply_tr').show();
    });

    // 정산방식 > 수수료
    $('#income_type2').change(function() {
      $('.incomePer_tr').show();
      $('#incomePer_type').show();
      $('.supply_tr').show();
      if ($('#incomePer_type1').is(':checked')) {
        $('#incomePer_sub2').hide();
      } else {
        $('#incomePer_sub1').hide();
      }
    });

    // 수수료지급방식 > 정액
    $('#incomePer_type1').change(function() {
      $('#incomePer_sub1').show();
      $('#incomePer_sub2').hide();

      // 추가 (매입가) - (수수료) = (판매가격) _20240617_SY -> 수정 (매입가) + (수수료) = (판매가격) _20240620_SY
      let supply_price = $("input[name=supply_price]");
      goods_price = document.querySelector('#goods_price');
      income_price = $("input[name=income_price]");
      income_per = $("input[name=income_per]");
      if(income_per.val() != "0" && income_price.val() != "0") {
        goods_price.value = (stringNumberToInt(supply_price.val()) + stringNumberToInt(income_price.val()));
      } else {
        goods_price.value = 0;
      }
    })

    // 수수료지급방식 > 정률
    $('#incomePer_type2').change(function() {
      $('#incomePer_sub1').hide();
      $('#incomePer_sub2').show();
      $('.supply_tr').show();

      // 추가 (매입가) - (수수료) = (판매가격) _20240617_SY -> 수정 (매입가) + (수수료) = (판매가격) _20240620_SY
      let supply_price = $("input[name=supply_price]");
      goods_price = document.querySelector('#goods_price');
      income_price = $("input[name=income_price]");
      income_per = $("input[name=income_per]");
      if(income_per.val() != "0" && supply_price.val() != "0") {
        goods_price.value = (stringNumberToInt(supply_price.val()) * (1 + parseFloat(income_per.val())/100));
      } else {
        goods_price.value = 0;
      }
    })
  });

  // 수정 ( (매입가) - (수수료) = (판매가격) ) _20240617_SY -> 수정 (매입가) + (수수료) = (판매가격) _20240620_SY
  $("input[name=supply_price]").on("keyup", function() {
    goods_price = document.querySelector('#goods_price');
    income_price = $("input[name=income_price]");
    income_per = $("input[name=income_per]");
    if ($('#incomePer_type1').is(':checked') && this.value != "0" && income_price.val() != "0") {
      goods_price.value = (stringNumberToInt(this.value) + stringNumberToInt(income_price.val()));
    } else if ($('#incomePer_type2').is(':checked') && this.value != "0" && income_per.val() != "0") {
      goods_price.value = (stringNumberToInt(this.value) * (1 + parseFloat(income_per.val())/100));
    } else {
      goods_price.value = 0;
    }

  })

  $("input[name=income_price]").on('keyup', function() {
    supply_price = document.querySelector('#supply_price').value;
    goods_price = document.querySelector('#goods_price');
    if(supply_price != "0" && this.value != "0") {
      goods_price.value = (stringNumberToInt(supply_price) + stringNumberToInt(this.value));
    } else {
      goods_price.value = 0;
    }
  });

  $("input[name=income_per]").on('keyup', function() {
    supply_price = document.querySelector('#supply_price').value;
    goods_price = document.querySelector('#goods_price');
    if(supply_price != "0" && this.value != "0") {
      goods_price.value = (stringNumberToInt(supply_price) * (1 + parseFloat(this.value)/100));
    } else {
      goods_price.value = 0;
    }
  });



  // 수정 _20240508_SY
  // let supply_price = 0;
  // $("#incomePer_sub1").on('keyup', function() {
  //   $("input[name=income_per]").val(0)
  //   supply_price = stringNumberToInt($("input[name=income_price]").val());
  //   $("#supply_price").val(supply_price)
  // })
  // $("#incomePer_sub2").on('keyup', function() {
  //   $("input[name=income_price]").val(0)
  //   // (판매가) x (수수료 / 100)
  //   supply_price = (stringNumberToInt($("#goods_price").val()) * ($("input[name=income_per]").val() / 100 ));
  //   $("#supply_price").val(supply_price)
  // })

  // $('#incomePer_input').on('change', function() {
  //   let supply_price = stringNumberToInt($('#supply_price').val());
  //   let incomePer_input = stringNumberToInt($('#incomePer_input').val());
	// 	console.log(incomePer_input)

  //   if(supply_price > 0 && incomePer_input > 0) {
  //     let total_price = supply_price * (1 + incomePer_input/ 100).toFixed(2)

  //     $('#goods_price').val(total_price);
  //     $('#normal_price').val(total_price);

  //     // 요율 입력시 상단 내용 변경 기능 추가 필요 _20240430_SY
  //   }
  // });


  // $('#supply_price, #goods_price, #normal_price').on('change', function() {
  //   let supply_price = stringNumberToInt($('#supply_price').val()); // 매입가
  //   let goods_price  = stringNumberToInt($('#goods_price').val());  // 판매가
  //   let normal_price = stringNumberToInt($('#normal_price').val()); // 회원판매가


  //   if(normal_price > 0) {
  //     income_type1.html("");
  //     income_type2.html("");

  //     // (판매가) - (매입가) = (이익금)
  //     let income_price = (normal_price > goods_price) ? (normal_price - supply_price) : (goods_price - supply_price);
  //     // (이익금) / (판매가) = (이익률 x 100)
  //     let income_percent = (normal_price > goods_price) ? ((normal_price
	// 		 - supply_price)/normal_price)*100 : ((goods_price - supply_price)/goods_price)*100

  //     if(income_price > 0 && income_percent > 0) {
  //       income_type1.html("<span class='fc_197'>("+income_price+"원)</span>");
  //       income_type2.html("<span class='fc_197'>("+income_percent.toFixed(2)+"%)</span>");
  //       $('#incomePer_input').val(income_percent.toFixed(2));
  //     }
  //   }

  // })


</script>

<?php echo $frm_submit2; ?>

<!-- <section id="anc_sitfrm_pay">
<h2>가맹점수수료</h2> -->
<?php // echo $pg_anchor; ?>
<!-- <div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">수수료 적용타입</th>
		<td>
			<select name="ppay_type" onChange="chk_ppay_type(this.value);">
				<?php echo option_selected('0', $gs['ppay_type'], '공통설정'); ?>
				<?php echo option_selected('1', $gs['ppay_type'], '개별설정'); ?>
			</select>
			<a href="./partner.php?code=pbasic" target="_blank" class="btn_large grey">설정</a>
		</td>
	</tr>
	<tr>
		<th scope="row">수수료 적립조건</th>
		<td>
			<select name="ppay_rate">
				<?php echo option_selected('0', $gs['ppay_rate'], '설정비율(%)로 적립'); ?>
				<?php echo option_selected('1', $gs['ppay_rate'], '설정금액(원)으로 적립'); ?>
			</select>
			<input type="text" name="ppay_dan" value="<?php echo $gs['ppay_dan']; ?>" onkeyup="chk_ppay_dan(this.value,'<?php echo $gs_id; ?>')" class="frm_input w50"> <span>단계</span>
		</td>
	</tr>
	<tr>
		<th scope="row">수수료입력</th>
		<td><span id="chk_ppay_auto"><span></td>
	</tr>
	</tbody>
	</table>
</div>
</section> -->

<!-- <?php echo $frm_submit; ?> -->

<p class="gap70"></p>
<section id="anc_sitfrm_sendcost">
    <h5 class="htag_title">배송정보</h5>
<?php echo $pg_anchor; ?>
<div class="local_desc02 local_desc">
	<p>※ <span>참고사항) : 고객이 동일 판매자의 상품을 복수 구매시 배송비는 단 한번만 부과 됩니다. 단! 배송비는 가장 큰값을 산출하여 적용 됩니다.</span></p>
	<!-- <p>※ <span>조건부무료배송) : 고객이 동일 판매자의 상품을 복수 구매시 가장 큰 값의 (조건 배송비) 금액을 산출하여 최종배송비가 자동 적용 됩니다.</span></p>
	<p>※ <span>유료배송) : 고객이 동일 판매자의 상품을 복수 구매시 가장 큰 값의 (기본 배송비) 금액을 산출하여 최종배송비가 자동 적용 됩니다.</span></p> -->
</div>
<div class="tbl_frm01">
	<table id="add_row">
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">배송정보</th>
		<td>
            <div class="write_address">
                <div class="file_wrap address">
                    <div class="chk_select">
                        <select name="sc_type" onChange="chk_sc_type(this.value);">
                        <?php //echo option_selected('0', $gs['sc_type'], '공통설정'); ?>
                        <?php echo option_selected('1', $gs['sc_type'], '택배배송'); ?>
                        <?php //echo option_selected('2', $gs['sc_type'], '조건부무료배송'); ?>
                        <?php //echo option_selected('3', $gs['sc_type'], '유료배송'); ?>
                        <?php echo option_selected('4', $gs['sc_type'], '차량배송'); ?>
                        </select>
                    </div>
                    <!-- <a href="./config.php?code=baesong" target="_blank" class="btn_large grey">설정</a> -->
                </div>
            </div>

			<!-- <div id="sc_method" class="mart7">
				배송비결제
				<select name="sc_method" class="marl10">
				<?php echo option_selected('0', $gs['sc_method'], '선불'); ?>
				<?php echo option_selected('1', $gs['sc_method'], '착불'); ?>
				<?php echo option_selected('2', $gs['sc_method'], '사용자선택'); ?>
				</select>
			</div> -->
			<!-- <div id="sc_amt" class="padt5">
				기본배송비 <input type="text" name="sc_amt" value="<?php echo number_format($gs['sc_amt']); ?>" class="frm_input w80 marl10" onkeyup="addComma(this);"> 원
				<label class="marl10"><input type="checkbox" name="sc_each_use" value="1"<?php echo get_checked('1', $gs['sc_each_use']); ?>> 묶음배송불가</label>
			</div>
			<div id="sc_minimum" class="padt5">
				조건배송비 <input type="text" name="sc_minimum" value="<?php echo number_format($gs['sc_minimum']); ?>" class="frm_input w80 marl10" onkeyup="addComma(this);"> 원 이상이면 무료배송
			</div> -->
		</td>
	</tr>
	<tr>
		<th scope="row">추가설명</th>
		<td>
			<input type="text" name="zone_msg" value="<?php echo $gs['zone_msg']; ?>" class="frm_input" size="50" placeholder="예 : 제주 (도서지역 제외)">
		</td>
	</tr>
	<tr>
		<th scope="row">배송가능 지역</th>
		<td>
			<div class="area_zone">
				<ul>
				<?php
					$sql_zone = "SELECT areacode, areaname FROM area
																	GROUP BY areacode ORDER BY areacode ASC";
					$res_zone = sql_query($sql_zone);
					$gs_zone_arr = explode("||", $gs['zone']);

					$sql_seller = "SELECT * FROM shop_seller WHERE `state` = 1";
					$res_seller = sql_query($sql_seller);
					while ($row_seller = sql_fetch_array($res_seller)) {
						$rowSeller[] = $row_seller;
					}

					for ($ii=0; $row_zone = sql_fetch_array($res_zone); $ii++) {
						$gs_zone = explode(",", $gs_zone_arr[$ii]);
				?>
					<li>
						<div>
							<?php echo $row_zone['areaname'] ?>
							<input type="hidden" name="zone[]" id="zone" value="<?php echo $row_zone['areaname'] ?> ">
						</div>
						<div class="chk_select">
							<select id="delivery_mg" name="delivery_mg[]">
								<option value="">해당없음</option>
							<?php
							for ($i = 0; $i < count($rowSeller); $i++) {
								echo option_selected($rowSeller[$i]['company_name'], $gs_zone[2], $rowSeller[$i]['company_name']);
							}
							?>
							</select>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<?php echo $frm_submit2; ?>

</section>
<style>
	.area_zone ul {
		display: flex;
        flex-wrap: wrap;
        gap:10px 1%;
	}
	.area_zone li {
		width: 20%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        text-align: center
	}
	/* .area_zone li div {
		display: inline-block;
	} */
	.area_zone li div:first-child{
		width: 70px;
        flex-shrink: 0;
	}

</style>

<p class="gap70"></p>
<section id="anc_sitfrm_compact">
    <h5 class="htag_title">상품정보 제공고시</h5>
<?php echo $pg_anchor; ?>
<div class="local_desc02 local_desc">
	<p><strong>전자상거래 등에서의 상품 등의 정보제공에 관한 고시</strong>에 따라 총 35개 상품군에 대해 상품 특성 등을 양식에 따라 입력할 수 있습니다.</p>
</div>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">상품군 선택</th>
		<td>
            <div class="chk_select">
                <select name="info_gubun" id="info_gubun">
                    <option value="">상품군 카테고리 선택</option>
                    <?php
                    if(!$gs['info_gubun']) $gs['info_gubun'] = 'food';
                    foreach($item_info as $key=>$value) {
                        $opt_value = $key;
                        $opt_text  = $value['title'];
                        echo '<option value="'.$opt_value.'" '.get_selected($opt_value, $gs['info_gubun']).'>'.$opt_text.'</option>'.PHP_EOL;
                    }
                    ?>
                </select>
            </div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<script>
	function deleteRow(button) {
    var row = button.parentNode.parentNode; // 버튼의 부모인 td의 부모인 tr 요소 가져오기
    row.parentNode.removeChild(row); // tr 요소 삭제
	}
	let rowIndex = 0;
	function addRow(e) {
		let _this = e.target.closest('tr');
    var table = document.getElementById("add_row");
    var newRow = table.insertRow(table.rows.length);
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    cell1.innerHTML = "<th scope='row'>배송가능 지역</th>";
    cell2.innerHTML = "<td><select id='zone' name='zone[]' onchange='subZone(this, this.value);'></select><select name='zone2[]'></select><select id='delivery_mg' name='delivery_mg[]'></select><button type='button' class='icon-miners blue w25' onclick='deleteRow(this)'></button></td>";

		cell1.style.cssText=`background: #f8f8f8; font-weight: 600;`;

		// 새로 추가된 셀렉트 태그에 옵션을 추가
    var selectElement = cell2.querySelector('#zone');
    var selectElement2 = cell2.querySelector('#delivery_mg');
		<?php
			$sql_zone = "SELECT areacode, areaname FROM area
										GROUP BY areacode ";
			$res_zone = sql_query($sql_zone);

			for ($i = 0; $row_zone = sql_fetch_array($res_zone); $i++) {
				?>
				var option<?php echo $i+1?> = document.createElement('option');
				option<?php echo $i+1?>.value = '<?php echo $row_zone['areaname']?>';
				option<?php echo $i+1?>.text = '<?php echo $row_zone['areaname']?>';
				selectElement.appendChild(option<?php echo $i+1 ?>);
		<?php }
			$delivery_mg2 = explode(",", $config['delivery_mg']);
			for ($i = 0; $i < count($delivery_mg2); $i++) {
				?>
				var option2<?php echo $i+1?> = document.createElement('option');
				option2<?php echo $i+1?>.value = '<?php echo $delivery_mg2[$i]?>';
				option2<?php echo $i+1?>.text = '<?php echo $delivery_mg2[$i]?>';
				selectElement2.appendChild(option2<?php echo $i+1 ?>);
		<?php } ?>

		rowIndex++;
	}
$(function(){
	// 상품정보제공 상품군선택
	$(document).on("change", "#info_gubun", function() {
		var gubun = $(this).val();
		$.post(
			bv_admin_url+"/goods/goods_info.php",
			{ gs_id: "<?php echo $gs['index_no']; ?>", gubun: gubun },
			function(data) {
				$("#sit_compact_fields").empty().html(data);
			}
		);
	});
});
</script>
<div id="sit_compact_fields" class="tbl_frm01 mart7">
	<?php include_once(BV_ADMIN_PATH.'/goods/goods_info.php'); ?>
</div>
</section>

<?php echo $frm_submit2; ?>

<p class="gap70"></p>
<section id="anc_sitfrm_relation" style="display:none">
    <h5 class="htag_title">관련상품</h5>
<?php echo $pg_anchor; ?>
<div class="local_desc02 local_desc">
	<p>
		등록된 전체상품 목록에서 카테고리를 선택하면 해당 상품 리스트가 연이어 나타납니다.<br>
		상품리스트에서 관련 상품으로 추가하시면 선택된 관련상품 목록에 <strong>함께</strong> 추가됩니다.<br>
		예를 들어, A 상품에 B 상품을 관련상품으로 등록하면 B 상품에도 A 상품이 관련상품으로 자동 추가되며, <strong>저장 버튼을 누르셔야 정상 반영됩니다.</strong>
	</p>
</div>
<div class="srel">
	<div class="compare_wrap">
		<section class="compare_left">
			<h3>등록된 전체상품 목록</h3>
			<label for="sch_relation" class="sound_only">카테고리</label>
			<span class="srel_pad">
				<?php echo get_goods_sca_select('sch_relation'); ?>
				<label for="sch_name" class="sound_only">상품명</label>
				<input type="text" name="sch_name" id="sch_name" class="frm_input" size="15">
				<button type="button" id="btn_search_item" class="btn_large">검색</button>
			</span>
			<div id="relation" class="srel_list">
				<p>카테고리를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>
			</div>
			<script>
			$(function() {
				$("#btn_search_item").click(function() {
					var sca = $("#sch_relation").val();
					var gname = $.trim($("#sch_name").val());
					var $relation = $("#relation");

					if(sca == "" && gname == "") {
						$relation.html("<p>카테고리를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>");
						return false;
					}

					$("#relation").load(
						bv_admin_url+"/goods/goods_form_relation.php",
						{ gs_id: "<?php echo $gs_id; ?>", mb_id: "<?php echo $gs[mb_id]; ?>", sca: sca, gname: gname }
					);
				});

				$(document).on("click", "#relation .add_item", function() {
					// 이미 등록된 상품인지 체크
					var $li = $(this).closest("li");
					var gs_id = $li.find("input:hidden").val();
					var gs_id2;
					var dup = false;
					$("#reg_relation input[name='re_gs_id[]']").each(function() {
						gs_id2 = $(this).val();
						if(gs_id == gs_id2) {
							dup = true;
							return false;
						}
					});

					if(dup) {
						alert("이미 선택된 상품입니다.");
						return false;
					}

					var cont = "<li>"+$li.html().replace("add_item", "del_item").replace("추가", "삭제")+"</li>";
					var count = $("#reg_relation li").size();

					if(count > 0) {
						$("#reg_relation li:last").after(cont);
					} else {
						$("#reg_relation").html("<ul>"+cont+"</ul>");
					}

					$li.remove();
				});

				$(document).on("click", "#reg_relation .del_item", function() {
					// if(!confirm("상품을 삭제하시겠습니까?"))
					//    return false;

					$(this).closest("li").remove();

					var count = $("#reg_relation li").size();
					if(count < 1)
						$("#reg_relation").html("<p>선택된 상품이 없습니다.</p>");
				});
			});
			</script>
		</section>

		<section class="compare_right">
			<h3>선택된 관련상품 목록</h3>
			<span class="srel_pad"></span>
			<div id="reg_relation" class="srel_sel">
				<?php
				$str = array();
				$sql = " select b.index_no, b.gname, b.simg1
						   from shop_goods_relation a left join shop_goods b ON (a.gs_id2=b.index_no)
						  where a.gs_id = '$gs_id'
						  order by ir_no asc ";
				$result = sql_query($sql);
				for($g=0; $row=sql_fetch_array($result); $g++)
				{
					$gname = get_it_image($row['index_no'], $row['simg1'], 50, 50).' '.$row['gname'];

					if($g==0)
						echo '<ul>';
				?>
					<li>
						<input type="hidden" name="re_gs_id[]" value="<?php echo $row['index_no']; ?>">
						<div class="list_item"><?php echo $gname; ?></div>
						<div class="list_item_btn"><button type="button" class="del_item btn_large">삭제</button></div>
					</li>
				<?php
					$str[] = $row['index_no'];
				}
				$str = implode(",", $str);

				if($g > 0)
					echo '</ul>';
				else
					echo '<p>선택된 상품이 없습니다.</p>';
				?>
			</div>
			<input type="hidden" name="gs_list" value="<?php echo $str; ?>">
		</section>
	</div>
</div>
</section>

<?php //echo $frm_submit; ?>

<section id="anc_sitfrm_img">
<h5 class="htag_title">상품이미지 및 상세정보</h5>
<?php echo $pg_anchor; ?>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">이미지 등록방식</th>
		<td>
            <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="simg_type" id="simg_type_1" value="0"<?php echo get_checked('0', $gs['simg_type']); ?> onclick="chk_simg_type(0);">
                    <label for="simg_type_1">직접 업로드</label>
                </li>
                <li class="radios">
                    <input type="radio" name="simg_type" id="simg_type_2" value="1"<?php echo get_checked('1', $gs['simg_type']); ?> onclick="chk_simg_type(1);">
                    <label for="simg_type_2">URL 입력</label>
                </li>
            </ul>
		</td>
	</tr>
	<?php
	for($i=1; $i<=6; $i++) {
		if($i == 1) {
			$item_wpx = $default['de_item_small_wpx'];
			$item_hpx = $default['de_item_small_hpx'];
		} else {
			$item_wpx = $default['de_item_medium_wpx'];
			$item_hpx = $default['de_item_medium_hpx'];
		}

		$image_str = '';
		if(in_array($i,array(1,2))) {
			$image_str = ' <strong class="fc_red">[필수]</strong>';
		}
	?>
	<tr class="item_img_fld">
		<th scope="row">이미지<?php echo $i; ?> <span class="fc_197">(<?php echo $item_wpx; ?> * <?php echo $item_hpx; ?>)</span><?php echo $image_str; ?></th>
		<td>
            <div class="file_wrap">
                <div class="item_file_fld">
                    <input type="file" name="simg<?php echo $i; ?>">
                    <?php echo get_look_ahead($gs['simg'.$i], "simg{$i}_del"); ?>
                </div>
                <div class="item_url_fld">
                    <input type="text" name="simg<?php echo $i; ?>" value="<?php echo $gs['simg'.$i]; ?>" class="frm_input" size="80" placeholder="http://">
                </div>
            </div>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<th scope="row">상세설명</th>
		<td>
			<?php echo editor_html('memo', get_text(stripcslashes($gs['memo']), 0)); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">관리자메모</th>
		<td><textarea name="admin_memo" class="frm_textbox"><?php echo $gs['admin_memo']; ?></textarea></td>
	</tr>
	</tbody>
	</table>
</div>
</section>

<?php echo $frm_submit; ?>
</form>

<script>
function fregform_submit(f) {
	var multi_caid = new Array();
	var new_caid = "";

	$("select#sel_ca_id option").each(function() {
        new_caid = $(this).val();
        if(new_caid == "")
            return true;

        multi_caid.push(new_caid);
    });

    if(multi_caid.length > 0) {
		$("input[name=ca_id]").val(multi_caid[0]);
		$("input[name=ca_id2]").val(multi_caid[1]);
		$("input[name=ca_id3]").val(multi_caid[2]);
	}

	if(!f.ca_id.value) {
        alert("카테고리를 하나이상 선택하세요.");
        return false;
    }

	var sel_count = $("select#sel_ca_id option").size();
	if(sel_count > 3) {
		alert('카테고리는 최대 3개까지만 등록 가능합니다.');
		return false;
	}

	var item = new Array();
    var re_item = gs_id = "";

    $("#reg_relation input[name='re_gs_id[]']").each(function() {
        gs_id = $(this).val();
        if(gs_id == "")
            return true;

        item.push(gs_id);
    });

    if(item.length > 0)
        re_item = item.join();

    $("input[name=gs_list]").val(re_item);

	<?php echo get_editor_js('memo'); ?>

	f.action = "./goods/goods_form_update.php";
    return true;
}

// 배송비 설정
function chk_sc_type(type) {
	switch(type) {
		case "0" : // 공통설정
			$("#sc_amt").hide();
			$("#sc_minimum").hide();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', true);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', false);
			break;
		case "1" : // 무료배송
			$("#sc_amt").hide();
			$("#sc_minimum").hide();
			$("#sc_method").hide();
			$("input[name=sc_amt]").attr('disabled', true);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', true);
			break;
		case "2" : // 조건부무료배송
			$("#sc_amt").show();
			$("#sc_minimum").show();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', false);
			$("input[name=sc_minimum]").attr('disabled', false);
			$("select[name=sc_method]").attr('disabled', false);
			break;
		case "3" : // 유료배송
			$("#sc_amt").show();
			$("#sc_minimum").hide();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', false);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', false);
			break;
	}
}

// 이미지 등록방식
function chk_simg_type(type) {
	if(type == 0) { // 직접업로드
		$(".item_file_fld").show();
		$(".item_url_fld").hide();
	} else { // URL 입력
		$(".item_img_fld").show();
		$(".item_file_fld").hide();
		$(".item_url_fld").show();
	}
}

// 재고수량 체크
function chk_stock(type) {
	if(type == 0) {
		$("input[name=stock_qty]").attr('disabled', true);
		$("input[name=noti_qty]").attr('disabled', true);
	} else {
		$("input[name=stock_qty]").attr('disabled', false);
		$("input[name=noti_qty]").attr('disabled', false);
	}
}

// 수수료 적용
function chk_ppay_type(type) {
	if(type == 0) {
		$("input[name=ppay_dan]").attr('disabled', true);
		$("select[name=ppay_rate]").attr('disabled', true);
		$("#chk_ppay_auto").text("가맹점관리 > 가맹점 수수료정책 (기본설정 사용중)");
	} else {
		$("input[name=ppay_dan]").attr('disabled', false);
		$("select[name=ppay_rate]").attr('disabled', false);
		$("#chk_ppay_auto").text("수수료를 적용할 단계를 입력하세요");
	}
}

function chk_ppay_dan(no, index){
	$.post(
		bv_admin_url+"/goods/goods_form_auto.php",
		{ "no": no, "index": index },
		function(data) {
			$("#chk_ppay_auto").empty().html(data);
		}
	);
}

const subZone = (target, areaname) => {
		let _this = target.nextElementSibling;

    $.ajax({
        type: "POST",
        url: "/admin/goods/ajax.subarea.php",
        data: {
            'areaname': areaname,
        },
        success: function (res) {
            res = JSON.parse(res);
            console.log(res);
						let newOption = "";

						_this.options.length=0;

            for (let i = 0; i < res.length; i++) {
								newOption = new Option(res[i].areaname2, res[i].areaname2);
								_this.append(newOption);
            }
        },
        error: function (xhr, status, error) {
            alert(error);
        }
    });
}


// 렌탈 추가 _20240701_SY
$('input[name=reg_yn]').on('click', function() {
  if(this.value == '3')  {
    $('input[name=price_msg]').val("상담신청");
    $('input[name=supply_price]').val(0);
    $('input[name=goods_price]').val(0);
    $('input[name=normal_price]').val(0);

    $('input[name=price_msg]').prop('readonly', true);
    $('input[name=supply_price]').prop('readonly', true);
    $('input[name=goods_price]').prop('readonly', true);
    $('input[name=normal_price]').prop('readonly', true);
  } else {
    $('input[name=price_msg]').val("");
    $('input[name=price_msg]').prop('readonly', false);
    $('input[name=supply_price]').prop('readonly', false);
    $('input[name=goods_price]').prop('readonly', false);
    $('input[name=normal_price]').prop('readonly', false);
  }
})
</script>

<script>
chk_sc_type("<?php echo $gs[sc_type]; ?>");
chk_simg_type("<?php echo $gs[simg_type]; ?>");
chk_stock("<?php echo $gs[stock_mod]; ?>");
chk_ppay_type("<?php echo $gs[ppay_type]; ?>");
<?php if($gs['ppay_dan']) { ?>
chk_ppay_dan("<?php echo $gs[ppay_dan]; ?>","<?php echo $gs[index_no]; ?>");
<?php } ?>
</script>
