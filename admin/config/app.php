<?php
if(!defined('_BLUEVATION_')) exit;

$sql = "SELECT * FROM iu_app WHERE idx = 1";
$app = sql_fetch($sql);
?>

<style>
	.frm_input {
		width:400px;
	}
</style>

<form name="fregform" method="post" action="./config/app_update.php" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<h2>앱 관리</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="ia_aos_ver">안드로이드 버전코드</label></th>
		<td>
			<input type="text" name="ia_aos_ver" value="<?php echo $app['ia_aos_ver']; ?>" id="ia_aos_ver" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_aos_url">안드로이드 스토어 URL</label></th>
		<td>
			<input type="text" name="ia_aos_url" value="<?php echo $app['ia_aos_url']; ?>" id="ia_aos_url" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_ios_ver">아이폰 버전코드</label></th>
		<td>
			<input type="text" name="ia_ios_ver" value="<?php echo $app['ia_ios_ver']; ?>" id="ia_ios_ver" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_ios_url">아이폰 스토어 URL</label></th>
		<td>
			<input type="text" name="ia_ios_url" value="<?php echo $app['ia_ios_url']; ?>" id="ia_ios_url" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_puse">긴급공지사항 사용 유무</label></th>
		<td>
			<select name="ia_puse" id="ia_puse">
				<option value="Y" <?php echo $app['ia_puse']=="Y"?"selected":""; ?>>노출</option>
				<option value="N" <?php echo $app['ia_puse']=="N"?"selected":""; ?>>미노출</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_pname">긴급공지사항 제목</label></th>
		<td>
			<input type="text" name="ia_pname" value="<?php echo $app['ia_pname']; ?>" id="ia_pname" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_pvalue">긴급공지사항 내용</label></th>
		<td>
			<input type="text" name="ia_pvalue" value="<?php echo $app['ia_pvalue']; ?>" id="ia_pvalue" class="frm_input" >
		</td>
	</tr>


	<tr>
		<th scope="row"><label for="ia_iuse">앱점검 사용 유무</label></th>
		<td>
			<select name="ia_iuse" id="ia_iuse">
				<option value="Y" <?php echo $app['ia_iuse']=="Y"?"selected":""; ?>>노출</option>
				<option value="N" <?php echo $app['ia_iuse']=="N"?"selected":""; ?>>미노출</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_iname">앱점검 제목</label></th>
		<td>
			<input type="text" name="ia_iname" value="<?php echo $app['ia_iname']; ?>" id="ia_iname" class="frm_input" >
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ia_ivalue">앱점검 내용</label></th>
		<td>
			<input type="text" name="ia_ivalue" value="<?php echo $app['ia_ivalue']; ?>" id="ia_ivalue" class="frm_input" >
		</td>
	</tr>
	</tbody>
	</table>
</div>



<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
