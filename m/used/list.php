<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents usedList">
  <a href="" class="ui-btn active round regiBtn">
    <img src="/src/img/used/icon-register.png" alt="">글쓰기
  </a>

  <div class="container used-location_sch">
    <div class="location_select">
      <i class="icon"><img src="/src/img/used/location.png" alt=""></i>
      <select name="" id="" class="select">
        <option value="" selected>월평동</option>
      </select>
    </div>
  </div>

  <div class="container left used-list__category">
    <div class="cp-horizon-menu2 category-wrap">
      <div class="swiper-wrapper">
        <a href="" data-id="all" class="swiper-slide btn">전체</a>
        <a href="" data-id="001" class="swiper-slide btn">생활용품</a>
        <a href="" data-id="002" class="swiper-slide btn">주방용품</a>
        <a href="" data-id="003" class="swiper-slide btn">식기세트</a>
        <a href="" data-id="004" class="swiper-slide btn">포장용기</a>
      </div>
    </div>
  </div>

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
        <button type="button" class="ui-btn wish-btn on" title="관심상품 등록하기"></button>
      </div>
    </div>
    <!-- } loop -->

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
            <span class="status end">거래완료</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

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
            <span class="status resv">예약중</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

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
            <span class="status resv">예약중</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

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
            <span class="status resv">예약중</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

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
            <span class="status resv">예약중</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

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
            <span class="status resv">예약중</span>
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
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
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
include_once(BV_MPATH."/_tail.php"); // 하단
?>