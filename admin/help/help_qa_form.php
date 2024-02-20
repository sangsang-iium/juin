<?php
if(!defined('_BLUEVATION_')) exit;

if($w == "u") {
	$qa = sql_fetch("select * from shop_qa where index_no='$index_no'");
	if(!$qa['index_no'])
		alert("자료가 존재하지 않습니다.");
}

$qa['replyer'] = $qa['replyer'] ? $qa['replyer'] : $member['name'];
?>

<form name="fqaform" method="post" action="./help/help_qa_form_update.php">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">작성자 </th>
		<td><?php echo $qa['mb_id']; ?></td>
	</tr>
	<tr>
		<th scope="row">제목 </th>
		<td><?php echo $qa['subject']; ?></td>
	</tr>
	<tr>
		<th scope="row">내용 </th>
		<td><?php echo nl2br($qa['memo']); ?></td>
	</tr>
	<tr>
		<th scope="row">답변자</th>
		<td>
			<input type="text" name="replyer" value="<?php echo $qa['replyer']; ?>" required itemname="답변자" class="frm_input required">
		</td>
	</tr>
	<tr>
		<th scope="row">답변내용</th>
		<td><textarea name="reply" class="frm_textbox"><?php echo $qa['reply']; ?></textarea></td>
	</tr>
	<?php if($qa['result_yes']) {?>
	<tr>
		<th scope="row">답변일</th>
		<td><?php echo $qa['result_date']; ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
	<a href="./help.php?code=qa<?php echo $qstr; ?>&page=<?php echo $page; ?>" class="btn_large bx-white">목록</a>
</div>
</form>
