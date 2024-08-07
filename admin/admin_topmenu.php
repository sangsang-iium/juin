<?php
if(!defined('_BLUEVATION_')) exit;

// 추가 _20240617_SY
if($_SESSION['ss_mn_id']) {
  $url = "?url=/admin/";
} else {
  $url = "";
}
?>

<header id="hd">
	<div id="hd_wrap">
		<h1>
            <span><?php echo $config['shop_name']; ?></span>
            <a href="<?php echo BV_ADMIN_URL; ?>/" id="logo">
                <img src="<?php echo BV_ADMIN_URL; ?>/img/images/common/juin_logo.png" alt="<?php echo $config['shop_name']; ?> 관리자">
            </a>
        </h1>
		<nav id="gnb">
			<h2>관리자 주메뉴</h2>
			<ul id="gnb_1dul">
                <?php echo getMenuFunc("ADMIN_MENU1",  "member",   "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU3",  "seller",   "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU4",  "category", "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU5",  "goods",    "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU6",  "order",    "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU7",  "visit",    "regmonth")?>
                <?php echo getMenuFunc("ADMIN_MENU8",  "help",     "qa"); ?>
                <?php echo getMenuFunc("ADMIN_MENU9",  "design",   "mbanner_list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU11", "used",     "list"); ?>
                <?php echo getMenuFunc("ADMIN_MENU12", "service",  "list"); ?>
                <?php echo $member['id'] == "admin" ? getMenuFunc("ADMIN_MENU10", "config",   "default") : getMenuFunc("ADMIN_MENU10", "config",   "manager_list"); ?>

				<!-- <li class="gnb_1dli<?php if($pg_title == ADMIN_MENU1){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/member.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU1; ?></a>
				</li> -->
				<!-- <li class="gnb_1dli<?php if($pg_title == ADMIN_MENU2){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/partner.php?code=plist" class="gnb_1da"><?php echo ADMIN_MENU2; ?></a>
				</li> -->
				<!-- <li class="gnb_1dli<?php if($pg_title == ADMIN_MENU3){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/seller.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU3; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU4){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/category.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU4; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU5){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/goods.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU5; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU6){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/order.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU6; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU7){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/visit.php?code=hour" class="gnb_1da"><?php echo ADMIN_MENU7; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU8){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/help.php?code=qa" class="gnb_1da"><?php echo ADMIN_MENU8; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU9){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/design.php?code=mbanner_list" class="gnb_1da"><?php echo ADMIN_MENU9; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU11){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/used.php?code=list" class="gnb_1da"><?php echo ADMIN_MENU11; ?></a>
				</li>
				<li class="gnb_1dli<?php if($pg_title == ADMIN_MENU10){ ?> active<?php } ?>">
					<a href="<?php echo BV_ADMIN_URL; ?>/config.php?code=default" class="gnb_1da"><?php echo ADMIN_MENU10; ?></a>
				</li> -->
        <!-- 제휴서비스 주석 _20240625_SY -->
				<!-- <li class="gnb_1dli<?php if($pg_title == ADMIN_MENU12){ ?> active<?php } ?>"> -->
				<!-- 제휴서비스 작업할때 주석 변경 -->
					<!-- <a href="<?php echo BV_ADMIN_URL; ?>/config.php?code=default" class="gnb_1da"><?php echo ADMIN_MENU12; ?></a> -->
					<!-- <a href="javascript:alert('작업중')" class="gnb_1da"><?php echo ADMIN_MENU12; ?></a>
				</li> -->
			</ul>
		</nav>
    </div>
    <div id="tnb">
        <ul>
            <!-- <li><?php echo $super['vi_history']; ?></li> -->
            <li><a href="<?php echo BV_ADMIN_URL; ?>/config.php?code=super">관리자정보</a></li>
            <li><a href="<?php echo BV_ADMIN_URL; ?>/">관리자홈</a></li>
            <!-- <li><a href="<?php echo BV_URL; ?>" target="_blank">쇼핑몰</a></li> -->
            <li id="tnb_logout"><a href="<?php echo BV_BBS_URL; ?>/logout.php<?php echo $url ?>">로그아웃</a></li>
        </ul>
    </div>
</header>
<div id="wrapper">
	<?php
	if(!defined('NO_CONTAINER')) {
		include_once(BV_ADMIN_PATH."/admin_snb.php");
	?>
	<div id="content">
		<div class="breadcrumb">
			<span>HOME</span> <i class="ionicons ion-ios-arrow-right"></i> <?php echo $pg_title; ?> <i class="ionicons ion-ios-arrow-right"></i> <?php echo $pg_title2; ?>
		</div>
	<?php } ?>
