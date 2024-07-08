<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

$my_id = $member['id'];
$sql = "select * from shop_used_chat where pno IN (select no from shop_used where mb_id='$my_id' and del_yn='N') or mb_id='$my_id' order by lasttime desc";
$result = sql_query($sql);
$chat_cnt = sql_num_rows($result);
if(!$chat_cnt){
    alert("채팅내역이 없습니다.");
}
?>

<div id="contents" class="sub-contents usedChatList">
  <!--<a href="./chat_room.php" class="ui-btn active round regiBtn">
    <img src="/src/img/used/icon-register.png" alt="">글쓰기
  </a> 필요없음-->

  <div class="container used-chat_list">
    <?php
    while($row=sql_fetch_array($result)){
        $good = sql_fetch("select * from shop_used where no='{$row['pno']}'");
        
        if($row['mb_id']==$my_id){
            //내가구매자
            $new = sql_fetch("select a.cnt, b.content from (select count(*) as cnt from shop_used_chatd where pno = '{$row['no']}' and uread = 0) a, (select content from shop_used_chatd where pno = '{$row['no']}' order by no desc limit 1) b");
            $v_mb_id = $row['mb_id'];
        } else {
            //내가판매자
            if($row['block']) continue;
            
            $new = sql_fetch("select a.cnt, b.content from (select count(*) as cnt from shop_used_chatd where pno = '{$row['no']}' and mread = 0) a, (select content from shop_used_chatd where pno = '{$row['no']}' order by no desc limit 1) b");
            $v_mb_id = substr($row['mb_id'],0,3).'***';
        }
    ?>
    <div class="chat-item">
      <a href="./chat_room.php?pno=<?php echo $row['pno'] ?>&tid=<?php echo $row['mb_id'] ?>" class="chat-item_thumbBox">
        <img src="<?php echo BV_DATA_URL.'/used/'.$good['m_img'] ?>" class="fitCover" alt="<?php echo $good['title'] ?>">
      </a>
      <div class="chat-item_txtBox">
        <a href="./chat_room.php?pno=<?php echo $row['pno'] ?>&tid=<?php echo $row['mb_id'] ?>" class="title">
          <span class="name">[<?php echo $v_mb_id ?>] <?php echo $good['title'] ?></span>
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
            <span class="text"><?php echo getUsedChatPasstime($row['lasttime']) ?></span>
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