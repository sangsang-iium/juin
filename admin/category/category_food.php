<?php
if(!defined('_BLUEVATION_')) exit;
?>

<h2>음식점 카테고리 관리</h2>
<form name="fcategoryform" method="post" action="./category/category_update2.php">
<input type="hidden" name="code" value="food">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">카테고리</th>
		<td>
		    <input type="text" name="category" value="<?php echo $config['cf_food'] ?>" required class="frm_input required" size="100">
		    <?php echo help("카테고리를 '|'으로 구분하여 입력하세요."); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" class="btn_large" value="저장">
</div>
</form>