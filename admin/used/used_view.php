<?php
if(!defined('_BLUEVATION_')) exit;

if(is_numeric($no)){
    $row = sql_fetch("select * from shop_used where no = '$no'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
}

$qstr .= "&gubun=".$gubun."&page=".$page;

$gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
?>

<h2>게시글 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">유형(*)</th>
		<td><?php echo $gubun_status[0] ?></td>
	</tr>
	<tr>
		<th scope="row">상태(*)</th>
		<td><?php echo $gubun_status[1] ?></td>
	</tr>
	<tr>
		<th scope="row">분류(*)</th>
		<td><?php echo $row['category'] ?></td>
	</tr>
	<tr>
		<th scope="row">제목</th>
		<td><?php echo $row['title'] ?></td>
	</tr>
	<tr>
		<th scope="row">설명</th>
		<td><?php echo nl2br($row['content']) ?></td>
	</tr>
	<tr>
		<th scope="row">거래장소</th>
		<td><?php echo $row['address'] ?></td>
	</tr>
	<tr>
		<th scope="row">대표이미지 (jpg, gif, png)</th>
		<td>		    
		    <?php
		    if($row['m_img']){
		        echo '<div class="fl w20p"><img src="'.BV_DATA_URL.'/used/'.$row['m_img'].'" class="w90p"></div>';
		    }
		    ?>
		</td>
	</tr>
	<tr>
		<th scope="row">상세이미지 (jpg, gif, png)</th>
		<td>
		<?php
		$sub_imgs = explode("|", $row['s_img']);
		$sub_imgs = array_filter($sub_imgs);
		$sub_imgs = array_values($sub_imgs);
		for($i=0;$i < 5;$i++){
		    if($sub_imgs[$i]){
		        echo '<div class="fl w20p"><img src="'.BV_DATA_URL.'/used/'.$sub_imgs[$i].'" class="w90p"></div>';
		    }
		}
		?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<a href="<?php echo BV_ADMIN_URL.'/used.php?code=list'.$qstr; ?>" class="btn_large">목록</a>
</div>

<h2 class="mart30">댓글 리스트</h2>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w200">
		<col>
		<col class="w200">
		<col class="w100">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">No</th>
		<th scope="col">작성자</th>
		<th scope="col">내용</th>
		<th scope="col">등록일시</th>
		<th scope="col">삭제</th>
	</tr>
	</thead>
	<?php
	$sql = "select * from shop_used_comment where pno = '$no' order by no desc";
	$result = sql_query($sql);
	for ($i = 0; $row = sql_fetch_array($result); $i++) {
		if ($i == 0) {
			echo '<tbody class="list">' . PHP_EOL;
		}

  	    $bg = 'list' . ($i % 2);
  	    $mb = get_member($row['mb_id']);
    ?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo ($i+1); ?></td>
		<td><?php echo $mb['id'].'('.$mb['name'].')'; ?></td>
		<td class="tal"><?php echo nl2br($row['content']); ?></td>
		<td><?php echo $row['regdate']; ?></td>
		<td><a href="#none" class="btn_ssmall red" onclick="commentDelete(<?php echo $row['no'] ?>);">삭제</a></td>
	</tr>
	<?php
    }
	if ($i == 0) {
		echo '<tbody><tr><td colspan="5" class="empty_table">댓글이 없습니다.</td></tr>';
	}
?>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<a href="<?php echo BV_ADMIN_URL.'/used.php?code=list'.$qstr; ?>" class="btn_large">목록</a>
</div>

<script>
function commentDelete(no){
    if(confirm("댓글을 삭제하시겠습니까?\n삭제하시면 복구하실 수 없습니다.")){
        $.post(bv_admin_url+"/used/ajax.comment.del.php", {no:no}, function(obj){
            if(obj=='Y'){
                location.reload();
            }
        })
    }
}
</script>