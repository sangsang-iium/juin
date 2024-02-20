<?php
include_once("./_common.php");

check_demo();

check_admin_token();

if(!$pf_auth_pg)
	alert('개별 PG결제 사용 권한이 없습니다.');

$adm_bank = array();
for($i=0; $i<count($_POST['bank_name']); $i++) {
	if(!trim($_POST['bank_name'][$i])) continue;

	$adm_bank[$i]['name'] = trim($_POST['bank_name'][$i]);
	$adm_bank[$i]['account'] = trim($_POST['bank_account'][$i]);
	$adm_bank[$i]['holder'] = trim($_POST['bank_holder'][$i]);
}

unset($value);
$value['de_bank_account']		= serialize($adm_bank);
$value['de_bank_use']			= $_POST['de_bank_use']; // 무통장입금
$value['de_card_use']			= $_POST['de_card_use']; // 신용카드
$value['de_iche_use']			= $_POST['de_iche_use']; // 계좌이체
$value['de_vbank_use']			= $_POST['de_vbank_use']; // 가상계좌
$value['de_hp_use']				= $_POST['de_hp_use']; // 휴대폰
$value['de_card_test']			= $_POST['de_card_test']; // 결제 테스트
$value['de_pg_service']			= $_POST['de_pg_service']; // 결제대행사
$value['de_tax_flag_use']		= $_POST['de_tax_flag_use']; // 복합과세 결제
$value['de_taxsave_use']		= $_POST['de_taxsave_use']; // 현금영수증 발급사용
$value['de_card_noint_use']		= $_POST['de_card_noint_use']; // 신용카드 무이자할부사용
$value['de_easy_pay_use']		= $_POST['de_easy_pay_use']; // PG사 간편결제 버튼사용
$value['de_escrow_use']			= $_POST['de_escrow_use']; // Escrow 사용여부
$value['de_kcp_mid']			= $_POST['de_kcp_mid']; // NHN KCP SITE CODE
$value['de_kcp_site_key']		= $_POST['de_kcp_site_key']; // NHN KCP SITE KEY
$value['de_lg_mid']				= $_POST['de_lg_mid']; // LG유플러스 상점아이디
$value['de_lg_mert_key']		= $_POST['de_lg_mert_key']; // LG유플러스 MertKey
$value['de_inicis_mid']			= $_POST['de_inicis_mid']; // KG이니시스 상점아이디
$value['de_inicis_admin_key']	= $_POST['de_inicis_admin_key']; // KG이니시스 키패스워드
$value['de_inicis_sign_key']	= $_POST['de_inicis_sign_key']; // KG이니시스 웹결제 사인키
$value['de_samsung_pay_use']	= $_POST['de_samsung_pay_use']; // KG이니시스 삼성페이 버튼
update("shop_partner",$value,"where mb_id='$member[id]'");

goto_url(BV_MYPAGE_URL.'/page.php?code=partner_pg');
?>