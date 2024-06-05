<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

if(is_numeric($no)){
    $row = sql_fetch("select * from shop_member where index_no = '$no'");
    if(!$row['index_no']){
        alert("회원사정보가 존재하지 않습니다.");
    }
    //조회수+
    sql_query("update shop_member set ju_hit = ju_hit + 1 where index_no = '$no'");
} else {
    alert("회원사정보가 존재하지 않습니다.");
}

$imgs = [];
if(file(BV_DATA_URL.'/member/'.$row['ju_mimg'])) array_push($imgs, BV_DATA_URL.'/member/'.$row['ju_mimg']);
$subimgs = explode("|", $row['ju_simg']);
$subimgs = array_filter($subimgs);
foreach($subimgs as $v){
    if(file(BV_DATA_URL.'/member/'.$v)) array_push($imgs, BV_DATA_URL.'/member/'.$v);
}
$imgs = array_unique($imgs);
if(empty($imgs)){
    $imgs = ['/src/img/store/t-store_detail1.jpg'];
}

$good_cnt = getStoreGoodCount($row['index_no']);
//$goodyn = getStoreGoodRegister($row['index_no'], $member['id']);
?>

<div id="contents" class="sub-contents flView storeView">
  <div class="fl-detailThumb">
    <!-- 추천 맛집 라벨 { -->
    <!--<i class="recom"><img src="/src/img/store/recom_label2.png" alt="추천맛집"></i>-->
    <!-- } 추천 맛집 라벨 -->
    <div class="swiper-container">
      <div class="swiper-wrapper">
      <?php
      foreach($imgs as $v){
        echo '<div class="swiper-slide item">';
        echo '<a href="#none" class="link"><figure class="image"><img src="'.$v.'" class="fitCover" alt="'.$row['ju_restaurant'].'"></figure></a>';
        echo '</div>';
      }
      ?>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
      </div>
    </div>
  </div>

  <div class="bottomBlank container store-item_txtBox item_txtBox">
    <a href="" class="tRow2 title">
      <span class="cate">[한식]</span>
      <span class="subj">쥔장네 돈까스</span>
    </a>
    <p class="address">대전 유성구 동서대로656번길</p>
    <a href="" class="tel">070-0000-0000</a>
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
  </div>

  <div class="bottomBlank container prod-smInfo__body">
    <div class="info-list">
      <div class="info-item">
        <p class="tit">운영시간</p>
        <p class="cont">10:00 ~ 22:00(매주 월 휴무)</p>
      </div>
      <div class="info-item">
        <p class="tit">브레이크타임</p>
        <p class="cont">브레이크 타임 : 15:00 ~ 17:00</p>
      </div>
      <div class="info-item">
        <p class="tit">주소</p>
        <p class="cont">주소 : 대전 유성구 동서대로656번길 31-24</p>
      </div>
    </div>
  </div>

  <div class="bottomBlank container fl-explan">
    돈까스 외길 인생 어언 10년 <br/>
    고기 한장에 모든 노력을 아끼지 않고 제작한 수제 돈까스 전문점입니다. <br/>
    직접 만든 소스로 더욱 새콤하고 고소한 돈까스를 체험하실 수 있습니다.
  </div>

</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>