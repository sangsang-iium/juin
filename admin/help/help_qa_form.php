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

<div class="board_table">
	<table class="viewer_type">
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr class="viewr_title">
		<!-- <th scope="row">작성자 </th> -->
		<th colspan="2"><?php echo $qa['mb_id']; ?></th>
	</tr>
	<tr>
		<th scope="row">제목 </th>
		<td><?php echo $qa['subject']; ?></td>
	</tr>
	<tr>
		<th scope="row">내용 </th>
		<td>
			<?php echo nl2br($qa['memo']); ?>
			<?php 
			if($qa['imgUpload1']){
			?><div>
				<img src="/data/qa/<?=$qa['imgUpload1']?>">
				</div>
			<?php	
			}
			if($qa['imgUpload2']){
				?>
					<div><img src="/data/qa/<?=$qa['imgUpload2']?>"></div>
				<?php	
			}
			if($qa['imgUpload3']){
				?>
				<div><img src="/data/qa/<?=$qa['imgUpload3']?>"></div> 
				<?php	
			}
			if($qa['imgUpload4']){
				?><div>
					<img src="/data/qa/<?=$qa['imgUpload4']?>">	
				</div>
					
				<?php	
			}
			if($qa['imgUpload5']){
				?><div><img src="/data/qa/<?=$qa['imgUpload5']?>"></div> 
				<?php	
			}

		?>
	
	</td>
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
