<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

$sql = "select * from shop_used where mb_id = '{$member['id']}' and del_yn = 'N' order by 1 desc";
$result = sql_query($sql);
$rows = sql_num_rows($result);
?>

<div id="contents" class="sub-contents usedList">
  <div class="container used-prod_list">
<?php
if($rows == 0){
    echo '<p class="empty_list">자료가 없습니다.</p>';
} else {
    while($row=sql_fetch_array($result)){
        if($row['m_img']){
            $thumb = BV_DATA_URL.'/used/'.$row['m_img'];
        } else {
            $thumb = '/src/img/used/t-item_thumb1.jpg';
        }
        $gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
        $goodyn = getUsedGoodRegister($row['no'], $member['id']);
        
        echo '<div class="used-item">';
        echo '<a href="./view.php?no='.$row['no'].'" class="used-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['title'].'"></a>';
        echo '<div class="used-item_txtBox">';
        echo '<a href="./view.php?no='.$row['no'].'" class="tRow2 title"><span class="cate">['.$row['category'].']</span><span class="subj">'.$row['title'].'</span></a>';
        echo '<p class="writer"><span>'.getMemberName($row['mb_id']).'</span><span>'.getUsedAddress($row['address']).'</span></p>';
        echo '<ul class="inf"><li><p class="prc">'.number_format($row['price']).'<span class="won">원</span></p></li>';
        if($row['gubun']){
            echo '<li><span class="status ing">'.$gubun_status[0].'</span></li></ul>';
        } else if($row['status']=='1'){
            echo '<li><span class="status resv">'.$gubun_status[1].'</span></li></ul>';
        } else if($row['status']=='2'){
            echo '<li><span class="status end">'.$gubun_status[1].'</span></li></ul>';
        } else {
            echo '<li><span class="status ing">'.$gubun_status[1].'</span></li></ul>';
        }
        echo '<ul class="extra">';
        echo '<li class="hit"><span class="icon"><img src="/src/img/used/icon_hit.png" alt="조회수"></span><span class="text">'.$row['hit'].'</span></li>';
        echo '<li class="like"><span class="icon"><img src="/src/img/used/icon_like.png" alt="좋아요수"></span><span class="text">'.getUsedGoodCount($row['no']).'</span></li>';
        echo '<li class="reply"><span class="icon"><img src="/src/img/used/icon_chat.png" alt="채팅수"></span><span class="text">'.getUsedChatCount($row['no']).'</span></li>';
        echo '</ul>';
        echo '<div class="used-my-btn-wr">';
        echo '<a href="./write.php?no='.$row['no'].'&my_list=1" class="ui-btn st1 sizeS">수정</a>';
        echo '<button type="button" class="ui-btn stBlack sizeS" onclick="usedGoodDelete('.$row['no'].');">삭제</button>';
        echo '</div>';
        echo '</div></div>';
    }
}
?>
  </div>
</div>

<script>
const seller = "<?php echo $member['id'] ?>";
function usedGoodDelete(gno){
    if(confirm("상품을 삭제하시겠습니까?\n삭제하시면 복구 하실수 없습니다.")){
        $.post("ajax.used_delete.php", {seller:seller, gno:gno}, function(obj){
            if(obj.trim()=='Y'){
                location.reload();
            } else {
                alert(obj);
            }
        });
    }
}
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>