<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents usedChatRoom">
  <div class="bottomBlank container chat-itemBox">
    <div class="used-item">
      <a href="./view.php" class="used-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="used-item_txtBox">
        <a href="./view.php" class="tRow1 title">
          <span class="cate">[주방용품]</span>
          <span class="subj">식당용 식탁,의자</span>
        </a>
        <p class="tRow1 writer">
          <span>대전시 서구 월평동</span>
        </p>
        <ul class="inf">
          <li>
            <p class="prc">50,000<span class="won">원</span></p>
          </li>
          <li>
            <span class="status ing">판매중</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container chat-vBox">
    <p class="date">2024년 00월 00일</p>
    <div class="chat-msg receive">
      <div class="msgBox">
        <div class="msgText">안녕하세요! 관심있는데 구매가능한가요? 구매가능한가요? 구매가능한가요?</div>
        <span class="msgTime">오전 9:07</span>
      </div>
    </div>
    <div class="chat-msg send">
      <div class="msgBox">
        <div class="msgText">네~가능합니다.<br>바로 구매하실건가요? 구매하실건가요? 구매하실건가요?</div>
        <span class="msgTime">오전 9:07</span>
      </div>
    </div>
  </div>
  <div class="container chat-wBox">
    <div class="chat-wBox_wrap">
      <textarea name="" id=""rows="1" class="frm-input w-per100 chat-wBox_input" placeholder="메세지 내용을 입력해주세요."></textarea>
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
    chatScrollInit();
    chatContentInit();
  });
});
</script>

<?php
include_once(BV_MPATH."/tail.sub.php"); // 하단
?>