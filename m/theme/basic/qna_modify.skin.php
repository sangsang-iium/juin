<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<div id="contents">

	<form name="fqaform" id="fqaform" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return fqaform_submit(this);" autocomplete="off">
		<input type="hidden" name="mode" value="w">
		<input type="hidden" name="token" value="<?php echo $token; ?>">
		<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">

		<div class="form-faq-wrap">
			<div class="container">

				<!-- <div class="m_bo_bg">
					<div class="m_bo_wrap">
						<table class="tbl03">
						<colgroup>
							<col style="width:70px">
							<col style="width:auto">
						</colgroup>
						<tbody>
						<tr>
							<th>질문유형</th>
							<td>
								<select name="catename" class="wfull">
									<option value="">문의하실 유형을 선택하세요</option>
									<?php
									$sql = "select * from shop_qa_cate where isuse='Y'";
									$res = sql_query($sql);
									while($row=sql_fetch_array($res)) {
										echo "<option ".get_selected($qa['catename'],$row['catename'])." value='$row[catename]'>$row[catename]</option>\n";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>제목</th>
							<td><input type="text" name="subject" value="<?php echo $qa['subject']; ?>"></td>
						</tr>
						<tr>
							<th>내용</th>
							<td><textarea name="memo" rows="7"><?php echo $qa['memo']; ?></textarea></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td>
								<input type="text" name="email" value="<?php echo $qa['email']; ?>">
								<p class="mart5 fs12">
									<span class="marr10">답변 내용을 메일로 받아보시겠습니까?</span>
									<input type="checkbox" name="email_send_yes" value="1" <?php echo get_checked($qa['email_send_yes'],'1'); ?> id="email_send_yes" class="css-checkbox lrg"> <label for="email_send_yes" class="css-label">예</label>
								</p>
							</td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td>
								<input type="text" name="cellphone" value="<?php echo $qa['cellphone']; ?>">
								<p class="mart5 fs12">
									<span class="marr10">답변 여부를 문자로 받아보시겠습니까?</span>
									<input type="checkbox" name="sms_send_yes" value="1" <?php echo get_checked($qa['sms_send_yes'],'1'); ?> id="sms_send_yes" class="css-checkbox lrg"> <label for="sms_send_yes" class="css-label">예</label>
								</p>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
					<div class="btn_confirm">	
						<input type="submit" value="수정" class="btn_medium">
						<a href="javascript:history.go(-1);" class="btn_medium bx-white">취소</a>
					</div>	
				</div> -->

				<div class="form-row">
					<div class="form-head">
						<p class="title">질문유형<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="catename" class="frm-select">
							<option value="">문의하실 유형을 선택하세요</option>
							<?php
							$sql = "select * from shop_qa_cate where isuse='Y'";
							$res = sql_query($sql);
							while($row=sql_fetch_array($res)) {
								echo "<option ".get_selected($qa['catename'],$row['catename'])." value='$row[catename]'>$row[catename]</option>\n";
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">제목<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="subject" value="<?php echo $qa['subject']; ?>" class="frm-input">
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">질문내용<b>*</b></p>
					</div>
					<div class="form-body">
						<textarea name="memo" rows="7" class="frm-txtar w-per100"><?php echo $qa['memo']; ?></textarea>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">이메일</p>
					</div>
					<div class="form-body">
						<input type="text" name="email" value="<?php echo $qa['email']; ?>" class="frm-input">
						<div class="frm-choice">
							<input type="checkbox" name="email_send_yes" value="1" <?php echo get_checked($qa['email_send_yes'],'1'); ?> id="email_send_yes" class="css-checkbox lrg">
							<label for="email_send_yes">답변 내용을 메일로 받아보시겠습니까?</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">휴대폰</p>
					</div>
					<div class="form-body">
						<input type="text" name="cellphone" value="<?php echo $qa['cellphone']; ?>" class="frm-input">
						<div class="frm-choice">
							<input type="checkbox" name="sms_send_yes" value="1" <?php echo get_checked($qa['sms_send_yes'],'1'); ?> id="sms_send_yes" class="css-checkbox lrg">
							<label for="sms_send_yes">답변 여부를 문자로 받아보시겠습니까?</label>
						</div>
					</div>
				</div>

				<div class="cp-btnbar">
					<div class="container">
						<div class="cp-btnbar__btns">
							<input type="submit" value="수정" class="ui-btn round stBlack">
							<!-- <a href="javascript:history.go(-1);" class="btn_medium bx-white">취소</a> -->
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>

</div>

<script>
function fqaform_submit(f) {
	if(confirm("수정 하시겠습니까?") == false)
		return false;

	return true;
}
</script>
