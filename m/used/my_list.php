<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents usedList">
  <div class="container used-prod_list">
    <!-- 자료 없을때
    <p class="empty_list">자료가 없습니다.</p>
    -->
    <!-- loop { -->
    <div class="used-item">
      <a href="./view.php" class="used-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="used-item_txtBox">
        <a href="./view.php" class="tRow2 title">
          <span class="cate">[주방용품]</span>
          <span class="subj">식당용 식탁,의자</span>
        </a>
        <p class="writer">
          <span>홍길동</span>
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
        <ul class="extra">
          <li class="hit">
            <span class="icon">
              <img src="/src/img/used/icon_hit.png" alt="조회수">
            </span>
            <span class="text">56</span>
          </li>
          <li class="like">
            <span class="icon">
              <img src="/src/img/used/icon_like.png" alt="좋아요수">
            </span>
            <span class="text">23</span>
          </li>
          <li class="reply">
            <span class="icon">
              <img src="/src/img/used/icon_chat.png" alt="댓글수">
            </span>
            <span class="text">10</span>
          </li>
        </ul>
        <!-- 버튼 영역 { -->
        <div class="used-my-btn-wr">
          <a href="" class="ui-btn st1 sizeS">수정</a>
          <button type="button" class="ui-btn stBlack sizeS">삭제</button>
        </div>
        <!-- } 버튼 영역 -->
      </div>
    </div>
    <!-- } loop -->
    <!-- loop { -->
    <div class="used-item">
      <a href="./view.php" class="used-item_thumbBox">
        <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
      </a>
      <div class="used-item_txtBox">
        <a href="./view.php" class="tRow2 title">
          <span class="cate">[주방용품]</span>
          <span class="subj">식당용 식탁,의자</span>
        </a>
        <p class="writer">
          <span>홍길동</span>
          <span>대전시 서구 월평동</span>
        </p>
        <ul class="inf">
          <li>
            <p class="prc">50,000<span class="won">원</span></p>
          </li>
          <li>
            <span class="status end">판매완료</span>
          </li>
        </ul>
        <ul class="extra">
          <li class="hit">
            <span class="icon">
              <img src="/src/img/used/icon_hit.png" alt="조회수">
            </span>
            <span class="text">56</span>
          </li>
          <li class="like">
            <span class="icon">
              <img src="/src/img/used/icon_like.png" alt="좋아요수">
            </span>
            <span class="text">23</span>
          </li>
          <li class="reply">
            <span class="icon">
              <img src="/src/img/used/icon_chat.png" alt="댓글수">
            </span>
            <span class="text">10</span>
          </li>
        </ul>
        <!-- 버튼 영역 { -->
        <div class="used-my-btn-wr">
          <a href="" class="ui-btn st1 sizeS">수정</a>
          <button type="button" class="ui-btn stBlack sizeS">삭제</button>
        </div>
        <!-- } 버튼 영역 -->
      </div>
    </div>
    <!-- } loop -->
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>