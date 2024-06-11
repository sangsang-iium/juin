<?php
if(!defined('_BLUEVATION_')) exit;

$sql = "select a.*, b.mb_id as target_id, b.title from shop_used_singo AS a join shop_used AS b on a.pno = b.no where a.no = '$no'";
$row = sql_fetch($sql);
if(!$row['no'])
	alert("자료가 존재하지 않습니다.");

$smb = get_member($row['mb_id']);
$tmb = get_member($row['target_id']);
?>

<div class="board_table">
	<table class="viewer_type">
        <colgroup>
            <col width="220px">
            <col>
            <col width="220px">
            <col>
        </colgroup>
        <tbody>
            <tr class="viewr_title">
                <th colspan="4"><?php echo $row['title']; ?></th>
                <!-- <td><?php echo $row['title']; ?></td> -->
            </tr>
            <tr>
                <th scope="row">신고자</th>
                <td><?php echo $smb['name'].'('.$smb['id'].')'; ?></td>
                <th scope="row">대상자</th>
                <td><?php echo $tmb['name'].'('.$tmb['id'].')'; ?></td>
            </tr>
            <tr>
                <th scope="row">신고사유</th>
                <td><?php echo $row['category']; ?></td>
                <th scope="row">신고일시</th>
                <td><?php echo $row['regdate']; ?></td>
            </tr>
            <tr>
                <th scope="row">상세내용</th>
                <td colspan="3"><?php echo nl2br($row['content']); ?></td>
            </tr>
            <tr>
                <!-- <th scope="row">참고이미지</th> -->
                <td colspan="4"><?php echo ($row['img']) ? '<img src="'.BV_DATA_URL.'/singo/'.$row['img'].'">' : ''; ?></td>
                
            </tr>
        </tbody>
	</table>
</div>

<div class="btn_wrap mart30">
<?php
$link = './help.php?code=singo&sfl='.$sfl.'&stx='.$stx.'&fr_date='.$fr_date.'&to_date='.$to_date.'&page='.$page;

if($row['status']){
    echo '<a href="'.$link.'" class="btn_list bg_type1"><span>목록</span></a>';
} else {
    echo '<input type="button" value="게시글 삭제" onclick="singoUsedDelete('.$row['pno'].',\''.$row['title'].'\','.$row['no'].')" class="btn_del" >';
    echo '<a href="/m/used/view.php?no='.$row['pno'].'" target="_blank" class="go color_type"><span>바로가기</span></a>';
    echo '<a href="'.$link.'" class="btn_list bg_type1"><span>목록</span></a>';
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