<?php
if(!defined('_BLUEVATION_')) exit;

if(!$is_member) {
	// goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);
  // 경로 수정 _20240619_SY
	goto_url(BV_MBBS_URL.'/login_mng.php?url='.$urlencode);
}

// admin 세션 변수에 등록
$admin_id = get_session('admin_ss_mb_id');

if($admin_id) {
	set_session('ss_mb_id', $admin_id);

	$member = sql_fetch("select * from shop_member where id = '".$admin_id."'");

  // Manager Check _20240527_SY
  if($_SESSION['ss_mn_id']) {
    $member = sql_fetch("SELECT * FROM shop_manager WHERE id = '".$admin_id."'");
  }

	// 초기화
	unset($admin_id);
	set_session('admin_ss_mb_id', '');
}

if(!is_admin()) {
	alert('관리자 권한이 없습니다.', BV_URL);
}
?>