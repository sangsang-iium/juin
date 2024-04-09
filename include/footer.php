<button type="button" class="ui-btn round-per50 btn-moveTop" onclick="$('html,body').animate({scrollTop:0},600);"></button>

<div id="footer">
  <nav class="container fnb">
    <a href="" class="btn on">개인정보처리방침</a>
    <a href="" class="btn">이용약관</a>
  </nav>
  <div class="container fbody">
    <p class="cname">(사)한국외식업중앙회 외식가족공제회</p>
    <p class="cinfo">주소 : 서울특별시 중구 동호로12길 87, 3층(신당동)
                    <br/>대표자: 전강식
                    <br/>사업자등록번호 243-82-00210
                    <br/>대표번호 : 1544-3399</p>
    <p class="copyright">Copyright ⓒ 주인장터. All rights reserved.</p>
  </div>
</div>

<?php if ($_SERVER['REMOTE_ADDR']=="106.247.231.170") { ?>
<ul class="container" style="display: flex; flex-flow: row wrap; gap: 10px; margin-top: 10px; font-size: 15px; font-weight: bold;">
  <li><a href="/">메인</a></li>
  <?php if($is_admin) { ?>
  <li><a href="<?php echo $is_admin;?>" target="_blank">관리자</a></li>
  <?php } ?>
  <?php if($is_member) { ?>
  <li><a href="<?php echo BV_MBBS_URL;?>/logout.php">로그아웃</a></li>
  <?php } else { ?>
  <li><a href="<?php echo BV_MBBS_URL;?>/login.php">로그인</a></li>
  <li><a href="<?php echo BV_MBBS_URL;?>/register.php">회원가입</a></li>
  <?php } ?>
  <li><a href="<?php echo BV_MSHOP_URL;?>/mypage.php">마이페이지</a></li>
  <li><a href="<?php echo BV_MSHOP_URL;?>/cart.php">장바구니</a></li>
  <li><a href="<?php echo BV_MSHOP_URL;?>/orderinquiry.php">주문/배송조회</a></li>
  <li><a href="<?php echo BV_MBBS_URL;?>/faq.php?faqcate=1">고객센터</a></li>
</ul>
<?php } ?>