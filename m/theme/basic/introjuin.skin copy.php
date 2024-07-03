<?php
if (!defined("_BLUEVATION_")) {
  exit;
}
// 개별 페이지 접근 불가

include_once "./_head.php";
header('Access-Control-Allow-Origin: *');

$myLocation = json_encode($_SERVER['HTTP_MYLOCATION']);
$myLocation2 = json_encode($_SERVER);
set_session('myLocation', $myLocation);
// print_r2($myLocation);
// echo "<br>";
// print_r2($myLocation2);
// set_session('myLocation', $myLocation);
?>

<style>
  #document {min-height: auto; padding-bottom: 0;}
  #footer {display: none;}
</style>

<div class="intro">

	<div class="container intro-top">
		<div class="intro-top-text-box">
			<p class="intro-top-title">언제나 <b>사장님과 함께!</b></p>
			<p class="intro-top-title intro-top-title2">
        <span class="img"><img src="/src/img/intro-top-title.png" alt="주인장"></span>
        <span>입니다</span>
      </p>
      <p class="intro-top-text">식당 운영 원스탑 솔루션!</p>
			<!-- <p class="intro-top-text">다양한 식자재를 한곳에서<br>정기배송과 매장으로 직접배송!</p> -->
			<!-- <p class="intro-top-text">장사를 위한 편리한 장보기 플랫폼 <br>다양한 왕족급 서비스를 경험해 보세요!</p> -->
			<!-- <p class="intro-top-title">사장님이 왕이되는 <br>특별한 <span><img src="/src/img/intro-top-title-icon.png" alt=""></span></p> -->
		</div>
	</div>

  <div class="container intro-btn-top-wrap">
    <div class="intro-btn-list">
      <a href="/" class="intro-btn left-btn intro-btn01">
        <div class="text-box">
          <p class="text01">식자재 마켓</p>
        </div>
        <div class="icon">
          <img src="/src/img/intro-icon01.png" alt="">
        </div>
      </a>
    </div>
  </div>

	<div class="container intro-btn-wrap">
    <div class="intro-btn-color-box">
      <p class="intro-btn-title">한국외식업중앙회 <span class="img"><img src="/src/img/intro-bot-title.png" alt=""></span></p>
      <div class="intro-btn-list">
        <a href="/m/used/list.php?menu=used" class="intro-btn right-btn intro-btn02">
          <div class="text-box">
            <p class="text01">중고장터</p>
            <!-- <p class="text02">아나바다를 실천하는 <br>알뜰한 사장님</p> -->
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon02.png" alt="">
          </div>
        </a>
        <a href="/m/store/list.php?menu=store" class="intro-btn left-btn intro-btn03">
          <div class="text-box">
            <p class="text01">회원사 현황</p>
            <!-- <p class="text02">사장님 근처에서 찾는 <br>회원사 매장</p> -->
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon03.png" alt="">
          </div>
        </a>
        <a href="/m/service/list.php?menu=service" class="intro-btn right-btn intro-btn04">
          <div class="text-box">
            <p class="text01">제휴서비스</p>
            <!-- <p class="text02">회원사만을 위한 <br>다양한 혜택서비스</p> -->
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon04.png" alt="">
          </div>
        </a>
      </div>
    </div>
	</div>

  
  <div class="container intro-bottom-wrap">
    <!-- <div class="intro-bottom-btn-box">
      <a href="/" class="home-btn">
        <img src="/src/img/intro-home-btn.png" alt="">
      </a>
      <a href="<?php echo BV_MBBS_URL;?>/login.php" class="login-btn">
        <span><img src="/src/img/intro-login-icon.png" alt=""></span>
        <span>로그인</span>
      </a>
    </div> -->
    <p class="intro-bottom-text">아직 주인장 계정이 없으신가요? <a href="<?php echo BV_MBBS_URL;?>/register_type.php">회원가입</a></p>
  </div>

</div>

<?php
include_once "./_tail.php";
?>