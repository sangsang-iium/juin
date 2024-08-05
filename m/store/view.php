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
    $imgs = ['/src/img/store/t-store_detail1.jpg']; //등록된 이미지 없을경우
}

//$goodyn = getStoreGoodRegister($row['index_no'], $member['id']);
//운영시간/브레이크타임/휴무일
$works = str_replace("~"," ~ ",$row['ju_worktime']);
$breaks = str_replace("~"," ~ ",$row['ju_breaktime']);
if($breaks=='') $breaks = '없음';
$offs = str_replace(['|','요일'],[',',''],$row['ju_off']);
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
      <span class="cate">[<?php echo $row['ju_cate'] ?>]</span>
      <span class="subj"><?php echo $row['ju_restaurant'] ?></span>
    </a>
    <p class="address"><?php echo $row['ju_addr_full'] ?></p>
    <!-- <a href="" class="tel"><?php echo $row['ju_tel'] ?></a> -->
    <ul class="extra">
      <li class="hit">
        <span class="icon">
          <img src="/src/img/store/icon_hit.png" alt="조회수">
        </span>
        <span class="text"><?php echo $row['ju_hit'] ?></span>
      </li>
      <li class="like">
        <span class="icon">
          <img src="/src/img/store/icon_like.png" alt="좋아요수">
        </span>
        <span class="text"><?php echo getStoreGoodCount($row['index_no']) ?></span>
      </li>
    </ul>
  </div>

  <div class="bottomBlank container prod-smInfo__body">
    <div class="info-list">
      <div class="info-item">
        <p class="tit">운영시간</p>
        <p class="cont"><?php echo $works.'(매주 '.$offs.' 휴무)'; ?></p>
      </div>
      <div class="info-item">
        <p class="tit">브레이크타임</p>
        <p class="cont">브레이크 타임 : <?php echo $breaks ?></p>
      </div>
      <div class="info-item">
        <p class="tit">주소</p>
        <p class="cont"><?php echo $row['ju_addr_full'] ?></p>
      </div>
    </div>
  </div>

  <div class="bottomBlank container fl-explan"><?php echo nl2br($row['ju_content']) ?></div>

</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>