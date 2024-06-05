<?php
include_once("./_common.php");

$lat = trim($_POST['lat']);
$lng = trim($_POST['lng']);
$category = trim($_POST['cate']);
$km = 10;


if($category=='all'){
    $sql = "SELECT *, ( 6371 * acos( cos( radians({$lat}) ) * cos( radians( ju_lat ) ) * cos( radians( ju_lng ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( ju_lat ) ) ) ) AS distance ";
    $sql .= "FROM shop_member WHERE grade = 8 and ju_mem = 1 HAVING distance < {$km} ORDER BY distance";
} else {
    $sql = "SELECT *, ( 6371 * acos( cos( radians({$lat}) ) * cos( radians( ju_lat ) ) * cos( radians( ju_lng ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( ju_lat ) ) ) ) AS distance ";
    $sql .= "FROM shop_member WHERE grade = 8 and ju_mem = 1 and ju_cate = '$category' HAVING distance < {$km} ORDER BY distance";
}
$result = sql_query($sql);
$rows = sql_num_rows($result);

$slist = '';
$positions = [];

if($rows == 0){
    $slist .= '<p class="empty_list">자료가 없습니다.</p>';
} else {
    while($row=sql_fetch_array($result)){
        if($row['ju_mimg']){
            $thumb = BV_DATA_URL.'/member/'.$row['ju_mimg'];
        } else {
            $thumb = '/src/img/store/t-store_thumb2.jpg';
        }
        
        $goodyn = getStoreGoodRegister($row['index_no'], $member['id']);
        
        $slist .= '<div class="store-item">';
        $slist .= '<a href="./view.php?no='.$row['index_no'].'" class="store-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['ju_restaurant'].'"></a>';
        $slist .= '<div class="store-item_txtBox">';
        $slist .= '<a href="./view.php?no='.$row['index_no'].'" class="tRow2 title"><span class="cate">['.$row['ju_cate'].']</span><span class="subj">'.$row['ju_restaurant'].'</span></a>';
        $slist .= '<p class="address">'.$row['ju_addr_full'].'</p>';
        $slist .= '<a href="tel:'.$row['ju_tel'].'" class="tel">'.$row['ju_tel'].'</a>';
        $slist .= '<ul class="extra">';
        $slist .= '<li class="hit"><span class="icon"><img src="/src/img/store/icon_hit.png" alt="조회수"></span><span class="text">'.$row['ju_hit'].'</span></li>';
        $slist .= '<li class="like"><span class="icon"><img src="/src/img/store/icon_like.png" alt="좋아요수"></span><span class="text">'.getStoreGoodCount($row['index_no']).'</span></li>';
        $slist .= '</ul>';
        if($goodyn){
            $slist .= '<button type="button" class="ui-btn wish-btn on" data-no="'.$row['index_no'].'" title="관심상품 등록하기"></button>';
        } else {
            $slist .= '<button type="button" class="ui-btn wish-btn" data-no="'.$row['index_no'].'" title="관심상품 등록하기"></button>';
        }
        $slist .= '</div></div>';
        
        array_push($positions, ['title'=>$row['ju_restaurant'], 'lat'=>$row['ju_lat'], 'lng'=>$row['ju_lng'], 'img'=>'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png']);
    }
}

$data['slist'] = $slist;
$data['positions'] = $positions;

echo json_encode($data);
exit;
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