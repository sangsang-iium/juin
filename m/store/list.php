<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
//include_once(BV_PATH.'/include/topMenu.php');
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

  <div class="container member-status-btn-wr">
    <button type="button" class="current_position ui-btn st3">현위치 재검색</button>
    <button type="button" class="add_latlng ui-btn st3">검색위치등록</button>
  </div>

  <div class="container store-prod_list"></div>

</div>

<div id="post_wrap" >
    <img src="/src/img/post_close.png" id="btnFoldWrap"
      style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()"
      alt="접기 버튼">
  </div>

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let usedMenuActive = 'all';
const usedMenuTarget = '.store-list__category .category-wrap';
const usedMenu = f.hrizonMenu(usedMenuTarget, usedMenuActive);
</script>




<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<?php echo BV_POSTCODE_JS ?>
<?php
    $myLocation = json_encode($_SERVER['HTTP_MYLOCATION']);
    set_session('myLocation', $myLocation);
    log_write($myLocation . '@@@' . get_session('myLocation').'###'.$_SERVER['HTTP_MYLOCATION']);
    // $MyLocation       = get_session('myLocation');
    $userLocation     = explode(",", $myLocation);
    if ($myLocation === "null") {
        $user_lat = 37.514575;
        $user_lng = 127.0495556;
    } else {
        $user_lat = number_format($userLocation[0], 5);
        $user_lng = number_format($userLocation[1], 5);
    }
?>
<script>



// 중심좌표(위치거부시초기값)
// let user_lat = 33.450701;
// let user_lng = 126.570667;
let user_lat = <?php echo $user_lat?>;
let user_lng = <?php echo $user_lng?>;
let cate = 'all';

//지도
var mapContainer = document.getElementById('map'),
mapOption = {
	center: new kakao.maps.LatLng(user_lat, user_lng),
	level: 3
};
var map = new kakao.maps.Map(mapContainer, mapOption);

//지도중심변경
kakao.maps.event.addListener(map, 'idle', function() {
    var level = map.getLevel();
    var latlng = map.getCenter();
    user_lat = latlng.getLat();
    user_lng = latlng.getLng();
    //console.log(user_lat+'/'+user_lng)
});

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
            position : new kakao.maps.LatLng(positions[i].lat, positions[i].lng),
            title : positions[i].title,
            image : markerImage
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


//회원사 리스트 가져오기
function getStoreList(){
    //지도중심이동
    var moveLatLon = new kakao.maps.LatLng(user_lat, user_lng);
    map.setCenter(moveLatLon);

    $.post("ajax.get_store_list.php", {lat:user_lat, lng:user_lng, cate:cate}, function(obj){
        var data = JSON.parse(obj);
        $(".store-prod_list").html(data['slist']);
        var positions = data['positions'];
        addMarker(positions);
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


// 지도 팝업으로 jjh 20240619
var element_wrap0 = document.getElementById('post_wrap');
function foldDaumPostcode() {
  // iframe을 넣은 element를 안보이게 한다.
  element_wrap0.style.display = 'none';
}



// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();
// 주소로 좌표를 검색합니다
function getPosition(address){
    address = address.trim();

    geocoder.addressSearch(address, function(result, status) {
        // 정상적으로 검색이 완료됐으면
        if (status === kakao.maps.services.Status.OK) {
            user_lat = result[0].y;
            user_lng = result[0].x;
            getStoreList();
        } else {
            alert("좌표를 확인할 수 없습니다. 주소를 확인해 주세요.");
        }
    });
}
function daumAddress(){
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }
             element_wrap0.style.display = 'none';

            getPosition(addr);
        },
        width: '100%',
        height: '100%'
    }).embed(element_wrap0);
  element_wrap0.style.display = 'block';
}



$(document).ready(function(){
    function successCallback(position) {
        user_lat = position.coords.latitude;
        user_lng = position.coords.longitude;

        getStoreList();
    }

    function errorCallback(error) {
        //alert("Error: " + error.message);
        getStoreList();
    }

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    $(".swiper-slide").click(function(){
        cate = $(this).data("id");
        $(".swiper-slide").removeClass("active");
        $(this).addClass("active");

        getStoreList();
    });

    $(".current_position").click(function(){
        getStoreList();
    });

    $(".add_latlng").click(function(){
        daumAddress();
    });
});
</script>


<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>