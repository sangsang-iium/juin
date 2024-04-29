<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents usedChatList">
  <a href="" class="ui-btn active round regiBtn">
    <img src="/src/img/used/icon-register.png" alt="">글쓰기
  </a>

  <div class="container used-chat_list">
    <!-- 자료 없을때
    <p class="empty_list">자료가 없습니다.</p>
    -->
    <!-- loop { -->
    <div class="chat-item">
      <a href="" class="chat-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="chat-item_txtBox">
        <a href="" class="title">
          <span class="name">제품이름</span>
          <span class="new">5</span>
        </a>
        <p class="tRow1 msg">제품 네고 가능할까요? 수령은 직접 하겠습니다</p>
        <ul class="extra">
          <li>
            <span class="text">월평동</span>
          </li>
          <li>
            <span class="text">30분전</span>
          </li>
        </ul>
      </div>
    </div>
    <!-- } loop -->
    <div class="chat-item">
      <a href="" class="chat-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="chat-item_txtBox">
        <a href="" class="title">
          <span class="name">제품이름</span>
          <span class="new">9+</span>
        </a>
        <p class="tRow1 msg">제품 네고 가능할까요? 수령은 직접 하겠습니다</p>
        <ul class="extra">
          <li>
            <span class="text">월평동</span>
          </li>
          <li>
            <span class="text">30분전</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="chat-item">
      <a href="" class="chat-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="chat-item_txtBox">
        <a href="" class="title">
          <span class="name">제품이름</span>
        </a>
        <p class="tRow1 msg">제품 네고 가능할까요? 수령은 직접 하겠습니다</p>
        <ul class="extra">
          <li>
            <span class="text">월평동</span>
          </li>
          <li>
            <span class="text">30분전</span>
          </li>
        </ul>
      </div>
    </div>

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