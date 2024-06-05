<?php
if (!defined("_BLUEVATION_")) {
  exit;
}
// 개별 페이지 접근 불가

include_once "./_head.php";
?>

<style>
  #footer {display: none;}
</style>

<div class="intro">

	<div class="container intro-top">
		<div class="intro-top-text-box">
			<p class="intro-top-title">사장님이 왕이되는 <br>특별한 <span><img src="/src/img/intro-top-title-icon.png" alt=""></span></p>
			<p class="intro-top-text">장사를 위한 편리한 장보기 플랫폼 <br>다양한 왕족급 서비스를 경험해 보세요!</p>
		</div>
	</div>

	<div class="container intro-btn-wrap">
		<div class="intro-btn-list">
      <a href="/" class="intro-btn left-btn intro-btn01">
        <div class="text-box">
          <p class="text01">장보기</p>
          <p class="text02">장사에 필요한 식자재 고민 해결</p>
        </div>
        <div class="icon">
          <img src="/src/img/icon-intro-btn01.png" alt="">
        </div>
      </a>
      <a href="/m/raffle/list.php?menu=used" class="intro-btn right-btn intro-btn02">
        <div class="text-box">
          <p class="text01">중고장터</p>
          <p class="text02">저렴하게 누리는 중고장터</p>
        </div>
        <div class="icon">
          <img src="/src/img/icon-intro-btn02.png" alt="">
        </div>
      </a>
    </div>
    <div class="intro-btn-list">
      <a href="" class="intro-btn left-btn intro-btn03">
        <div class="text-box">
          <p class="text01">커뮤니티</p>
          <p class="text02">여러 사장님들과의 소통창구</p>
        </div>
        <div class="icon">
          <img src="/src/img/icon-intro-btn03.png" alt="">
        </div>
      </a>
      <a href="/m/service/list.php?menu=service" class="intro-btn right-btn intro-btn04">
        <div class="text-box">
          <p class="text01">제휴서비스</p>
          <p class="text02">제휴서비스를 통한 다양한 혜택</p>
        </div>
        <div class="icon">
          <img src="/src/img/icon-intro-btn04.png" alt="">
        </div>
      </a>
    </div>
	</div>

  <div class="container intro-bottom-wrap">
    <div class="intro-bottom-btn-box">
      <a href="/" class="home-btn">
        <img src="/src/img/intro-home-btn.png" alt="">
      </a>
      <a href="<?php echo BV_MBBS_URL;?>/login.php" class="login-btn">
        <span><img src="/src/img/intro-login-icon.png" alt=""></span>
        <span>로그인</span>
      </a>
    </div>
    <p class="intro-bottom-text">아직 주인장 계정이 없으신가요? <a href="<?php echo BV_MBBS_URL;?>/register_type.php">회원가입</a></p>
  </div>

</div>

<?php
include_once "./_tail.php";
?>