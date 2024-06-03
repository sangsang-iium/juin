<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents storeList">
  <div class="container left store-list__category">
    <div class="cp-horizon-menu2 category-wrap">
      <div class="swiper-wrapper">
        <a href="#none" data-id="all" class="swiper-slide btn">전체</a>
        <?php
        foreach($food_categorys as $v){
            echo '<a href="#none" data-id="'.$v.'" class="swiper-slide btn">'.$v.'</a>';
        }
        ?>
      </div>
    </div>
  </div>

  <div id="map" class="store-map">
    <!-- 지도 연동 -->
  </div>
  <button type="button" class="current_position">현위치 재검색</button>

  <div class="container store-prod_list"></div>

</div>

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let usedMenuActive = 'all';
const usedMenuTarget = '.store-list__category .category-wrap';
const usedMenu = f.hrizonMenu(usedMenuTarget, usedMenuActive);
</script>




<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<script>
// 중심좌표
let user_lat = 0;
let user_lng = 0;
let cate = 'all';

//지도
var mapContainer = document.getElementById('map'),
mapOption = {
	center: new kakao.maps.LatLng(33.450701, 126.570667),
	level: 3
};
var map = new kakao.maps.Map(mapContainer, mapOption);

//지도중심변경
kakao.maps.event.addListener(map, 'idle', function() {
    var level = map.getLevel();
    var latlng = map.getCenter();
    user_lat = latlng.getLat();
    user_lng = latlng.getLng();
    console.log(user_lat+'/'+user_lng)
});



// 마커를 표시할 위치와 title 객체 배열입니다 
/*var positions = [
    {
        title: '카카오', 
        latlng: new kakao.maps.LatLng(33.450705, 126.570677),
        url: '/m/store/view.php',
        img: 'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png'
    },
    {
        title: '생태연못', 
        latlng: new kakao.maps.LatLng(33.450936, 126.569477),
        url: '/m/store/view.php',
        img: 'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png'
    },
];*/
var positions = [];
var markers = [];
function addMarker(positions){
    hideMarkers();
    markers = [];
    
    for(var i = 0; i < positions.length; i ++) {
        //마커 이미지의 이미지 크기 입니다
        var imageSize = new kakao.maps.Size(24, 35);    
        //마커 이미지를 생성합니다    
        var markerImage = new kakao.maps.MarkerImage(positions[i].img, imageSize); 
        // 마커를 생성합니다
        var marker = new kakao.maps.Marker({
            position : positions[i].latlng,
            title : positions[i].title,
            image : markerImage,
            url : positions[i].url
        });
        
        markers.push(marker);
    }
    
    showMarkers();
}
function setMarkers(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }            
}
function showMarkers() {
    setMarkers(map);
}
function hideMarkers() {
    setMarkers(null);    
}





function getStoreList(cate){
    //지도중심이동
    var moveLatLon = new kakao.maps.LatLng(user_lat, user_lng);
    map.setCenter(moveLatLon);
    
    $.post("ajax.get_store_list.php", {lat:user_lat, lng:user_lng, cate:cate}, function(obj){
        
        reEvent();
    });
}

function reEvent(){
    $(".wish-btn").click(function(){
        var el = $(this);
        var no = el.data("no");
        var inout = 'in';
        if(el.hasClass("on")){
            inout = 'out';
        }
        $.post("ajax.store_good.php", {no:no, inout:inout}, function(obj){
            if(obj.trim()=='in'){
                el.addClass("on");
            } else if(obj.trim()=='out'){
                el.removeClass("on");
            }
        });
    });
}

$(document).ready(function(){
    function successCallback(position) {
        user_lat = position.coords.latitude;
        user_lng = position.coords.longitude;
        
        getStoreList(cate);
    }

    function errorCallback(error) {
        //alert("Error: " + error.message);
        getStoreList(cate);
    }

    //navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    $(".swiper-slide").click(function(){
        cate = $(this).data("id");
        $(".swiper-slide").removeClass("active");
        $(this).addClass("active");
        
        getStoreList(cate);
    });

    $(".current_position").click(function(){
        getStoreList(cate);
    });   
});
</script>


<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>