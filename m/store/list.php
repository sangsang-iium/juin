<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents storeList">
  <div class="container left store-list__category">
    <div class="cp-horizon-menu2 category-wrap">
      <div class="swiper-wrapper">
        <a href="" data-id="all" class="swiper-slide btn">전체</a>
        <a href="" data-id="001" class="swiper-slide btn">한식</a>
        <a href="" data-id="002" class="swiper-slide btn">양식</a>
        <a href="" data-id="003" class="swiper-slide btn">중식</a>
        <a href="" data-id="004" class="swiper-slide btn">아시아음식</a>
        <a href="" data-id="005" class="swiper-slide btn">일식</a>
        <a href="" data-id="006" class="swiper-slide btn">분식</a>
        <a href="" data-id="007" class="swiper-slide btn">카페</a>
      </div>
    </div>
  </div>

  <div id="map" class="store-map">
    <!-- 지도 연동 -->
  </div>

  <div class="container store-prod_list">
    <!-- 자료 없을때
    <p class="empty_list">자료가 없습니다.</p>
    -->
    <!-- loop { -->
    <div class="store-item">
      <a href="./view.php" class="store-item_thumbBox">
        <img src="/src/img/store/t-store_thumb1.jpg" class="fitCover" alt="쥔장네 돈까스">
      </a>
      <div class="store-item_txtBox">
        <a href="./view.php" class="tRow2 title">
          <!-- 추천 맛집 라벨 { -->
          <i class="recom"><img src="/src/img/store/recom_label.png" alt=""></i>
          <!-- } 추천 맛집 라벨 -->
          <span class="cate">[한식]</span>
          <span class="subj">쥔장네 돈까스</span>
        </a>
        <p class="address">대전 유성구 동서대로656번길</p>
        <a href="tel:070-0000-0000" class="tel">070-0000-0000</a>
        <ul class="extra">
          <li class="hit">
            <span class="icon">
              <img src="/src/img/store/icon_hit.png" alt="조회수">
            </span>
            <span class="text">56</span>
          </li>
          <li class="like">
            <span class="icon">
              <img src="/src/img/store/icon_like.png" alt="좋아요수">
            </span>
            <span class="text">23</span>
          </li>
        </ul>
        <button type="button" class="ui-btn wish-btn on" title="관심상품 등록하기"></button>
      </div>
    </div>
    <!-- } loop -->

    <div class="store-item">
      <a href="./view.php" class="store-item_thumbBox">
        <img src="/src/img/store/t-store_thumb2.jpg" class="fitCover" alt="주인장 초밥">
      </a>
      <div class="store-item_txtBox">
        <a href="./view.php" class="tRow2 title">
          <span class="cate">[일식]</span>
          <span class="subj">주인장 초밥</span>
        </a>
        <p class="address">대전 유성구 동서대로656번길</p>
        <a href="tel:070-0000-0000" class="tel">070-0000-0000</a>
        <ul class="extra">
          <li class="hit">
            <span class="icon">
              <img src="/src/img/store/icon_hit.png" alt="조회수">
            </span>
            <span class="text">56</span>
          </li>
          <li class="like">
            <span class="icon">
              <img src="/src/img/store/icon_like.png" alt="좋아요수">
            </span>
            <span class="text">23</span>
          </li>
        </ul>
        <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=eaf541d30a116048e3c696a2d92d9fb8"></script>
<script>
//Kakao map
var container = document.getElementById('map');
var options = {
	center: new kakao.maps.LatLng(33.450701, 126.570667),
	level: 3
};

var map = new kakao.maps.Map(container, options);
</script>

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let usedMenuActive = 'all';
const usedMenuTarget = '.store-list__category .category-wrap';
const usedMenu = f.hrizonMenu(usedMenuTarget, usedMenuActive);
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>