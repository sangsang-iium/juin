<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

?>

<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>


<div id="smb_my">

	<div class="my-sec container">
		<div class="smb-my-info">
			<div class="smb-my-info-top">
				<p class="tit">
					<!-- <?php echo $member['name']; ?>님, 반가워요! -->
					<?php echo $member['name']; ?>님, <a href="https://juin.eumsvr.com/m/shop/testlog.php">반가워요!</a>
				</p>
				<a href="<?php echo BV_MBBS_URL; ?>/member_confirm.php?url=register_form.php" class="ui-btn sizeM" data="stIconLeft" >
					<img src="/src/img/icon-write.svg" alt="정보수정" class="icn">
					<span class="txt">정보수정</span>
				</a>
			</div>
			<div class="smb-my-cp-wrap">
				<ul class="smb-my-cp-list">
					<li>
						<a href="<?php echo BV_MSHOP_URL; ?>/point.php">
							<span>보유 포인트</span>
							<span class="icn"><img src="/src/img/icon-right-g.png" alt=""></span>
						</a>
						<p class="cont">
							<span class="value"><?php echo display_point($member['point']); ?></span>
							<span class="unit">P</span>
						</p>
					</li>
					<li>
						<a href="<?php echo BV_MSHOP_URL; ?>/coupon.php">
							<span>보유 쿠폰</span>
							<span class="icn"><img src="/src/img/icon-right-g.png" alt=""></span>
						</a>
						<p class="cont">
							<span class="value"><?php echo display_qty($cp_count); ?></span>
							<span class="unit">개</span>
						</p>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="my-sec container">
		<div class="smb-my-step-wrap">
			<ul class="smb-my-url-list">
				<li><a href="<?php echo BV_MSHOP_URL; ?>/orderinquiry.php">주문조회·재주문</a></li>
			</ul>
			<div class="smb-my-step-list">
				<?php

					$mb_id = $member['id'];
					$aaa = "select dan,count(dan) cnt from shop_order where mb_id='{$mb_id}' group by dan";
					// echo $aaa;
					// exit();
					$ros = sql_query($aaa);
					$c1=0;
					$c2=0;
					$c3=0;
					$c4=0;
					$c5=0;
					for($i=0;$ro=sql_fetch_array($ros);$i++){
						if($ro['dan']==1){$c1 = $ro['cnt'];}
						if($ro['dan']==2){$c2 = $ro['cnt'];}
						if($ro['dan']==3){$c3 = $ro['cnt'];}
						if($ro['dan']==4){$c4 = $ro['cnt'];}
						if($ro['dan']==5){$c5 = $ro['cnt'];}
					}
				?>

				<div class="smb-my-step-item active">
					<div class="num"><?=$c1?></div>
					<p class="cont">주문접수</p>
				</div>
				<div class="smb-my-step-right">
					<img src="/src/img/icon-right-g.png" alt="">
				</div>
				<div class="smb-my-step-item">
					<div class="num"><?=$c2?></div>
					<p class="cont">결제완료</p>
				</div>
				<div class="smb-my-step-right">
					<img src="/src/img/icon-right-g.png" alt="">
				</div>
				<div class="smb-my-step-item">
					<div class="num"><?=$c3?></div>
					<p class="cont">준비중</p>
				</div>
				<div class="smb-my-step-right">
					<img src="/src/img/icon-right-g.png" alt="">
				</div>
				<div class="smb-my-step-item">
					<div class="num"><?=$c4?></div>
					<p class="cont">배송중</p>
				</div>
				<div class="smb-my-step-right">
					<img src="/src/img/icon-right-g.png" alt="">
				</div>
				<div class="smb-my-step-item">
					<div class="num"><?=$c5?></div>
					<p class="cont">배송완료</p>
				</div>
			</div>
		</div>
	</div>

	<div class="my-sec container">
		<div class="smb-my-url-wrap">
			<ul class="pdc smb-my-url-list">
				<li class="pdt0"><a href="<?php echo BV_MSHOP_URL; ?>/wish.php">관심상품</a></li>
				<li class="pdb0"><a href="<?php echo BV_MSHOP_URL; ?>/card.php">카드관리</a></li>
			</ul>
		</div>
	</div>

	<div class="my-sec container">
		<div class="smb-my-url-wrap">
			<p class="smb-my-url-title">고객센터</p>
			<ul class="pdc smb-my-url-list">
				<li><a href="<?php echo BV_MBBS_URL;?>/qna_list.php">1대1 문의</a></li>
				<li><a href="<?php echo BV_MBBS_URL;?>/review.php">상품후기</a></li>
				<li><a href="<?php echo BV_MSHOP_URL;?>/regOrderList.php">정기 결제 내역</a></li>
				<li><a href="<?php echo BV_MSHOP_URL;?>/raffleList.php">레플 응모 내역</a></li>
				<li><a href="<?php echo BV_MBBS_URL;?>/affservice.php">제휴서비스</a></li>
				<li><a href="<?php echo BV_MBBS_URL;?>/board_list.php?boardid=13">공지사항</a></li>
				<li><a href="<?php echo BV_MBBS_URL;?>/faq.php">자주 묻는 질문</a></li>
				<li><a href="<?php echo BV_MBBS_URL;?>/policy.php">개인정보처리방침</a></li>
				<li><a href="javascript:(0)" class='od-dtn__change'>배송지관리</a></li>
				<li class="pdb0"><a href="<?php echo BV_MBBS_URL;?>/provision.php">이용약관</a></li>
			</ul>
		</div>
	</div>

	<div class="my-sec container border-none">
		<div class="smb-my-url-wrap">
			<ul class="pdc smb-my-url-list">
				<li class="pdb0 pdt0"><a href="<?php echo BV_MBBS_URL;?>/logout.php" class="non-arrow">로그아웃</a></li>
			</ul>
		</div>
	</div>

	<!-- <section id="smb_my_ov">
		<h2>회원정보 개요</h2>
		<ul>
			<li>보유쿠폰<a href="<?php echo BV_MSHOP_URL; ?>/coupon.php"><?php echo display_qty($cp_count); ?></a></li>
			<li>보유포인트<a href="<?php echo BV_MSHOP_URL; ?>/point.php"><?php echo display_point($member['point']); ?></a></li>
		</ul>
		<dl>
			<dt>연락처</dt>
			<dd><?php echo ($member['telephone'] ? $member['telephone'] : '미등록'); ?></dd>
			<dt>E-Mail</dt>
			<dd><?php echo ($member['email'] ? $member['email'] : '미등록'); ?></dd>
			<dt>최종접속일시</dt>
			<dd><?php echo $member['today_login']; ?></dd>
			<dt>회원가입일시</dt>
			<dd><?php echo $member['reg_time']; ?></dd>
			<dt class="ov_addr">주소</dt>
			<dd class="ov_addr"><?php echo sprintf("(%s)", $member['zip']).' '.print_address($member['addr1'], $member['addr2'], $member['addr3'], $member['addr_jibeon']); ?></dd>
		</dl>
	</section>

	<section id="smb_my_od">
		<h2 class="anc_tit">최근 주문내역<span class="fr"><a href="<?php echo BV_MSHOP_URL; ?>/orderinquiry.php" class="btn_txt">더보기<i class="fa fa-angle-right"></i></a></span></h2>
		<ul id="sod_inquiry">
			<?php
			$sql = " select *
					   from shop_order
					  where mb_id = '$member[id]'
						and dan != '0'
					  group by od_id
					  order by index_no desc limit 3 ";
			$result = sql_query($sql);
			for($i=0; $row=sql_fetch_array($result); $i++)
			{
				echo '<li>'.PHP_EOL;

				$sql = " select * from shop_cart where od_id = '$row[od_id]' ";
				$sql.= " group by gs_id order by io_type asc, index_no asc ";
				$res = sql_query($sql);
				for($k=0; $ct=sql_fetch_array($res); $k++) {
					$rw = get_order($ct['od_no']);
					$gs = unserialize($rw['od_goods']);

					$href = BV_MSHOP_URL.'/view.php?gs_id='.$rw['gs_id'];

					$dlcomp = explode('|', trim($rw['delivery']));

					$delivery_str = '';
					if($dlcomp[0] && $rw['delivery_no']) {
						$delivery_str = get_text($dlcomp[0]).' '.get_text($rw['delivery_no']);
					}

					$uid = md5($rw['od_id'].$rw['od_time'].$rw['od_ip']);

					if($k == 0) {
			?>
				<div class="inquiry_idtime">
					<a href="<?php echo BV_MSHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>&uid=<?php echo $uid; ?>" class="idtime_link"><?php echo $rw['od_id']; ?></a>
					<span class="idtime_time"><?php echo substr($rw['od_time'],2,8); ?></span>
				</div>
				<?php } ?>
				<div class="inquiry_info">
					<div class="inquiry_name">
						<a href="<?php echo $href; ?>"><?php echo get_text($gs['gname']); ?></a>
					</div>
					<div class="inquiry_price">
						<?php echo display_price($rw['use_price']); ?>
					</div>
					<div class="inquiry_inv">
						<span class="inv_status"><?php echo $gw_status[$rw['dan']]; ?></span>
						<span class="inv_inv"><?php echo $delivery_str; ?></span>
					</div>
				</div>

			<?php
				}
				echo '</li>'.PHP_EOL;
			}

			if($i == 0)
				echo '<li class="empty_list">주문 내역이 없습니다.</li>';
			?>
		</ul>
	</section>

	<section id="smb_my_wish">
		<h2 class="anc_tit">최근 위시리스트<span class="fr"><a href="<?php echo BV_MSHOP_URL; ?>/wish.php" class="btn_txt">더보기<i class="fa fa-angle-right"></i></a></span></h2>
		<ul>
			<?php
			$sql = " select *
				from shop_wish a, shop_goods b
								where a.mb_id = '{$member['id']}'
									and a.gs_id = b.index_no
								order by a.wi_id desc
								limit 0, 3 ";
			$result = sql_query($sql);
			for($i=0; $row=sql_fetch_array($result); $i++)
			{
					$image_w = 50;
					$image_h = 50;
					$image = get_it_image($row['gs_id'], $row['simg1'], $image_w, $image_h, true);
					$list_left_pad = $image_w + 10;
			?>
			<li style="padding-left:<?php echo $list_left_pad + 10; ?>px">
					<div class="wish_img"><?php echo $image; ?></div>
					<div class="wish_info"><a href="<?php echo BV_MSHOP_URL; ?>/view.php?gs_id=<?php echo $row['gs_id']; ?>"><?php echo stripslashes($row['gname']); ?></a></div>
					<span class="info_date">보관일 <?php echo substr($row['wi_time'], 2, 8); ?></span>
			</li>
			<?php
			}
			if($i == 0) echo '<li class="empty_list">보관 내역이 없습니다.</li>';
			?>
		</ul>
	</section> -->
</div>
<!-- 배송지 목록 팝업 { -->
	<div id="delv-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">배송지 목록</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in"></div>
    </div>
  </div>
</div>
<!-- } 배송지 목록 팝업 -->

<!-- 배송지 추가 팝업 { -->
	<div id="delv-write-popup" class="popup type02 add-popup add-in-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">배송지 추가</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in"></div>
    </div>
  </div>
</div>
<!-- } 배송지 추가 팝업 -->

<script type="module">
import * as f from '/src/js/function.js';
$(function() {
    //배송지 목록 팝업
    const delvPopId = "delv-popup";
    $(".od-dtn__change").on("click", function() {
      $.ajax({
        url: './orderaddress.php',
        success: function(data) {
          $(`#${delvPopId}`).find(".pop-content-in").html(data);
          $(".popDim").show();
          f.popupOpen(delvPopId);
		  $(".sel_address").hide();
        }
      });
    });

	 //배송지 추가 팝업
	const delvWritePopId = "delv-write-popup";
	$(`#${delvPopId}`).on("click", ".od-dtn__add", function() {
		$.ajax({
			url: './orderaddress_write.php',
			success: function(data) {
			$(`#${delvWritePopId}`).find(".pop-content-in").html(data);
			f.popupOpen(delvWritePopId);
			}
		});
	});
});
  </script>