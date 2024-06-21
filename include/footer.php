<button type="button" class="ui-btn round-per50 btn-moveTop" onclick="$('html,body').animate({scrollTop:0},600);"></button>

<div id="footer">
  <nav class="container fnb">
    <a href="/m/bbs/policy.php" class="btn on">개인정보처리방침</a>
    <a href="/m/bbs/provision.php" class="btn">이용약관</a>
  </nav>
  <div class="container fbody">
    <p class="cname"><?php echo $config['company_name']?></p>
    <p class="cinfo">주소 : <?php echo $config['company_zip']?> <?php echo $config['company_addr']?>
                    <br/>대표자: <?php echo $config['company_owner']?>
                    <br/>사업자등록번호 : <?php echo $config['company_saupja_no']?>
                    <br/>통신판매업번호 : 제 <?php echo $config['tongsin_no']?> 호
                    <br/>대표번호 : <?php echo $config['company_tel']?></p>
    <p class="copyright">Copyright ⓒ 주인장터. All rights reserved.</p>
  </div>
</div>

<?php //if ($_SERVER['REMOTE_ADDR']=="106.247.231.170") { ?>
<ul class="container" style="display: flex; flex-flow: row wrap; gap: 10px; margin-top: 10px; font-size: 15px; font-weight: bold;">
  <li><a href="/">메인</a></li>
  <?php if($is_admin) {
    if (is_seller($member['id'])){ ?>
    <li><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=seller_main">공급사 관리</a></li>
    <?php } else { ?>
    <li><a href="<?php echo $is_admin;?>" target="_blank">관리자</a></li>
    <?php }
    }  ?>
  <?php if($is_member) { ?>
  <li><a href="<?php echo BV_MBBS_URL;?>/logout.php">로그아웃</a></li>
  <?php } else { ?>
  <li><a href="<?php echo BV_MBBS_URL;?>/login.php">로그인</a></li>
  <li><a href="<?php echo BV_MBBS_URL;?>/register_type.php">회원가입</a></li>
  <?php } ?>
  <li><a href="<?php echo BV_MSHOP_URL;?>/mypage.php">마이페이지</a></li>
  <li><a href="<?php echo BV_MSHOP_URL;?>/cart.php">장바구니</a></li>
  <li><a href="<?php echo BV_MSHOP_URL;?>/orderinquiry.php">주문/배송조회</a></li>
  <li><a href="<?php echo BV_MBBS_URL;?>/faq.php?faqcate=1">고객센터</a></li>
  <li><a href="/m/raffle/list.php?menu=raffle">중고장터</a></li>
  <li><a href="/m/used/list.php?menu=used">중고장터</a></li>
  <li><a href="/m/store/list.php?menu=store">회원사현황</a></li>
  <li><a href="/m/service/list.php?menu=service">제휴서비스</a></li>
  <li><a href="/m/shop/introjuin.php">인트로</a></li>
</ul>
<?php //} ?>