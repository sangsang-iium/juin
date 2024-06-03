<?php
include_once("./_common.php");

$lat = trim($_POST['lat']);
$lng = trim($_POST['lng']);
$category = trim($_POST['cate']);

if($category=='all'){
    $sql = "select * from shop_used where del_yn = 'N' and address like '%{$region1}%' and address like '%{$region2}%' order by 1 desc";
} else {
    $sql = "select * from shop_used where del_yn = 'N' and category = '$category' and address like '%{$region1}%' and address like '%{$region2}%' order by 1 desc";
}
$result = sql_query($sql);
$rows = sql_num_rows($result);

if($rows == 0){
    echo '<p class="empty_list">자료가 없습니다.</p>';
} else {
    while($row=sql_fetch_array($result)){
        if($row['m_img']){
            $thumb = BV_DATA_URL.'/used/'.$row['m_img'];
        } else {
            $thumb = '/src/img/used/t-item_thumb1.jpg';
        }
        $gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
        $goodyn = getUsedGoodRegister($row['no'], $member['id']);
        
        echo '<div class="used-item">';
        echo '<a href="./view.php?no='.$row['no'].'" class="used-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['title'].'"></a>';
        echo '<div class="used-item_txtBox">';
        echo '<a href="./view.php?no='.$row['no'].'" class="tRow2 title"><span class="cate">['.$row['category'].']</span><span class="subj">'.$row['title'].'</span></a>';
        echo '<p class="writer"><span>'.getMemberName($row['mb_id']).'</span><span>'.getUsedAddress($row['address']).'</span></p>';
        echo '<ul class="inf"><li><p class="prc">'.number_format($row['price']).'<span class="won">원</span></p></li>';
        if($row['gubun']){
            echo '<li><span class="status ing">'.$gubun_status[0].'</span></li></ul>';
        } else if($row['status']=='1'){
            echo '<li><span class="status resv">'.$gubun_status[1].'</span></li></ul>';
        } else if($row['status']=='2'){
            echo '<li><span class="status end">'.$gubun_status[1].'</span></li></ul>';
        } else {
            echo '<li><span class="status ing">'.$gubun_status[1].'</span></li></ul>';
        }
        echo '<ul class="extra">';
        echo '<li class="hit"><span class="icon"><img src="/src/img/used/icon_hit.png" alt="조회수"></span><span class="text">'.$row['hit'].'</span></li>';
        echo '<li class="like"><span class="icon"><img src="/src/img/used/icon_like.png" alt="좋아요수"></span><span class="text">'.getUsedGoodCount($row['no']).'</span></li>';
        echo '<li class="reply"><span class="icon"><img src="/src/img/used/icon_chat.png" alt="채팅수"></span><span class="text">'.getUsedChatCount($row['no']).'</span></li>';
        echo '</ul>';
        if($goodyn){
            echo '<button type="button" class="ui-btn wish-btn on" data-no="'.$row['no'].'" title="관심상품 등록하기"></button>';
        } else {
            echo '<button type="button" class="ui-btn wish-btn" data-no="'.$row['no'].'" title="관심상품 등록하기"></button>';
        }
        echo '</div></div>';
    }
}
?>

<!--<div class="store-item">
  <a href="./view.php" class="store-item_thumbBox">
    <img src="/src/img/store/t-store_thumb1.jpg" class="fitCover" alt="쥔장네 돈까스">
  </a>
  <div class="store-item_txtBox">
    <a href="./view.php" class="tRow2 title">
      <i class="recom"><img src="/src/img/store/recom_label.png" alt=""></i>
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
</div>-->