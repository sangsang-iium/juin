<?php
if(!defined('_BLUEVATION_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = BV_TIME_YMD;
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = BV_TIME_YMD;

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="board_table">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col style="width:auto">
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">기간검색</th>
		<td>
            <div class="tel_input">
			    <?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date, false); ?>
            </div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="board_btns tac mart20">
	<input type="submit" value="검색" class="btn_acc">
</div>
</form>

<script>
$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
