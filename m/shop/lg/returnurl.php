<?php
include_once('./_common.php');

/*
xpay_approval.php 에서 세션에 저장했던 파라미터 값이 유효한지 체크
세션 유지 시간(로그인 유지시간)을 적당히 유지 하거나 세션을 사용하지 않는 경우 DB처리 하시기 바랍니다.
*/

if(!isset($_SESSION['PAYREQ_MAP'])){
    alert('세션이 만료 되었거나 유효하지 않은 요청 입니다.', BV_MURL);
}

$payReqMap = $_SESSION['PAYREQ_MAP']; //결제 요청시, Session에 저장했던 파라미터 MAP

$tb['title'] = 'LG 유플러스 eCredit서비스 결제';
$tb['body_script'] = ' onload="setLGDResult();"';
include_once(BV_MPATH.'/head.sub.php');

$LGD_RESPCODE = $_REQUEST['LGD_RESPCODE'];
$LGD_RESPMSG  = $_REQUEST['LGD_RESPMSG'];
$LGD_PAYKEY   = '';

$LGD_OID = $payReqMap['LGD_OID'];

$sql = " select * from shop_order_data where od_id = '$LGD_OID' ";
$row = sql_fetch($sql);

$data = unserialize(base64_decode($row['dt_data']));

$order_action_url = BV_HTTPS_MSHOP_URL.'/orderformresult.php';
$page_return_url  = BV_MSHOP_URL.'/orderlg.php?od_id='.$LGD_OID;

if($LGD_RESPCODE == '0000') {
    $LGD_PAYKEY                = $_REQUEST['LGD_PAYKEY'];
    $payReqMap['LGD_RESPCODE'] = $LGD_RESPCODE;
    $payReqMap['LGD_RESPMSG']  = $LGD_RESPMSG;
    $payReqMap['LGD_PAYKEY']   = $LGD_PAYKEY;
} else {
	// 인증 실패에 대한 처리 로직 추가
    alert('LGD_RESPCODE:' . $LGD_RESPCODE . ' ,LGD_RESPMSG:' . $LGD_RESPMSG, $page_return_url);
}
?>

<?php
$exclude = array('res_cd', 'LGD_PAYKEY');

echo '<form name="forderform" method="post" action="'.$order_action_url.'" autocomplete="off">'.PHP_EOL;

echo make_order_field($data, $exclude);

echo '<input type="hidden" name="res_cd" value="'.$LGD_RESPCODE.'">'.PHP_EOL;
echo '<input type="hidden" name="LGD_PAYKEY" value="'.$LGD_PAYKEY.'">'.PHP_EOL;

echo '</form>'.PHP_EOL;
?>

<div>
    <div id="show_progress">
        <span style="display:block;text-align:center;margin-top:120px"><img src="<?php echo BV_MSHOP_URL; ?>/img/loading.gif" alt=""></span>
        <span style="display:block;text-align:center;margin-top:10px;font-size:14px">주문완료 중입니다. 잠시만 기다려 주십시오.</span>
    </div>
</div>

<script type="text/javascript">
function setLGDResult() {
    setTimeout( function() {
        document.forderform.submit();
    }, 300);
}
</script>

<?php
include_once(BV_MPATH.'/tail.sub.php');
?>