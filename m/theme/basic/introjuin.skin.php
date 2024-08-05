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
// $getAppData = get_session('myLocation');
// if ($_SERVER['REMOTE_ADDR'] == '106.247.231.170') {
//   print_r2($getAppData);
// }
// $getAppData = trim($getAppData, '\"');
// $appDataArr = explode(",", $getAppData);
// $appToken   = trim(end($appDataArr));
// if (empty($appToken) || $appToken == 'null' || $appToken == '') {
//   $appToken = '';
// }

// if (!empty($appToken)) {
//   $chk_token_sel = " SELECT id AS fcm_id FROM shop_member WHERE fcm_token = '{$appToken}' ";
//   $chk_token_row = sql_fetch($chk_token_sel);
//   if(!empty($appToken)) {
//     $sql = " update shop_member set login_ip = '{$_SERVER['REMOTE_ADDR']}', fcm_token = '{$appToken}' where id = '{$member['id']}' ";
//     sql_query($sql);
//   }
// }
?>

<style>
  #document {min-height: auto; padding-bottom: 0;}
  #footer {display: none;}
</style>

<div class="intro">

	<!-- <div class="container intro-top">
		<div class="intro-top-text-box">
			<p class="intro-top-title">언제나 <b>사장님과 함께!</b></p>
			<p class="intro-top-title intro-top-title2">
        <span class="img"><img src="/src/img/intro-top-title.png" alt="주인장"></span>
        <span>입니다</span>
      </p>
      <p class="intro-top-text">식당 운영 원스탑 솔루션!</p>
		</div>
	</div> -->

  <!-- <div class="container intro-btn-top-wrap">
    <div class="intro-btn-list">
      <a href="/" class="intro-btn left-btn intro-btn01">
        <div class="text-box">
          <p class="text01">식자재 <br>마트</p>
        </div>
        <div class="icon">
          <img src="/src/img/intro-icon01.png" alt="">
        </div>
      </a>
    </div>
  </div> -->

	<!-- <div class="container intro-btn-wrap">
    <div class="intro-btn-color-box">
      <p class="intro-btn-title">한국외식업중앙회 <span class="img"><img src="/src/img/intro-bot-title.png" alt=""></span></p>
      <div class="intro-btn-list">
        <a href="/m/store/list.php?menu=store" class="intro-btn left-btn intro-btn03">
          <div class="text-box">
            <p class="text01">회원사 <br>현황</p>
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon02.png" alt="">
          </div>
        </a>
        <a href="/m/service/list.php?menu=service" class="intro-btn right-btn intro-btn04">
          <div class="text-box">
            <p class="text01">제휴<br>서비스</p>
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon03.png" alt="">
          </div>
        </a>
        <a href="/m/used/list.php?menu=used" class="intro-btn right-btn intro-btn02">
          <div class="text-box">
            <p class="text01">중고장터</p>
          </div>
          <div class="icon">
            <img src="/src/img/intro-icon04.png" alt="">
          </div>
        </a>
      </div>
    </div>
	</div> -->

  <div class="container intro-sec intro-sec01">
    <p class="intro-txt01">언제나 사장님과 함께!</p>
    <p class="intro-txt02">
      <img src="/src/img/intro-txt02.png" alt="">
    </p>
    <p class="intro-txt03">식당 운영 원스탑 솔루션!</p>
  </div>

  <div class="container intro-sec intro-sec02">
    <a href="/" class="intro-sec-btn">
      <div class="txt-box">
        <p class="txt01">식자재 마켓</p>
        <p class="txt02">FOOD INGRENDIENTS MARKET</p>
      </div>
      <span class="baro">바로가기</span>
    </a>
  </div>

  <div class="container intro-sec intro-sec03">
    <p class="intro-sec03-txt01">
      <img src="/src/img/intro-sec03-txt01.png" alt="">
    </p>
    <div class="intro-sec03-btn-wrap">
      <div class="intro-sec03-btn-wrap-left">
        <a href="/m/used/list.php?menu=used" class="intro-sec-btn">
          <div class="txt-box">
            <p class="txt01">중고장터</p>
            <p class="txt02">USED MARKET</p>
          </div>
          <span class="baro">바로가기</span>
        </a>
      </div>
      <div class="intro-sec03-btn-wrap-right">
        <a href="/m/service/list.php?menu=service" class="intro-sec-btn btn001">
          <div class="txt-box">
            <p class="txt01">제휴서비스</p>
            <p class="txt02">AFFILIATE SERVICE</p>
          </div>
          <span class="baro">바로가기</span>
        </a>
        <a href="/m/store/list.php?menu=store" class="intro-sec-btn btn002">
          <div class="txt-box">
            <p class="txt01">회원사 현황</p>
            <p class="txt02">MEMBER COMPANY STATUS</p>
          </div>
          <span class="baro">바로가기</span>
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