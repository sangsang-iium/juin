<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fregform" method="post" action="./design/menu_form_update.php">
<input type="hidden" name="token" value="">

<h5 class="htag_title">메뉴 설정</h5>
<p class="gap20"></p>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col width="50px">
		<col width="100px">
		<col width="200px">
		<col width="300px">
		<col width="70px">
	</colgroup>
	<thead>
	<tr>
		<th>번호</th>
		<th>노출</th>
		<th>메뉴</th>
		<th>URL</th>
		<th>순서</th>
	</tr>
	</thead>
	<tbody>
	<?php

	$sql = "SELECT * FROM shop_menu ORDER BY m_idx ASC";
	$res = sql_query($sql);
	for($i=0; $row = sql_fetch_array($res); $i++) {
	?>
	<tr>
		<td class="list1"><?php echo $row['m_idx'] ?><input type="hidden" name="m_idx[]" value="<?php echo $row['m_idx'] ?>"></td>
		<td><input type="checkbox" name="m_yn[<?php echo $i?>]" value="Y" <?php echo $row['m_yn'] == "Y"?' checked':''; ?>></td>
		<td><input type="text" name="m_name[<?php echo $i?>]" value="<?php echo $row['m_name']; ?>" class="frm_input" placeholder="메뉴명"></td>
		<td><input type="text" name="m_url[<?php echo $i?>]" value="<?php echo $row['m_url']; ?>" class="frm_input" placeholder="url"></td>
		<td><input type="number" name="m_seq[<?php echo $i?>]" value="<?php echo $row['m_seq']?>"></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
