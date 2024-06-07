<?php
if(!defined('_BLUEVATION_')) exit;

$sql = "select a.*, b.mb_id as target_id, b.title from shop_used_singo AS a join shop_used AS b on a.pno = b.no where a.no = '$no'";
$row = sql_fetch($sql);
if(!$row['no'])
	alert("자료가 존재하지 않습니다.");

$smb = get_member($row['mb_id']);
$tmb = get_member($row['target_id']);
?>

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">판매글 제목</th>
		<td><?php echo $row['title']; ?></td>
	</tr>
	<tr>
		<th scope="row">신고자</th>
		<td><?php echo $smb['name'].'('.$smb['id'].')'; ?></td>
	</tr>
	<tr>
		<th scope="row">대상자</th>
		<td><?php echo $tmb['name'].'('.$tmb['id'].')'; ?></td>
	</tr>
	<tr>
		<th scope="row">신고사유</th>
		<td><?php echo $row['category']; ?></td>
	</tr>
	<tr>
		<th scope="row">상세내용</th>
		<td><?php echo nl2br($row['content']); ?></td>
	</tr>
	<tr>
		<th scope="row">참고이미지</th>
		<td><?php echo ($row['img']) ? '<img src="'.BV_DATA_URL.'/singo/'.$row['img'].'">' : ''; ?></td>
	</tr>
	<tr>
		<th scope="row">신고일시</th>
		<td><?php echo $row['regdate']; ?></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
<?php
$link = './help.php?code=singo&sfl='.$sfl.'&stx='.$stx.'&fr_date='.$fr_date.'&to_date='.$to_date.'&page='.$page;

if($row['status']){
    echo '<a href="'.$link.'" class="btn_large bx-white">목록</a>';
} else {
    echo '<input type="button" value="게시글 삭제" onclick="singoUsedDelete('.$row['pno'].',\''.$row['title'].'\','.$row['no'].')" class="btn_large" style="background:#ef4836 !important;border:1px solid #ef4836"> &nbsp;';
    echo '<a href="/m/used/view.php?no='.$row['pno'].'" target="_blank" class="btn_large">바로가기</a> &nbsp;';
    echo '<a href="'.$link.'" class="btn_large bx-white">목록</a>';
}
?>
</div>


<script>
function singoUsedDelete(pno, title, sno){
    if(confirm('['+title+']\n판매글을 삭제하시겠습니까?\n삭제하시면 복구하실 수 없습니다.')){
        $.post(bv_admin_url+"/help/ajax.used.del.php", {pno:pno,sno:sno}, function(obj){
            if(obj=='Y'){
                location.reload();
            }
        })
    }
}
</script>