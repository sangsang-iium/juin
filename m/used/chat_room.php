<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

if(is_numeric($pno)){
    $good = sql_fetch("select * from shop_used where no = '$pno'");
    if(!$good['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
    $gubun_status = getUsedGubunStatus($good['gubun'], $good['status']);
} else {
    alert("상품정보가 존재하지 않습니다.");
}

$sql = "select * from shop_used_chat where pno = '$pno' and mb_id = '$tid'";
$chat = sql_fetch($sql);
if(!$chat['no']){
    $mb = get_member($tid);
    if($mb['id']){
        //채팅방등록
        sql_query("insert into shop_used_chat set pno='$pno', mb_id='$tid', regdate='".BV_TIME_YMDHIS."'");
        $chatno = sql_insert_id();
    } else {
        alert("잘못된 접근입니다.");
    }
} else {
    $chatno = $chat['no'];
}

//읽음기록업데이트
$seller = $good['mb_id'];
if($member['id']==$seller){
    sql_query("update shop_used_chatd set mread = 1 where pno = {$chatno}");
} else {
    sql_query("update shop_used_chatd set uread = 1 where pno = {$chatno}");
}

$sql = "select * from shop_used_chatd where pno = '$chatno' order by no";
$result = sql_query($sql);
?>

<div id="contents" class="sub-contents usedChatRoom">
  <div class="bottomBlank container chat-itemBox">
    <div class="used-item">
      <a href="./view.php" class="used-item_thumbBox">
        <img src="<?php echo BV_DATA_URL.'/used/'.$good['m_img'] ?>" class="fitCover" alt="<?php echo $good['title'] ?>">
      </a>
      <div class="used-item_txtBox">
        <a href="./view.php" class="tRow1 title">
          <span class="cate">[<?php echo $good['category'] ?>]</span>
          <span class="subj"><?php echo $good['title'] ?></span>
        </a>
        <p class="tRow1 writer">
          <span><?php echo getUsedAddress($good['address']) ?></span>
        </p>
        <ul class="inf">
          <li>
            <p class="prc"><?php echo number_format($good['price']) ?><span class="won">원</span></p>
          </li>
          <li>
            <span class="status ing"><?php echo $gubun_status[1] ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container chat-vBox">
  <?php
  $hdate = '';
  while($row=sql_fetch_array($result)){
    $ymd = substr($row['regdate'],0,10);
    if( $ymd != $hdate ){
        echo '<p class="date">'.date("Y년 m월 d일", strtotime($ymd)).'</p>';
        $hdate = $ymd;
    }
    
    if($member['id']==$row['mb_id']){
        echo '<div class="chat-msg send"><div class="msgBox">';
        echo '<div class="msgText">'.nl2br($row['content']).'</div>';
        $vtime = str_replace(['AM','PM'], ['오전','오후'], date("A g:i", strtotime($row['regdate'])));
        echo '<span class="msgTime">'.$vtime.'</span>';
        echo '</div></div>';
    } else {
        echo '<div class="chat-msg receive"><div class="msgBox">';
        echo '<div class="msgText">'.nl2br($row['content']).'</div>';
        $vtime = str_replace(['AM','PM'], ['오전','오후'], date("A g:i", strtotime($row['regdate'])));
        echo '<span class="msgTime">'.$vtime.'</span>';
        echo '</div></div>';
    }
  }
  ?>
  </div>
  
  <div class="container chat-wBox">
    <div class="chat-wBox_wrap">
      <textarea id="chat_content" rows="1" class="frm-input w-per100 chat-wBox_input" placeholder="메세지 내용을 입력해주세요." maxlength="255"></textarea>
      <button type="button" class="chat-wBox_btn">메세지 전송</button>
    </div>
  </div>
</div>

<script src="/src/plugin/autosize/autosize.min.js" integrity="sha512-EAEoidLzhKrfVg7qX8xZFEAebhmBMsXrIcI0h7VPx2CyAyFHuDvOAUs9CEATB2Ou2/kuWEDtluEVrQcjXBy9yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
//메세지 입력칸 자동 높이 조절
autosize($('.chat-wBox_input'));

//메세지 입력칸(작성내용, 높이값) 초기화
//★백엔드 개발시 메세지 보내기 후 입력칸 초기화
function chatContentInit() {
  let chatInput = $('.chat-wBox_input');
  chatInput.val('').css({'height' : 'auto'});
}

//메세지 뷰어영역 스크롤 하단으로 이동
//★백엔드 개발시 메세지 보내기 후 스크롤 이동되게 적용
function chatScrollInit() {
  let chatVBox = $('.chat-vBox');
  chatVBox.scrollTop(chatVBox.prop("scrollHeight"));
}

$(document).ready(function(){
  chatScrollInit();

  //(임시)메세지 보내기 이벤트
  $(".chat-wBox_btn").on('click', function(){
    insertChat();
    chatScrollInit();
    chatContentInit();
  });
});


const seller = "<?php echo $seller ?>";
const chatno = Number(<?php echo $chatno ?>);
var vcount = 0;

var time = 0;
var alltime = 0;
const limit = 5;

function insertChat(){
    var content = $('#chat_content').val();
    $.post('ajax.chat_insert.php', {chatno:chatno, content:content}, function(){
        appendChat();
        time = 0;
    });
}

function appendChat(){
    vcount = $('.chat-msg').length;
    $.post('ajax.chat_append.php', {chatno:chatno, vcount:vcount, seller:seller}, function(obj){
        $('.chat-vBox').append(obj);
    });
}

// 5초마다글가져오기 10분마다 새로고침
var timer = setInterval(function(){
  time++;
  alltime++;
  if(alltime > 600){
    location.reload();
  }
  if(time > limit){
    appendChat();
    time = 0;
  }
}, 1000);
</script>

<?php
include_once(BV_MPATH."/tail.sub.php"); // 하단
?>