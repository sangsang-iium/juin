<?php
if(!defined('_BLUEVATION_')) exit;

// $member2 추가 _20240624_SY
if(isset($member2['id'])) {
  $member = get_member($member2['id']);
}

if(defined('_INDEX_')) { // index에서만 실행
	include_once(BV_LIB_PATH.'/popup.inc.php'); // 팝업레이어
}
if (!empty($paytype)) {
  $paytypeurl = "&paytype=" . $paytype;
} else {
  $paytype = "2";
}
?>

<style>
	/* #gnb {border-bottom: none;}
	#gnb_inner {height: auto; width: 1400px; max-width: 100%; padding-left: 0;}
	#gnb_inner .all_cate {position: static;}
	#gnb_inner .all_cate .con_bx {position: static; display: block; padding:0;}
	#gnb_inner .all_cate .con_bx .c_box {padding:0;}
	.c_box .active a {color: red; font-weight:600} */
</style>

<div id="wrapper">
	<div id="header">
		<div id="tnb">
			<div id="tnb_inner">
				<ul class="fr">
					<?php
          if($is_member) {
            echo '<li><span style="color: blue;">'.$member['name'].'</span>님</li>';
          }

					$tnb = array();
					$tnb[] = '<li><a href="'.BV_MNG_SHOP_URL.'/cart.php">장바구니<span class="ic_num">'. get_cart_count_for_mng($member['id']).'</span></a></li>';
					$tnb[] = '<li><a href="'.BV_MNG_SHOP_URL.'/orderinquiry.php">주문/배송조회</a></li>';
					$tnb_str = implode(PHP_EOL, $tnb);
					echo $tnb_str;
					?>
				</ul>
			</div>
		</div>
		<div id="hd">
			<!-- 상단부 영역 시작 { -->
			<div id="hd_inner">
				<h1 class="hd_logo">
					<?php // echo display_logo(); ?>
          <a href="/mng/">
            <img src="/img/logo.png" alt="주인장">
          </a>
				</h1>
				<!-- <div id="hd_sch">
					<fieldset class="sch_frm">
						<legend>사이트 내 전체검색</legend>
						<form name="fsearch" id="fsearch" method="post" action="<?php //echo BV_SHOP_URL; ?>/search.php" onsubmit="return fsearch_submit(this);" autocomplete="off">
						<input type="hidden" name="hash_token" value="<?php //echo BV_HASH_TOKEN; ?>">
						<input type="text" name="ss_tx" class="sch_stx" maxlength="20" placeholder="검색어를 입력해주세요">
						<button type="submit" class="sch_submit fa fa-search" value="검색"></button>
						</form>
						<script>
						function fsearch_submit(f){
							if(!f.ss_tx.value){
								alert('검색어를 입력하세요.');
								return false;
							}
							return true;
						}
						</script>
					</fieldset>
				</div> -->
			</div>
			<div id="gnb">
				<div id="gnb_inner">
					<div class="all_cate">
						<span class="allc_bt"> 전체카테고리</span>
						<!-- <i class="fa fa-bars"></i> -->
						<div class="con_bx">
                            <div class="menubg_box"></div>
							<ul>
							<?php
                            // 메뉴 on 여부 변수 김민규
							$menu_check = substr($_GET["ca_id"],0, 3);
							$menu_on = "";

							$mod = 5;
							$res = sql_query_cgy('all');

                            $mleng = 0;
							for($i=0; $row=sql_fetch_array($res); $i++) {
								$href = '/mng/?ca_id='.$row['catecode'];
                                $menu_on = $menu_check == $row['catecode'] ? 'menu_on' : '';
								// if($i && $i%$mod == 0) echo "</ul>\n<ul>\n";
							?>
								<li class="c_box">
									<div class="c_boxTitle">
                                        <a href="<?php echo $href; ?>" class="cate_tit <?php echo $menu_on ?>"><?php echo $row['catename']; ?></a>
                                    </div>
									<?php
									$r = sql_query_cgy($row['catecode'], 'COUNT');
									if($r['cnt'] > 0) {
                                        if($r['cnt'] === 0 || $mleng < $r['cnt']) {
                                            $mleng = $r['cnt'];
                                        }
									?>
									<ul class="sub_caterogy">
										<?php
										$res2 = sql_query_cgy($row['catecode']);
										while($row2 = sql_fetch_array($res2)) {
											// $href2 = BV_SHOP_URL.'/list.php?ca_id='.$row2['catecode'];
											$href2 = '/mng/?ca_id='.$row2['catecode'].'&paytype='.$paytype;
										?>
										<li class="<?php echo $row2['catecode'] == $ca_id?"active":"" ?>"><a href="<?php echo $href2; ?>"><?php echo $row2['catename']; ?></a></li>
										<?php } ?>
									</ul>
									<?php } ?>
								</li>
							<?php
							}
							$li_cnt = ($i%$mod);
							if($li_cnt) { // 나머지 li
								for($i=$li_cnt; $i<$mod; $i++)
									echo "<li></li>\n";
							}
							?>
							</ul>
						</div>

                        <script>
                            $(document).ready(function(){
                                $('.menubg_box').css('height', <? echo $mleng?> * 45)
                                $('#gnb').on("mouseenter",function(){
                                    $('.sub_caterogy, .menubg_box').slideDown(100);
                                });
                                $('#gnb').on("mouseleave",function(){
                                    $('.sub_caterogy, .menubg_box').slideUp(100);
                                });
                                // $('.c_box').css("height",$(this).children("ul").children('li').length * 43)
                                // console.log($('.c_box').find($(this)));
                            });
                        </script>
						<!-- <script>
						$(function(){
							$('.all_cate .allc_bt').click(function(){
								if($('.all_cate .con_bx').css('display') == 'none'){
									$('.all_cate .con_bx').show();
									$(this).html('<i class="ionicons ion-ios-close-empty"></i> 전체카테고리');
								} else {
									$('.all_cate .con_bx').hide();
									$(this).html('<i class="fa fa-bars"></i> 전체카테고리');
								}
							});
						});
						</script> -->
					</div>
				</div>
			</div>
			<!-- } 상단부 영역 끝 -->
			<!-- <script>
			$(function(){
				// 상단메뉴 따라다니기
				var elem1 = $("#hd_banner").height() + $("#tnb").height() + $("#hd_inner").height();
				var elem2 = $("#hd_banner").height() + $("#tnb").height() + $("#hd").height();
				var elem3 = $("#gnb").height();
				$(window).scroll(function () {
					if($(this).scrollTop() > elem1) {
						$("#gnb").addClass('gnd_fixed');
						$("#hd").css({'padding-bottom':elem3})
					} else if($(this).scrollTop() < elem2) {
						$("#gnb").removeClass('gnd_fixed');
						$("#hd").css({'padding-bottom':'0'})
					}
				});
			});
			</script> -->
		</div>
	</div>

	<div id="container">
		<?php
		//if(!is_mobile()) { // 모바일접속이 아닐때만 노출
		//	include_once(BV_THEME_PATH.'/quick.skin.php'); // 퀵메뉴
		//}

		if(!defined('_INDEX_')) { // index가 아니면 실행
			echo '<div class="cont_inner">'.PHP_EOL;
		}
		?>
