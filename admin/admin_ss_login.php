<?php
include_once "_common.php";

// 관리자 세션 변수에 등록
if (is_admin()) {
  set_session('admin_ss_mb_id', get_session('ss_mb_id'));
}

print_r2($_GET);
// 세션 변수에 등록
set_session('ss_mb_id', $_GET['mb_id']);

exit;
// lg_type=M 추가 _20240408_SY
if ($_GET['lg_type'] == 'S') {
  goto_url(BV_MYPAGE_URL . '/page.php?code=seller_main');
} else if ($_GET['lg_type'] == 'P') {
  goto_url(BV_MYPAGE_URL . '/page.php?code=partner_info');
} else if ($_GET['lg_type'] == 'M') {
	unset($_SESSION['myCart']);
  goto_url(BV_URL . '/mng/');
} else {
  goto_url(BV_URL);
}

?>