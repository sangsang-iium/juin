<?php
include_once("./_common.php");
include_once(BV_MYPAGE_PATH."/admin_menu.php");

// mng로그인 시 $member 사용 불가 _20240723_SY
$member = $member2;

if(!is_seller($member['id'])) {
	alert('공급사 회원만 접속 가능합니다..', '/m/bbs/login_seller.php');
}

if(!$is_member) {
	// alert('로그인 후 이용하세요.', BV_MBBS_URL.'/login.php');
	alert('로그인 후 이용하세요.', '/m/bbs/login_seller.php');
}

if(is_partner($member['id'])) {
	if($member['homepage'])
		$admin_shop_url = set_http($member['homepage']);
	else
		$admin_shop_url = set_http($member['id'].'.'.$config['admin_shop_url']);

	// 월관리비를 사용중인가?
	if($config['pf_expire_use'] && !is_null_time($member['term_date'])) {
		$partner_term = '<em>(가맹점 만료일: '.$member['term_date'].')</em>';
	}
} else {
	$admin_shop_url = "/";
}

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>마이페이지</title>
<link rel="stylesheet" href="<?php echo BV_MYPAGE_URL; ?>/css/mypage.css?ver=<?php echo BV_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/style_md.css?ver=<?php echo BV_CSS_VER; ?>"> <!-- 스타일공통css_김민규 -->
<link rel="stylesheet" href="<?php echo BV_MYPAGE_URL; ?>/css/style_mg.css?ver=<?php echo BV_CSS_VER; ?>"><!-- 공급사css_김민규 -->
<?php if($ico = display_logo_url('favicon_ico')) { // 파비콘 ?>
<link rel="shortcut icon" href="<?php echo $ico; ?>" type="image/x-icon">
<?php } ?>
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var bv_url		 = "<?php echo BV_URL; ?>";
var bv_bbs_url	 = "<?php echo BV_BBS_URL; ?>";
var bv_shop_url  = "<?php echo BV_SHOP_URL; ?>";
var bv_admin_url = "<?php echo BV_ADMIN_URL; ?>";
</script>
<script src="<?php echo BV_JS_URL; ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo BV_JS_URL; ?>/jquery-ui-1.10.3.custom.js"></script>
<script src="<?php echo BV_JS_URL; ?>/common.js?ver=<?php echo BV_JS_VER; ?>"></script>
<script src="<?php echo BV_JS_URL; ?>/categorylist.js?ver=<?php echo BV_JS_VER; ?>"></script>
</head>
<body>
<div id="header"<?php if($admin_seller) { ?> class="supply"<?php } ?>>
	<?php if($admin_partner) { ?>
	<!-- <h1><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=partner_info">가맹점 관리자</a></h1> -->
	<?php } ?>
	<?php if($admin_seller) { ?>
	<h1><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=seller_main">공급사 관리자</a></h1>
	<?php } ?>
	<div id="tnb">
		<ul>
			<li><?php echo get_text($member['name']); ?>님! 접속중..<?php echo $partner_term; ?></li>
			<li>고객센터 : <?php echo $config['company_tel']; ?></li>
			<li><a href="<?php echo $admin_shop_url; ?>">쇼핑몰</a></li>
			<?php if(is_partner($member['id'])) { ?>
			<!-- <li><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=partner_info">가맹점 관리</a></li> -->
			<?php } ?>
			<?php if(is_seller($member['id'])) { ?>
			<li><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=seller_main">공급사 관리</a></li>
			<?php } ?>
			<li id="tnb_logout"><a href="<?php echo BV_BBS_URL; ?>/logout.php">로그아웃</a></li>
		</ul>
	</div>
</div>
