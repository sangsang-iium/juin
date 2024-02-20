<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fregform" method="post" action="./design/menu_form_update.php">
<input type="hidden" name="token" value="">

<h2>메뉴 설정</h2>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col width="80px">
		<col width="50px">
		<col width="200px">
		<col width="200px">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th>구분</th>
		<th>노출</th>
		<th>메뉴</th>
		<th>기본</th>
		<th>URL</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $i<count($gw_menu); $i++) {
		$seq = ($i+1);
	?>
	<tr>
		<td class="list1">메뉴<?php echo $seq; ?></td>
		<td><input type="checkbox" name="de_pname_use_<?php echo $seq; ?>" value="1"<?php echo $default['de_pname_use_'.$seq]?' checked':''; ?>></td>
		<td><input type="text" name="de_pname_<?php echo $seq; ?>" value="<?php echo $default['de_pname_'.$seq]; ?>" class="frm_input" placeholder="메뉴명"></td>
		<td class="tal"><?php echo $gw_menu[$i][0]; ?></td>
		<td class="tal"><?php echo $gw_menu[$i][1]; ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
