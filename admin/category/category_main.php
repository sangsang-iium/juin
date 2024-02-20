<?php
if(!defined('_BLUEVATION_')) exit;

if(isset($sel_ca1)) $qstr .= '&sel_ca1=' . $sel_ca1;
if(isset($sel_ca2)) $qstr .= '&sel_ca2=' . $sel_ca2;
if(isset($sel_ca3)) $qstr .= '&sel_ca3=' . $sel_ca3;
if(isset($sel_ca4)) $qstr .= '&sel_ca4=' . $sel_ca4;

$query_string = "code=$code$qstr";
$q1 = $query_string;

$sql_order = " order by caterank, catecode ";
?>

<h2>카테고리 등록</h2>
<form name="fcategoryform" method="post" action="./category/category_main_update.php" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">카테고리 소속</th>
		<td>
			<?php echo get_category_select_1('sel_ca1', $sel_ca1); ?>
			<?php echo get_category_select_2('sel_ca2', $sel_ca2); ?>
			<?php echo get_category_select_3('sel_ca3', $sel_ca3); ?>
			<?php echo get_category_select_4('sel_ca4', $sel_ca4); ?>

			<script>
			$(function() {
				$("#sel_ca1").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca2").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca3").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
				$("#sel_ca4").multi_select_box("#sel_ca",4,"","=카테고리선택=");
			});
			</script>
		</td>
	</tr>
	<tr>
		<th scope="row">카테고리명</th>
		<td><input type="text" name="catename" required itemname="카테고리명" class="frm_input required" size="50"></td>
	</tr>
	<tr>
		<th scope="row">카테고리 메인 이미지</th>
		<td><input type="file" name="headimg"></td>
	</tr>

	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" class="btn_large" value="저장">
</div>
</form>

<div class="sho_cate_bx mart30">
	<form name="frm_sel_ca1" method="post" target="hiddenframe">
			<input type="hidden" name="W" value="sel_ca1">
			<select multiple name="sel_ca1[]" id="sel_ca1" class="multiple-select2">
			<?php
			$sql = " select catecode, catename
					   from shop_category
					  where length(catecode) = '3'
					  order by caterank, catecode ";
			$result = sql_query($sql);
			for($i=0; $row=sql_fetch_array($result); $i++) {
				echo '<option value="'.$row['catecode'].'">'.$row['catename'].'</option>'.PHP_EOL;
			}
			?>
			</select>
			<div class="btn_confirm03">
				<button type="button" class="btn_small bx-white" onclick="category_move('sel_ca1', 'prev')">▲ 위로</button>
				<button type="button" class="btn_small bx-white" onclick="category_move('sel_ca1', 'next')">▼ 아래로</button>
				<button type="button" class="btn_small sel_submit">저장</button>
			</div>
			</form>

			<div id="load_sel_ca<?php echo $i; ?>">
				<div class="sit_selbox_info"></div>
			</div>

</div>

<script>
// POST 방식으로 삭제
function post_delete(action_url, val)
{
	var f = document.fpost;

	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        f.ca_no.value = val;
		f.action = action_url;
		f.submit();
	}
}

function modok(no)
{
	document.all['cos'+no].src = "<?php echo BV_ADMIN_URL; ?>/category/category_mod.php?index_no="+no;
	document.all['co'+no].style.display = "";
}

$(function(){
	var opt = "";
	opt += "<select multiple class=\"multiple-select2\"></select>\n";
	opt += "<div class=\"btn_confirm03\">\n";
	opt += "<button type=\"button\" class=\"btn_small bx-white\">▲ 위로</button>\n";
	opt += "<button type=\"button\" class=\"btn_small bx-white\">▼ 아래로</button>\n";
	opt += "<button type=\"button\" class=\"btn_small\">저장</button>\n";
	opt += "</div>";

	// 2~5차 분류는 초기값으로 세팅
	$(".sit_selbox_info").empty().html(opt);

	// 분류 클릭에 따른 적용값
	$("#sel_ca1, #sel_ca2, #sel_ca3, #sel_ca4").live("change", function() {
		var opt_id = $(this).attr("id");
		var opt_nm = opt_id.replace(/[^0-9]/g, "");
		var opt_st = opt_id.replace(/[^a-z_]/g, "");
		var sel_id = opt_st + (parseInt(opt_nm) + 1);
		var catecode = $("#"+opt_id+" option:selected").val();

		var obj = { load_sel_ca2:2, load_sel_ca3:3, load_sel_ca4:4, load_sel_ca5:5 };
		jQuery.each(obj, function(sel, idx) {
			if(idx > parseInt(opt_nm)) {
				$("#"+sel).empty().html(opt);
			}
		});

		$.post(
			"./category/category_view_select.php",
			{ catecode: catecode, sel_id: sel_id },
			function(data) {
				$("#load_"+sel_id).empty().html(data);
			}
		);
	});

	// 저장 (FRAME 방식)
	$("button.sel_submit").live("click", function() {
		var $sel_id = $(this).closest("form").attr("select","id");
		var bchk = false;

		$sel_id.find('option').each(function() {
			$(this).attr("selected", "selected");
			bchk = true;
		});

		if(!bchk) {
			alert("처리할 항목이 없습니다");
			return;
		} else {
			$(this).closest("form").attr('action', './category/category_view_update.php').submit();
		}
	});
});
</script>

<form name="fpost" method="post">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="ca_no" value="">
</form>
