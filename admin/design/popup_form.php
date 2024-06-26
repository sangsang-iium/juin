<?php
if(!defined('_BLUEVATION_')) exit;

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if($w == "") {
	$nw['state'] = 0;
	$nw['begin_date'] = BV_TIME_YMD;
	$nw['device'] = 'both';
} else if($w == "u") {
	$nw = sql_fetch("select * from shop_popup where index_no='$pp_id'");
    if(!$nw['index_no'])
        alert("팝업이 존재하지 않습니다.");
}
?>

<form name="fregform" method="post" action="./design/popup_form_update.php" onsubmit="return fregform_submit(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="pp_id" value="<?php echo $pp_id; ?>">

<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">접속기기</th>
		<td>
            <div class="chk_select">
                <select name="device">
                    <?php echo option_selected('both',   $nw['device'], "PC와 모바일"); ?>
                    <?php echo option_selected('pc',     $nw['device'], "PC"); ?>
                    <?php echo option_selected('mobile', $nw['device'], "모바일"); ?>
                </select>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">팝업크기(pixel)</th>
		<td>
			<input type="text" name="width" value="<?php echo $nw['width']; ?>" required numeric itemname="팝업크기" class="required frm_input w80"> X <input type="text" name="height" value="<?php echo $nw['height']; ?>" required numeric itemname="팝업크기" class="required frm_input w80"></td>
		</td>
	</tr>
	<tr>
		<th scope="row">팝업위치(pixel)</th>
		<td>
			<input type="text" name="top" value="<?php echo $nw['top']; ?>" required numeric itemname="팝업위치" class="required frm_input w80"> X <input type="text" name="lefts" value="<?php echo $nw['lefts']; ?>" required numeric itemname="팝업위치" class="required frm_input w80"></td>
		</td>
	</tr>
	<tr>
		<th scope="row">실행기간</th>
		<td>
			<input type="text" name="begin_date" value="<?php echo $nw['begin_date']; ?>" id="begin_date" required itemname="실행기간" class="required frm_input w120"> ~
			<input type="text" name="end_date" value="<?php echo $nw['end_date']; ?>" id="end_date" required itemname="실행기간" class="required frm_input w120">
		</td>
	</tr>
	<tr>
		<th scope="row">노출여부</th>
		<td class="">
            <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="state" value="0" id="state_yes"<?php echo ($nw['state']==0)?" checked":""; ?>>
                    <label for="state_yes">노출함</label>
                </li>
                <li>
                    <input type="radio" name="state" value="1" id="state_no"<?php echo ($nw['state']==1)?" checked":""; ?>>
                    <label for="state_no">노출안함</label>
                </li>
            </ul>
		</td>
	</tr>
	<tr>
		<th scope="row">팝업제목</th>
		<td><input type="text" name="title" value="<?php echo get_text($nw['title']); ?>" required itemname="팝업 제목" class="required frm_input" size="80"></td>
	</tr>
	<tr>
		<th scope="row">팝업내용</th>
		<td>
			<?php echo editor_html('memo', get_text($nw['memo'], 0)); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_wrap mart30">
	<input type="submit" value="저장" class="btn_write" accesskey="s">
	<a href="./design.php?code=popup_list<?php echo $qstr; ?>&page=<?php echo $page; ?>" class="btn_list bg_type1"><span>목록</span></a>
</div>
</form>

<script>
function fregform_submit(f) {
	<?php echo get_editor_js('memo'); ?>

    return true;
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#begin_date,#end_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99"});
});
</script>
