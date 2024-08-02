<?php
if (!defined("_BLUEVATION_")) {
  exit;
}
// 개별 페이지 접근 불가

include_once "./_head.php";
header('Access-Control-Allow-Origin: *');

$myLocation = json_encode($_SERVER['HTTP_MYLOCATION']);
$myLocation2 = json_encode($_SERVER);
if(isset($_SERVER['HTTP_MYLOCATION']) && !empty($_SERVER['HTTP_MYLOCATION'])) {
  set_session('myLocation', $myLocation);
}
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
    <?php if(!$is_member) { ?>
    <div class="intro-bottom-btn-box">
      <!-- <a href="/" class="home-btn">
        <img src="/src/img/intro-home-btn.png" alt="">
      </a> -->
      <a href="<?php echo BV_MBBS_URL;?>/login.php" class="login-btn" style="width:100%;">
        <span><img src="/src/img/intro-login-icon.png" alt=""></span>
        <span>로그인</span>
      </a>
    </div>
    <div class="intro-join-btn-box">
      <a href="<?php echo BV_MBBS_URL;?>/register.php?type=1" class="join-btn">
        <span class="icon"><img src="/src/img/intro-join-icon01.png" alt=""></span>
        <span>한국외식업중앙회 회원가입</span>
      </a>
      <a href="<?php echo BV_MBBS_URL;?>/register.php?type=2" class="join-btn">
        <span class="icon"><img src="/src/img/intro-join-icon02.png" alt=""></span>
        <span>개인/사업자 회원가입</span>
      </a>
    </div>
    <!-- <p class="intro-bottom-text">아직 주인장 계정이 없으신가요? <a href="<?php echo BV_MBBS_URL;?>/register_type.php">회원가입</a></p> -->
    <?php } ?>
  </div>

</div>

<?php
include_once "./_tail.php";
?>