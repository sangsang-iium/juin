<?php
if(!defined('_BLUEVATION_')) exit;

if(!$tb['title'])
    $tb['title'] = '관리자 페이지';
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?php echo $tb['title']; ?></title>
<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/admin.css?ver=<?php echo BV_CSS_VER; ?>">
<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/reset_md.css?ver=<?php echo BV_CSS_VER; ?>"> <!-- 리셋css_김민규 -->
<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/style_md.css?ver=<?php echo BV_CSS_VER; ?>"> <!-- 스타일css_김민규 -->
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

<!-- timepicker 추가 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</head>
<body>
