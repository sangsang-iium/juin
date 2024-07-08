<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

$my_id = $member['id'];
$sql = "select * from shop_used_chat where pno IN (select no from shop_used where mb_id='$my_id' and del_yn='N') and block = 1 order by blockdate desc";
$result = sql_query($sql);
?>

<div id="contents" class="sub-contents blockedList">
  <div class="container blocked-user_list">
  <?php
  if(empty($result)){
    echo '<p class="empty_list">자료가 없습니다.</p>';
  } else {
    while($row=sql_fetch_array($result)){
  ?>
    <div class="blockedUser-item">
      <div class="blockedUser-left">
        <p class="user-id"><?php echo $row['mb_id'] ?></p>
      </div>
      <div class="blockedUser-right">
        <p class="blocked-date">
          <span>[차단일]</span> <?php echo date("Y.m.d", strtotime($row['blockdate'])); ?>
        </p>
        <button type="button" class="ui-btn" onclick="memberBlock();">차단해제</button>
      </div>
    </div>
  <?php
    }
  }
  ?>
  </div>
</div>

<script>
const seller = "<?php echo $my_id ?>";
// 회원차단해제
function memberBlock(chatno){
    $.post('ajax.chat_block.php', {chatno:chatno, seller:seller}, function(obj){
        if(obj.trim()=='Y'){
            alert('차단이 해제되었습니다.');
            location.reload();
        } else {
            alert(obj);
        }
    });
}
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>