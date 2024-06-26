<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

if(!isset($tb['title'])) {
    $tb['title'] = get_head_title('head_title', $pt_id);
    $bv_head_title = $tb['title'];
}
else {
    $bv_head_title = $tb['title']; // 상태바에 표시될 제목
    $bv_head_title .= " | ".get_head_title('head_title', $pt_id);
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$tb['lo_location'] = addslashes($tb['title']);
if(!$tb['lo_location'])
    $tb['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$tb['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if(strstr($tb['lo_url'], '/'.BV_ADMIN_DIR.'/') || is_admin()) $tb['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="HandheldFriendly" content="true">
<meta name="format-detection" content="telephone=no">
<?php
include_once(BV_LIB_PATH.'/seometa.lib.php');

if($config['add_meta'])
    echo $config['add_meta'].PHP_EOL;
?>
<title><?php echo $bv_head_title; ?></title>

<link rel="stylesheet" href="<?php echo BV_MCSS_URL; ?>/default.css?ver=<?php echo BV_CSS_VER;?>">
<?php if(defined('BV_MTHEME_URL')) { ?>
<link rel="stylesheet" href="<?php echo BV_MTHEME_URL; ?>/style.css?ver=<?php echo BV_CSS_VER;?>">
<!-- <link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/style_md.css?ver=<?php echo BV_CSS_VER; ?>"> 스타일css_김민규 -->
<?php } ?>
<?php if($ico = display_logo_url('favicon_ico')) { // 파비콘 ?>
<link rel="shortcut icon" href="<?php echo $ico; ?>" type="image/x-icon">
<?php } ?>

<script>
var bv_url = "<?php echo BV_URL; ?>";
var bv_bbs_url = "<?php echo BV_BBS_URL; ?>";
var bv_shop_url = "<?php echo BV_SHOP_URL; ?>";
var bv_mobile_url = "<?php echo BV_MURL; ?>";
var bv_mobile_bbs_url = "<?php echo BV_MBBS_URL; ?>";
var bv_mobile_shop_url = "<?php echo BV_MSHOP_URL; ?>";
var bv_is_member = "<?php echo $is_member; ?>";
var bv_is_mobile = "<?php echo BV_IS_MOBILE; ?>";
var bv_cookie_domain = "<?php echo BV_COOKIE_DOMAIN; ?>";
// var login_check = ( bv_is_member == 1 ) ? true : false ;
</script>

<!-- APP WebView 통신 _20240305_SY -->
<!-- APP 카테고리 통신 안씀 _ 20240307_SY -->
<script>

// userAgent : MASTER_AOS
// var isMobile = {
//   Android: function() {
//     return /MASTER_AOS/i.test(navigator.userAgent);
//   },
//   IOS: function() {
//     return /MASTER_AOS/i.test(navigator.userAgent);
//   },
//   any: function() {
//     return (isMobile.Android() || isMobile.IOS());
//   }
// };

// function sendMenuCode(data) {

//   $.ajax({
//     url: bv_url+"/m/bbs/ajax.app_cate.php",
//     type: "POST",
//     data: { "data" : data },
//     dataType: "JSON",
//     success: function(data) {
//       SBC.showToast(data.res);
//     }
//   });
// }


// function caIdValueCallback(caIdValue) {
//   console.log('Received caIdValue:', caIdValue);
//   sendMenuCode(caIdValue)
// }

</script>


<script src="<?php echo BV_JS_URL; ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo BV_JS_URL; ?>/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.js"></script>
<script src="<?php echo BV_JS_URL; ?>/slick.js"></script>
<script src="<?php echo BV_MJS_URL; ?>/common.js?ver=<?php echo BV_JS_VER;?>"></script>
<script src="<?php echo BV_MJS_URL; ?>/iscroll.js?ver=<?php echo BV_JS_VER;?>"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.css">
<link rel="stylesheet" href="/src/plugin/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/src/css/fonts.css?ver=<?php echo BV_CSS_VER;?>">
<link rel="stylesheet" href="/src/css/common.css?ver=<?php echo BV_CSS_VER;?>">
<link rel="stylesheet" href="/src/css/ui.css?ver=<?php echo BV_CSS_VER;?>">
<link rel="stylesheet" href="/src/css/normal.css?ver=<?php echo BV_CSS_VER;?>">
<link rel="stylesheet" href="/src/css/responsive.css?ver=<?php echo BV_CSS_VER;?>">

<script src="/src/plugin/feather.min.js" defer></script>
<script src="/src/plugin/prefixfree.min.js" defer></script>
<script src="/src/plugin/matchheight/jquery.matchHeight.js" defer></script>
<script src="/src/plugin/swiper/swiper-bundle.min.js" defer></script>
<script src="/src/js/common.js?ver=<?php echo BV_JS_VER;?>" defer></script>
<script src="/src/js/normal.js?ver=<?php echo BV_JS_VER;?>" type="module" defer></script>
<script>
// Alert - 현재 페이지 유지
function iAlert_re(swText) {
  Swal.fire({
    html: swText,
    icon: 'warning',  //success
    showCancelButton: false,
    confirmButtonText: '확인'
  });
};
if(document.getElementById) {
  window.alert = function(txt) {
    iAlert_re(txt);
  }
}
</script>
<?php
if($config['head_script']) { // head 내부태그
    echo $config['head_script'].PHP_EOL;
}
?>
</head>
<body<?php echo isset($tb['body_script']) ? $tb['body_script'] : ''; ?>>
<div id="document">