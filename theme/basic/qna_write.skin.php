<?php
if(!defined('_BLUEVATION_')) exit;

include_once(BV_THEME_PATH.'/aside_cs.skin.php');
?>

<div id="con_lf">
	<h2 class="pg_tit">
		<span><?php echo $tb['title']; ?></span>
		<p class="pg_nav">HOME<i>&gt;</i>고객센터<i>&gt;</i><?php echo $tb['title']; ?></p>
	</h2>

	<form name="fqaform" id="fqaform" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return fqaform_submit(this);" autocomplete="off">
	<input type="hidden" name="mode" value="w">
	<input type="hidden" name="token" value="<?php echo $token; ?>">

	<div class="tbl_frm02 tbl_wrap">
		<table>
		<colgroup>
			<col class="w100">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">질문유형</th>
			<td>
				<select name="catename" required itemname="질문유형">
					<option value="">문의하실 유형을 선택하세요</option>
					<?php
					$sql = "select * from shop_qa_cate where isuse='Y'";
					$res = sql_query($sql);
					while($row=sql_fetch_array($res)) {
						echo "<option value='$row[catename]'>$row[catename]</option>\n";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">제목</th>
			<td><input type="text" name="subject" required itemname="제목" class="frm_input wfull required"></td>
		</tr>
		<tr>
			<th scope="row">내용</th>
			<td><textarea name="memo" required itemname="내용" class="frm_textbox wfull required"></textarea></td>
		</tr>
		<tr>
			<th scope="row">이메일</th>
			<td class="td_label">
				<input type="text" name="email" value="<?php echo $member['email']; ?>" class="frm_input">
				<p class="mart7">
					<span class="marr10">답변 내용을 메일로 받아보시겠습니까?</span>
					<label><input type="radio" name="email_send_yes" value="1"> 예</label>
					<label><input type="radio" name="email_send_yes" value="0" checked> 아니오</label>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row">휴대폰</th>
			<td class="td_label">
				<input type="text" name="cellphone" value="<?php echo $member['cellphone']; ?>" class="frm_input">
				<p class="mart7">
					<span class="marr10">답변 여부를 문자로 받아보시겠습니까?</span>
					<label><input type="radio" name="sms_send_yes" value="1"> 예</label>
					<label><input type="radio" name="sms_send_yes" value="0" checked> 아니오</label>
				</p>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<div class="btn_confirm">
		<input type="submit" value="글쓰기" class="btn_lsmall">
		<a href="javascript:history.go(-1);" class="btn_lsmall bx-white">취소</a>
	</div>
	</form>
</div>

<script>
function fqaform_submit(f) {
	if(confirm("등록 하시겠습니까?") == false)
		return false;

	return true;
}
</script>
