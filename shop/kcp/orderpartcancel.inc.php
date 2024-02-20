<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

if($od['od_pg'] != 'kcp') return;

include_once(BV_SHOP_PATH.'/settle_kcp.inc.php');

// locale ko_KR.euc-kr 로 설정
setlocale(LC_CTYPE, 'ko_KR.euc-kr');

// 부분취소 실행
$g_conf_site_cd   = $default['de_kcp_mid'];
$g_conf_site_key  = $default['de_kcp_site_key'];
$g_conf_home_dir  = BV_SHOP_PATH.'/kcp';
$g_conf_key_dir   = '';
$g_conf_log_dir   = '';
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
{
    $g_conf_key_dir   = BV_SHOP_PATH.'/kcp/bin/pub.key';
    $g_conf_log_dir   = BV_SHOP_PATH.'/kcp/log';
}

if(preg_match("/^T000/", $g_conf_site_cd) || $default['de_card_test']) {
    $g_conf_gw_url  = "testpaygw.kcp.co.kr";
}
else {
    $g_conf_gw_url  = "paygw.kcp.co.kr";
}

include_once(BV_SHOP_PATH.'/kcp/pp_cli_hub_lib.php');

$tno            = $od['od_tno'];
$req_tx         = 'mod';
$mod_desc       = iconv_euckr($mod_memo);
$cust_ip        = getenv('REMOTE_ADDR');
$rem_mny        = (int)$od_receipt_price;
$mod_mny        = (int)$tax_mny;
$mod_free_mny   = (int)$free_mny;
$mod_type       = 'RN07';
if($od['paymethod'] == '계좌이체')
    $mod_type   = 'STPA';

if($od['od_tax_flag']) {
    $mod_mny = $tax_mny + $free_mny;
}

$c_PayPlus  = new C_PAYPLUS_CLI_T;
$c_PayPlus->mf_clear();

if( $req_tx == "mod" )
{
    $tran_cd = "00200000";

    $c_PayPlus->mf_set_modx_data( "tno"          , $tno                  );  // KCP 원거래 거래번호
    $c_PayPlus->mf_set_modx_data( "mod_type"     , $mod_type			 );  // 원거래 변경 요청 종류
    $c_PayPlus->mf_set_modx_data( "mod_ip"       , $cust_ip				 );  // 변경 요청자 IP
    $c_PayPlus->mf_set_modx_data( "mod_desc"     , $mod_desc			 );  // 변경 사유
    $c_PayPlus->mf_set_modx_data( "rem_mny"      , strval($rem_mny)      );  // 취소 가능 잔액
    $c_PayPlus->mf_set_modx_data( "mod_mny"      , strval($mod_mny)      );  // 취소 요청 금액

    if($od['od_tax_flag'])
    {
        $mod_tax_mny = round((int)$tax_mny / 1.1);
        $mod_vat_mny = (int)$tax_mny - $mod_tax_mny;

        $c_PayPlus->mf_set_modx_data( "tax_flag"     , "TG03"				 );  // 복합과세 구분
        $c_PayPlus->mf_set_modx_data( "mod_tax_mny"  , strval($mod_tax_mny)  );	 // 공급가 부분 취소 요청 금액
        $c_PayPlus->mf_set_modx_data( "mod_vat_mny"  , strval($mod_vat_mny)	 );  // 부과세 부분 취소 요청 금액
        $c_PayPlus->mf_set_modx_data( "mod_free_mny" , strval($mod_free_mny) );  // 비관세 부분 취소 요청 금액
    }
}

if( $tran_cd != "" )
{
    $c_PayPlus->mf_do_tx( "",                $g_conf_home_dir, $g_conf_site_cd,
                          $g_conf_site_key,  $tran_cd,         "",
                          $g_conf_gw_url,    $g_conf_gw_port,  "payplus_cli_slib",
                          $ordr_idxx,        $cust_ip,         $g_conf_log_level,
                          "",                0,                $g_conf_key_dir,
                          $g_conf_log_dir );

    $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
    $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
    /* $res_en_msg = $c_PayPlus->mf_get_res_data( "res_en_msg" );  // 결과 영문 메세지 */
}
else
{
    $c_PayPlus->m_res_cd  = "9562";
    $c_PayPlus->m_res_msg = "연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.";
}

if($res_cd != '0000')
{
    $res_msg = iconv("euc-kr", "utf-8", $res_msg);

    alert("$res_cd : $res_msg");
}

/* ============================================================================== */
/* =       취소 결과 처리                                                       = */
/* = -------------------------------------------------------------------------- = */
if( $req_tx == "mod" )
{
    if( $res_cd == "0000" )
    {
        $tno = $c_PayPlus->mf_get_res_data( "tno" );  // KCP 거래 고유 번호
        $amount  = $c_PayPlus->mf_get_res_data( "amount"       ); // 원 거래금액
        $mod_mny = $c_PayPlus->mf_get_res_data( "panc_mod_mny" ); // 취소요청된 금액
        $rem_mny = $c_PayPlus->mf_get_res_data( "panc_rem_mny" ); // 취소요청후 잔액

        // 환불금액기록
		$sql = " update shop_order
					set refund_price = '$mod_mny'
				  where od_id = '{$od['od_id']}'
					and od_no = '{$od['od_no']}'
					and od_tno = '$tno' ";
		sql_query($sql);

		$sql = " update shop_order
					set shop_memo = concat(shop_memo, \"$mod_memo\")
				  where od_id = '{$od['od_id']}'
					and od_tno = '$tno' ";
		sql_query($sql);
    } // End of [res_cd = "0000"]

/* = -------------------------------------------------------------------------- = */
/* =       취소 실패 결과 처리                                                  = */
/* = -------------------------------------------------------------------------- = */
    else
    {
    }
}

// locale 설정 초기화
setlocale(LC_CTYPE, '');
?>