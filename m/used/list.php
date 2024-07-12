<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
//include_once(BV_PATH.'/include/topMenu.php');
include_once(BV_PATH.'/include/introBtn.php');

$addrs = explode(" ", trim($member['ju_addr_full']));
$region_key = trim($addrs[0]);
if(in_array($region_key, ['서울','서울시','서울특별시'])) $region_key = '서울';
if(in_array($region_key, ['인천','인천시','인천광역시'])) $region_key = '인천';
if(in_array($region_key, ['대전','대전시','대전광역시'])) $region_key = '대전';
if(in_array($region_key, ['광주','광주시','광주광역시'])) $region_key = '광주';
if(in_array($region_key, ['대구','대구시','대구광역시'])) $region_key = '대구';
if(in_array($region_key, ['울산','울산시','울산광역시'])) $region_key = '울산';
if(in_array($region_key, ['부산','부산시','부산광역시'])) $region_key = '부산';
if(in_array($region_key, ['경기','경기도'])) $region_key = '경기';
if(in_array($region_key, ['강원','강원도'])) $region_key = '강원';
if(in_array($region_key, ['충북','충청북도'])) $region_key = '충북';
if(in_array($region_key, ['충남','충청남도'])) $region_key = '충남';
if(in_array($region_key, ['전북','전라북도'])) $region_key = '전북';
if(in_array($region_key, ['전남','전라남도'])) $region_key = '전남';
if(in_array($region_key, ['경북','경상북도'])) $region_key = '경북';
if(in_array($region_key, ['경남','경상남도'])) $region_key = '경남';
if(in_array($region_key, ['제주','제주도','제주특별자치도'])) $region_key = '제주';
if(in_array($region_key, ['세종','세종시','세종특별자치시'])) $region_key = '세종';
$regions = [
    '서울' => ['강남구','강동구','강북구','강서구','관악구','광진구','구로구','금천구','노원구','도봉구','동대문구','동작구','마포구','서대문구','서초구','성동구','성북구','송파구','양천구','영등포구','용산구','은평구','종로구','중구','중랑구'],
    '인천' => ['계양구','남구','남동구','동구','부평구','서구','연수구','중구','강화군','옹진군'],
    '대전' => ['대덕구','동구','서구','유성구','중구'],
    '광주' => ['광산구','남구','동구','북구','서구'],
    '대구' => ['남구','달서구','동구','북구','서구','수성구','중구','달성군'],
    '울산' => ['남구','동구','북구','중구','울주군'],
    '부산' => ['강서구','금정구','남구','동구','동래구','부산진구','북구','사상구','사하구','서구','수영구','연제구','영도구','중구','해운대구','기장군'],
    '경기' => ['고양시','과천시','광명시','광주시','구리시','군포시','김포시','남양주시','동두천시','부천시','성남시','수원시','시흥시','안산시','안성시','안양시','양주시','오산시','용인시','의왕시','의정부시','이천시','파주시','평택시','포천시','하남시','화성시','가평군','양평군','여주군','연천군'],
    '강원' => ['강릉시','동해시','삼척시','속초시','원주시','춘천시','태백시','고성군','양구군','양양군','영월군','인제군','정선군','철원군','평창군','홍천군','화천군','횡성군'],
    '충북' => ['제천시','청주시','충주시','괴산군','단양군','보은군','영동군','옥천군','음성군','증평군','진천군','청원군'],
    '충남' => ['계룡시','공주시','논산시','보령시','서산시','아산시','천안시','금산군','당진군','부여군','서천군','연기군','예산군','청양군','태안군','홍성군'],
    '전북' => ['군산시','김제시','남원시','익산시','전주시','정읍시','고창군','무주군','부안군','순창군','완주군','임실군','장수군','진안군'],
    '전남' => ['광양시','나주시','목포시','순천시','여수시','강진군','고흥군','곡성군','구례군','담양군','무안군','보성군','신안군','영광군','영암군','완도군','장성군','장흥군','진도군','함평군','해남군','화순군'],
    '경북' => ['경산시','경주시','구미시','김천시','문경시','상주시','안동시','영주시','영천시','포항시','고령군','군위군','봉화군','성주군','영덕군','영양군','예천군','울릉군','울진군','의성군','청도군','청송군','칠곡군'],
    '경남' => ['거제시','김해시','마산시','밀양시','사천시','양산시','진주시','진해시','창원시','통영시','거창군','고성군','남해군','산청군','의령군','창녕군','하동군','함안군','함양군','합천군'],
    '제주' => ['서귀포시','제주시','남제주군','북제주군'],
    '세종' => ['세종시']
];
?>

<!-- 중고장터 팝업 2024-07-12 { -->
<?php if(!$_COOKIE["used-popup"]) { ?>
<div id="used-popup" class="mpb-wrap used-popup active">
  <div class="usedpop-img-wrap">
    <img src="/src/img/used/used-pop-img.jpg" alt="">
  </div>
  <div class="mpb-btn-wrap">
    <div class="container">
      <button type="button" class="hd_pops_reject onlytodayshow">오늘 하루 보지 않기</button>
      <button type="button" class="hd_pops_close mpb-close-btn">닫기</button>
    </div>
  </div>
</div>
<?php } ?>

<script>
$(function() {
  if($("#used-popup").hasClass('active')) {
    $(".popDim").show();
  }

  $(".hd_pops_reject").click(function() {
    let id = $(this).attr('class').split(' ');
    let ck_name = "used-popup";
    let exp_time = 24;
    let cookie_domain = '';

    $("#used-popup").removeClass('active');
    $(".popDim").fadeOut(500);
    set_cookie(ck_name, 1, exp_time, cookie_domain);
    // console.log(ck_name, 1, exp_time, cookie_domain);
  });

  $('.hd_pops_close').click(function() {
      $("#used-popup").removeClass('active');
      $(".popDim").fadeOut(500);
  });
});
</script>
<!-- } 중고장터 팝업 2024-07-12 -->

<div id="contents" class="sub-contents usedList">
  <a href="./chat_list.php" class="ui-btn active round chatListBtn">
    <img src="/src/img/used/icon_chat_send.png" alt="">채팅방
  </a>
  <a href="./write.php" class="ui-btn active round regiBtn">
    <img src="/src/img/used/icon-register.png" alt="">글쓰기
  </a>

  <div class="container used-location_sch">
    <div class="location_select">
      <i class="icon"><img src="/src/img/used/location.png" alt=""></i>
      <select name="region" id="region" class="select" onchange="changeRegion(this.value);">
      <?php
      if($region_key){
        echo '<option value="'.$region_key.'">전체</option>';
        foreach($regions[$region_key] as $v){
            echo '<option value="'.$v.'">'.$v.'</option>';
        }
      } else {
        foreach($regions as $k => $v){
            echo '<option value="'.$k.'">'.$k.'</option>';
        }
      }
      ?>
      </select>
    </div>
  </div>

  <div class="container left used-list__category">
    <div class="cp-horizon-menu2 category-wrap">
      <div class="swiper-wrapper">
        <a href="#none" data-id="all" class="swiper-slide btn">전체</a>
        <?php
        foreach($used_categorys as $v){
            echo '<a href="#none" data-id="'.$v.'" class="swiper-slide btn">'.$v.'</a>';
        }
        ?>
      </div>
    </div>
  </div>

  <div class="container used-prod_list"></div>

</div>

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let usedMenuActive = 'all';
const usedMenuTarget = '.used-list__category .category-wrap';
const usedMenu = f.hrizonMenu(usedMenuTarget, usedMenuActive);
</script>


<script>
let region1 = "<?php echo $region_key ?>"; //전국단위(매장주소미등록)일경우 ""
let region = $("#region").val();
let cate = 'all';

function getUsedList(region, cate){    
    $.post("ajax.get_used_list.php", {region1:region1, region2:region, cate:cate}, function(obj){
        $(".used-prod_list").html(obj);
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
        $.post("ajax.used_good.php", {no:no, inout:inout}, function(obj){
            if(obj.trim()=='in'){
                el.addClass("on");
            } else if(obj.trim()=='out'){
                el.removeClass("on");
            }
        });
    });
}

function changeRegion(region){
    getUsedList(region, cate);
}

$(document).ready(function(){
    $(".swiper-slide").click(function(){
        region = $("#region").val();
        cate = $(this).data("id");
        $(".swiper-slide").removeClass("active");
        $(this).addClass("active");
        
        getUsedList(region, cate);
    })

    getUsedList(region, cate);
});
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>