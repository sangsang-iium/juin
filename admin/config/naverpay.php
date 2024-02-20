<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fregform" method="post" action="./config/naverpay_update.php">
<input type="hidden" name="token" value="">

<h2>네이버페이 서비스</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w190">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">네이버페이 테스트결제</th>
		<td>                
			<input type="radio" name="de_naverpay_test" value="0" id="de_naverpay_test_no" 
			<?php echo get_checked($default['de_naverpay_test'], "0"); ?>>
			<label for="de_naverpay_test_no">실결제</label>
			<input type="radio" name="de_naverpay_test" value="1" id="de_naverpay_test_yes" 
			<?php echo get_checked($default['de_naverpay_test'], "1"); ?>>
			<label for="de_naverpay_test_yes">테스트결제</label>
			<?php echo help("네이버페이 검수 과정 중에는 <strong>테스트결제</strong>로 설정해야 하며 최종 승인 후 <strong>실결제</strong>로 설정합니다."); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="de_naverpay_mid">네이버페이 가맹점 아이디</label></th>
		<td>   
			<input type="text" name="de_naverpay_mid" value="<?php echo $default['de_naverpay_mid']; ?>" id="de_naverpay_mid" class="frm_input" size="20" maxlength="50">
			<a href="https://admin.pay.naver.com/" target="_blank" class="btn_small grey">네이버페이 서비스신청하기</a>
			<?php echo help('네이버페이 가맹점 아이디를 입력합니다.<br><em class="fc_red">네이버페이는 결제대행사(PG) 심사가 끝난 후에 신청할 수 있습니다.</em>'); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="de_naverpay_cert_key">네이버페이 가맹점 인증키</label></th>
		<td>
			<input type="text" name="de_naverpay_cert_key" value="<?php echo $default['de_naverpay_cert_key']; ?>" id="de_naverpay_cert_key" class="frm_input" size="50" maxlength="100">
			<?php echo help("네이버페이 가맹점 인증키를 입력합니다."); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="de_naverpay_button_key">네이버페이 버튼 인증키</label></th>
		<td>                
			<input type="text" name="de_naverpay_button_key" value="<?php echo $default['de_naverpay_button_key']; ?>" id="de_naverpay_button_key" class="frm_input" size="50" maxlength="100">
			<?php echo help("네이버페이 버튼 인증키를 입력합니다."); ?>
		</td>
	</tr>		
	<tr>
		<th scope="row"><label for="de_naverpay_mb_id">네이버페이 결제테스트 아이디</label></th>
		<td>                
			<input type="text" name="de_naverpay_mb_id" value="<?php echo $default['de_naverpay_mb_id']; ?>" id="de_naverpay_mb_id" class="frm_input" size="20" maxlength="20">
			<?php echo help("네이버페이 결제테스트를 위한 테스트 회원 아이디를 입력합니다. 네이버페이 검수 과정에서 필요합니다."); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">네이버페이 상품정보 XML URL</th>
		<td>                
			<?php echo BV_SHOP_URL; ?>/naverpay/naverpay_item.php
			<?php echo help("네이버페이에 상품정보를 XML 데이터로 제공하는 페이지입니다. 검수과정에서 아래의 URL 정보를 제공해야 합니다."); ?>
		 </td>
	</tr>
	<tr>
		<th scope="row"><label for="de_naverpay_sendcost">네이버페이 추가배송비 안내</label></th>
		<td>                
			<input type="text" name="de_naverpay_sendcost" value="<?php echo $default['de_naverpay_sendcost']; ?>" id="de_naverpay_sendcost" class="frm_input" size="60">
			<?php echo help("네이버페이를 통한 결제 때 구매자에게 보여질 추가배송비 내용을 입력합니다.<br>예) 제주도 3,000원 추가, 제주도 외 도서·산간 지역 5,000원 추가"); ?>
		 </td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="hd">ㆍ네이버페이 서비스란?</div>
		<div class="desc01">
			<p>ㆍ네이버페이는 네이버 ID로 다양한 가맹점에서 회원가입 없이 편리하게 쇼핑, 결제, 배송관리를 할 수 있는 결제 서비스입니다.</p>
			<p>ㆍ네이버페이 비밀번호로 안전하게 결제할 수 있으며 결제할 때마다 적립되는 네이버페이 포인트를 다양한 가맹점에서 현금과 동일하게 사용할 수 있습니다.</p>
		</div>
		<div class="hd">ㆍ네이버페이 가입신청 전 체크</div>
		<div class="desc01">
			<p>ㆍNHN KCP, LG U+, KG이니시스에 가입되어있다면, 네이버페이 가입은 O.K</p>
			<p class="fc_red">ㆍ해당 PG사를 통해 정상 결제가 진행되어야 하기 때문에 카드심사 완료 후에 신청합니다.</p>
			<p>ㆍ현행 법령상 매매가 금지된 상품이나 네이버페이에서 취급을 제한하는 상품이 없어야 합니다.</p>
			<p>ㆍ현금결제(실시간계좌이체, 가상계좌)을 사용하는 경우, 반드시 PG사에서 제공하는 에스크로가 적용되어 있어야 합니다.</p>
			<p>ㆍ비회원 구매가 가능해야 합니다.</p>
		</div>
		<div class="hd">ㆍ네이버페이 가입절차</div>
		<div class="desc01">
			<p>ㆍ입점신청 &gt; 상담/입점심사 &gt; 상품/결제시스템연동 &gt; 결제시스템 검수 &gt; 최종승인</p>
			<p>ㆍ<a href="https://admin.pay.naver.com/about" target="_blank"><em>더 자세한 내용 보러가기</em></a></p>
		</div>
	 </div>
</div>
