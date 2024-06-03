<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

if(is_numeric($pno)){
    $row = sql_fetch("select * from shop_used where no = '$pno' and mb_id = '{$member['id']}'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
} else {
    alert("상품정보가 존재하지 않습니다.");
}

$sql = "select * from shop_used_chat where pno = '$pno'";
$result = sql_query($sql);
$chat_cnt = sql_num_rows($result);
if(!$chat_cnt){
    alert("요청된 채팅내역이 없습니다.");
}
?>

<div id="contents" class="sub-contents usedChatList">
  <!--<a href="./chat_room.php" class="ui-btn active round regiBtn">
    <img src="/src/img/used/icon-register.png" alt="">글쓰기
  </a> 필요없음-->

  <div class="container used-chat_list">
    <?php
    while($row2=sql_fetch_array($result)){
        $new = sql_fetch("select a.cnt, b.content from (select count(*) as cnt from shop_used_chatd where pno = '{$row2['no']}' and mread = 0) a, (select content from shop_used_chatd where pno = '{$row2['no']}' order by no desc limit 1) b");
    ?>    
    <div class="chat-item">
      <a href="./chat_room.php?pno=<?php echo $row2['pno'] ?>&tid=<?php echo $row2['mb_id'] ?>" class="chat-item_thumbBox">
        <img src="<?php echo BV_DATA_URL.'/used/'.$row['m_img'] ?>" class="fitCover" alt="<?php echo $row['title'] ?>">
      </a>
      <div class="chat-item_txtBox">
        <a href="./chat_room.php?pno=<?php echo $row2['pno'] ?>&tid=<?php echo $row2['mb_id'] ?>" class="title">
          <span class="name">[<?php echo substr($row2['mb_id'],0,3) ?>***] <?php echo $row['title'] ?></span>
          <?php
          if($new['cnt']){
            if($new['cnt'] > 8){
              echo '<span class="new">9+</span>';
            } else {
              echo '<span class="new">'.$new['cnt'].'</span>';
            }
          }
          ?>
        </a>
        <p class="tRow1 msg"><?php echo ($new['content']) ? nl2br($new['content']) : '채팅글이 등록되지 않았습니다.'; ?></p>
        <ul class="extra">
          <li>
            <span class="text"><?php echo getUsedAddressLast($row['address']) ?></span>
          </li>
          <li>
            <span class="text"><?php echo getUsedChatPasstime($row2['lasttime']) ?></span>
          </li>
        </ul>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let usedMenuActive = 'all';
const usedMenuTarget = '.used-list__category .category-wrap';
const usedMenu = f.hrizonMenu(usedMenuTarget, usedMenuActive);
</script>

<?php
include_once(BV_MPATH."/tail.sub.php"); // 하단
?>