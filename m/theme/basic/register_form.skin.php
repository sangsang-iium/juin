<?php
if(!defined('_BLUEVATION_')) exit;

  // 사업자 번호 하이픈(-)추가 _20240604_SY
  function formatBno($no) {
    $no = preg_replace('/[^0-9]/', '', $no);
    if (strlen($no) !== 10) {
        return '';
    }
    return substr($no, 0, 3) . '-' . substr($no, 3, 2) . '-' . substr($no, 5, 5);
  }

  // 매장 주소 _20240604_SY
  $position = strpos($_POST['DORO_ADDRESS'], '(');
  if($position != false) {
    $parts = explode('(', $_POST['DORO_ADDRESS']);
    $doro1 = $parts[0];
    $doro2 = "(".$parts[1];
  } else {
    $doro1 = $_POST['DORO_ADDRESS'];
    $doro2 = "";
  }

  // 업종 SELECT _20240604_SY
  $ju_sectors = explode('|', $config['cf_food']);

  if($w=='u') {
    $mng_sel_sql = " SELECT * FROM shop_manager WHERE index_no = '{$member['ju_manager']}' ";
    $mng_sel_row = sql_fetch($mng_sel_sql);

    // 지회/지부 SELECT 추가 _20240608__SY
    if(empty($member['ju_region3'])) {
      $jibu_row = getRegionFunc("branch", " WHERE b.branch_code = '{$member['ju_region2']}'");
      $jibu_name = $jibu_row[0]['branch_name'];
    } else {
      $jibu_row = getRegionFunc("office", " WHERE b.branch_code = '{$member['ju_region2']}' AND a.office_code = '{$member['ju_region3']}'");
      $jibu_name = $jibu_row[0]['office_name'];
    }
  }

?>

<!-- 회원정보 입력/수정 시작 { -->
<script src="<?php echo BV_JS_URL; ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo BV_JS_URL; ?>/certify.js?v=<?php echo BV_JS_VER; ?>"></script>
<?php } ?>

<link rel="stylesheet" href="/src/plugin/timepicker/jquery.timepicker.min.css">
<script src="/src/plugin/timepicker/jquery.timepicker.min.js"></script>

<form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="agree" value="<?php echo $agree; ?>">
<input type="hidden" name="agree2" value="<?php echo $agree2; ?>">
<input type="hidden" name="mb_recommend" id="reg_mb_recommend" value="<?php echo $member['pt_id']; ?>">
<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
<input type="hidden" name="cert_no" value="">

<input type="hidden" name="reg_type" value="1">
<input type="hidden" name="chk_cb_res" value="<?php echo ($w=='') ? $_POST['chk_cb_res'] : 0?>" id="chk_cb_res">
<input type="hidden" name="chk_bn_res" value="<?php echo ($w=='') ? $_POST['chk_bn_res'] : 0?>" id="chk_bn_res">
<input type="hidden" name="OFFICE_NAME" value="<?php echo ($w=='') ?$_POST['OFFICE_NAME'] : "" ?>">

<div id="contents" class="sub-contents joinDetail">
	<div class="joinDetail-wrap">
		<div class="container">

			<!-- 기본정보 { -->
			<div class="joinDetail-box">
				<div class="joinDetail-head">
					<p class="joinDetail-title">기본정보</p>
				</div>
				<div class="joinDetail-body">
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_id">아이디</label><b>*</b></p>
						</div>
						<div class="form-body input-button id-confirm">
							<input type="text" name="mb_id" value="<?php echo $member['id'] ?>" id="reg_mb_id"<?php echo $required; ?><?php echo $readonly; ?> class="<?php echo $required; ?> frm-input" size="20" maxlength="20" placeholder="아이디를 입력해주세요." autocapitalize="off">
							<span id="msg_mb_id"></span>
							<button type="button" class="ui-btn st3" onclick="chk_id()">중복확인</button>
						</div>
					</div>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_password">비밀번호</label><b>*</b></p>
						</div>
						<div class="form-body">
							<input type="password" name="mb_password" id="reg_mb_password"<?php echo $required; ?> class="<?php echo $required; ?> frm-input w-per100" size="20" maxlength="20" placeholder="비밀번호를 입력해주세요.">
						</div>
					</div>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_password_re">비밀번호 확인</label><b>*</b></p>
						</div>
						<div class="form-body">
							<input type="password" name="mb_password_re" id="reg_mb_password_re"<?php echo $required; ?> class="<?php echo $required; ?> frm-input w-per100" size="20" maxlength="20" placeholder="비밀번호를 한번 더 입력해주세요.">
              <p id="password-message" class="reg-message"></p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_name">이름</label><b>*</b></p>
						</div>
						<div class="form-body">
							<input type="text" name="mb_name" value="<?php echo get_text($member['name']); ?>" id="reg_mb_name"<?php echo $required; ?><?php echo $readonly; ?> class="<?php echo $required; ?> frm-input w-per100" size="20" placeholder="이름을 입력해주세요." autocapitalize="off">
							<?php
							$cert_str = '';
							if($config['cf_cert_use']) {
								if($config['cf_cert_ipin'])
									$cert_str .= '<button type="button" id="win_ipin_cert" class="btn_small">아이핀 본인인증</button>'.PHP_EOL;
								if($config['cf_cert_hp'])
									$cert_str .= '<button type="button" id="win_hp_cert" class="btn_small">휴대폰 본인인증</button>'.PHP_EOL;

								$cert_str .= '<noscript>본인인증을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
							}
							if($cert_str) echo '<div class="mart5">'.$cert_str.'</div>';
							if($config['cf_cert_use'] && $member['mb_certify']) {
								if($member['mb_certify'] == 'ipin')
									$mb_cert = '아이핀';
								else
									$mb_cert = '휴대폰';
							?>
							<div id="msg_certify">
								<strong><?php echo $mb_cert; ?> 본인인증</strong><?php if($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
							</div>
							<?php } ?>
							<?php if($config['cf_cert_use']) { ?>
							<span class="frm_info">아이핀 본인인증 후에는 이름이 자동 입력되고 휴대폰 본인인증 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
							<?php } ?>
						</div>
					</div>
					<?php if($config['register_use_tel']) {
            // 전화번호 분리 _20240312_SY
            $tel_phone = explode("-", $member['telephone']);
          ?>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_tel">전화번호</label><?php echo $config['register_req_tel']?'<b>*</b>':''; ?></p>
						</div>
						<div class="form-body phone">
							<!-- <input type="tel" name="mb_tel" value="<?php echo get_text($member['telephone']); ?>" id="reg_mb_tel"<?php echo $config['register_req_tel']?' required':''; ?> class="frm-input w-per100 <?php echo $config['register_req_tel']?' required':''; ?>" size="20" maxlength="13" placeholder="전화번호를 입력해주세요." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'); autoHyphen2(this)"> -->
              <input type="tel" name="mb_tel[]" value="<?php echo get_text($tel_phone[0]); ?>" id="reg_reg_mb_tel"<?php echo $config['register_req_tel']?' required':''; ?> class="frm-input <?php echo $config['register_req_tel']?' required':''; ?>" size="20" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							  <span class="hyphen">-</span>
							<input type="tel" name="mb_tel[]" value="<?php echo get_text($tel_phone[1]); ?>" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							  <span class="hyphen">-</span>
							<input type="tel" name="mb_tel[]" value="<?php echo get_text($tel_phone[2]); ?>" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
						</div>
					</div>
					<?php } ?>
					<?php if($config['register_use_hp'] || $config['cf_cert_hp']) { 
            // 휴대폰 번호 분리 _20240312_SY
            $cell_phone = explode("-", $member['cellphone']);
          ?>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_hp">핸드폰번호</label><b>*</b></p>
						</div>
						<div class="form-body phone">
							<input type="tel" name="mb_hp[]" value="<?php echo get_text($cell_phone[0]); ?>" id="reg_mb_hp"<?php echo $config['register_req_hp']?' required':''; ?> class="frm-input <?php echo $config['register_req_hp']?' required':''; ?>" size="20" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<span class="hyphen">-</span>
							<input type="tel" name="mb_hp[]" value="<?php echo get_text($cell_phone[1]); ?>" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<span class="hyphen">-</span>
							<input type="tel" name="mb_hp[]" value="<?php echo get_text($cell_phone[2]); ?>" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<div class="frm-choice">
								<input type="checkbox" name="mb_sms" id="chk-sms" value="Y"<?php echo ($w=='' || $member['smsser'] == 'Y')?' checked':''; ?>>
								<label for="chk-sms">핸드폰 문자메세지를 받겠습니다.</label>
							</div>
							<?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
							<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['cellphone']); ?>">
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					<div class="form-row">
						<div class="form-head">
							<p class="title"><label for="reg_mb_email">이메일</label><b>*</b></p>
						</div>
						<div class="form-body">
              <div class="input-button id-confirm">
                <input type="hidden" name="old_email" value="<?php echo $member['email']; ?>">
                <input type="email" name="mb_email" value="<?php echo isset($member['email'])?$member['email']:''; ?>" id="reg_mb_email" required class="frm-input w-per100" size="40" maxlength="100" placeholder="이메일을 입력해주세요." autocapitalize="off">
                <button type="button" class="ui-btn st3" onclick="chk_email()">중복확인</button>
              </div>
							<!-- <span class="at">@</span>
							<select name="" class="frm-select">
								<option value="">선택하세요.</option>
								<option value="">gmail.com</option>
								<option value="">naver.com</option>
								<option value="">hanmail.net</option>
								<option value="">직접입력</option>
							</select> -->
							<div class="frm-choice">
								<input type="checkbox" name="mb_mailling" value="Y" id="reg_mb_mailling"<?php echo ($w=='' || $member['mailser'] == 'Y')?' checked':''; ?>>
								<label for="reg_mb_mailling">정보 메일을 받겠습니다.</label>
							</div>
						</div>
					</div>
					<?php if($config['register_use_addr']) { ?>
					<div class="form-row">
						<div class="form-head">
							<p class="title">주소<b>*</b></p>
						</div>
						<div class="form-body address">
              <label for="reg_mb_zip" class="sound_only">우편번호</label>
							<input type="tel" name="mb_zip" value="<?php echo ($w == '') ? $_POST['ZIP_CODE'] : $member['zip']; ?>" id="reg_mb_zip"<?php echo $config['register_req_addr']?' required':''; ?> class="frm-input address-input_1 <?php echo $config['register_req_addr']?' required':''; ?>" size="8" maxlength="5" placeholder="우편번호" >
							<button type="button" class="ui-btn st3" onclick="execDaumPostcode()">주소검색</button>
							
							<input type="text" name="mb_addr1" value="<?php echo ($w == '') ? get_text($doro1) : get_text($member['addr1']); ?>" id="reg_mb_addr1"<?php echo $config['register_req_addr']?' required':''; ?> class="frm-input address-input_2 <?php echo $config['register_req_addr']?' required':''; ?> frm_address" size="60" placeholder="기본주소" autocapitalize="off">
							<label for="reg_mb_addr1" class="sound_only">기본주소</label>
							<input type="text" name="mb_addr2" value="<?php echo get_text($member['addr2']); ?>" id="reg_mb_addr2" class="frm-input address-input_3 frm_address" size="60" placeholder="상세주소" autocapitalize="off">
							<label for="reg_mb_addr2" class="sound_only">상세주소</label>
							<input type="text" name="mb_addr3" value="<?php echo ($w == '') ? get_text($doro2) : get_text($member['addr3']); ?>" id="reg_mb_addr3" class="frm-input address-input_4 frm_address" size="60" placeholder="참고항목" readonly="readonly" autocapitalize="off">
							<label for="reg_mb_addr3" class="sound_only">참고항목</label>

							<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['addr_jibeon']); ?>">
						</div>
					</div>
					<?php } ?>

					<div class="form-row">
						<div class="form-head">
							<p class="title">환불계좌등록<b>*</b></p>
						</div>
						<div class="form-body phone">	  
							<label for="reg_mb_addr2" class="sound_only">은행</label> 
							<?php 
								
							?>
							<select name="refund_bank" class="frm-input">
									<option>은행을선택하세요</option>
									<?php 
									sort($BANKS, SORT_NATURAL | SORT_FLAG_CASE); 
									//sort($BANKS);
										for($a=0;$a<count($BANKS);$a++){   
											?>
											<option value='<? echo $BANKS[$a]['code']; ?>' <?php  if(get_text($member['refund_bank'])==$BANKS[$a]['code']) echo "selected"; ?>><?php echo $BANKS[$a]['bank'];?></option>
											<?php
										}
									?>
							</select>
							<input type="text" name="refund_num" value="<?php echo get_text($member['refund_num']); ?>" id="refund_num" class="frm-input" size="20" placeholder="계좌번호" autocapitalize="off">
							<input type="text" name="refund_name" value="<?php echo get_text($member['refund_name']); ?>" id="refund_name" class="frm-input" size="10" placeholder="예금주" autocapitalize="off">
						</div>
					</div>

				</div>
			</div>
			<!-- } 기본정보 -->

			<!-- 담당자정보 _20240603 / 개인 회원가입일 경우 노출 { -->
			<div class="joinDetail-box">
				<div class="joinDetail-head">
					<p class="joinDetail-title">담당자 등록</p>
					<button type="button" class="ui-btn st3 w-per100 popup-open" data-popupId="popMemberSch">담당자 조회하기</button>
					<!-- 담당자 조회하기 팝업 { -->
          <div class="popup type01" id="popMemberSch">
            <div class="pop-inner">
              <div class="pop-top">
                <p class="tit">담당자 조회하기</p>
              </div>
							<div class="pop-search input-button">
								<input type="" name="KFIA_search" id="KFIA_search" value="" class="frm-input" size="20" maxlength="20" placeholder="담당자 코드를 입력해주세요.">
								<button type="button" class="ui-btn st3" onclick="getManager()">조회</button>
							</div>
              <div class="pop-content line">
                <div class="pop-content-in" style="height: 500px;">
                  <div class="pop-result">
                    <!-- 검색 결과 나올 곳 _20240603_SY -->
                  </div>
                </div>
              </div>
              <div class="pop-btm">
                <button type="button" class="ui-btn round stBlack" id="info_ok">확인</button>
                <button type="button" class="ui-btn round stWhite close">취소</button>
              </div>
            </div>
          </div>
					<!-- } 담당자 조회하기 팝업 -->
				</div>
				<div class="joinDetail-body">
					<div class="form-row">
						<div class="form-head">
							<p class="title">담당자<b>*</b></p>
						</div>
						<div class="form-body">
							<input type="text" name="pop_nm" id="pop_nm" class="frm-input w-per100" value="<?php echo $mng_sel_row['name']; ?>" placeholder="홍길동" readonly>
              <input type="hidden" name="mn_idx" id="mn_idx" value="<?php echo $mng_sel_row['index_no']; ?>">
						</div>
					</div>
					<!-- <div class="form-row">
						<div class="form-head">
							<p class="title">고유번호<b>*</b></p>
						</div>
						<div class="form-body">
							<input type="text" name="pop_u_no" id="pop_u_no" class="frm-input w-per100" readonly value="123456789">
						</div>
					</div> -->
					<!-- <div class="form-row">
						<div class="form-head">
							<p class="title">사업자등록번호<b>*</b></p>
						</div>
						<div class="form-body">
							<input type="text" name="pop_b_no" id="pop_b_no" class="frm-input w-per100" readonly value="123-45-67890">
						</div>
					</div> -->
				</div>
			</div>
			<!-- } 중앙회원정보 / 개인 회원가입일 경우 노출 -->

			<!-- 사업자정보 { -->
      
			<div class="joinDetail-box" id="b_area">
				<div class="joinDetail-head">
					<p class="joinDetail-title">사업자정보</p>
					<!-- 개인 회원가입일 경우 노출 { -->
					<!-- <button type="button" class="ui-btn st3 w-per100">사업자 정보 불러오기</button> -->
					<!-- } 개인 회원가입일 경우 노출 -->
				</div>
				<div class="joinDetail-body">
					<!-- 사업자 회원가입일 경우 노출 { -->
					<div class="form-row">
						<div class="form-head">
							<p class="title">사업자등록번호<b>*</b></p>
						</div>
						<div class="form-body">
							<input type="tel" name="b_no" id="b_no" class="frm-input w-per100" value="<?php echo ($w == '') ? formatBno($_POST['IRS_NO']) : $member['ju_b_num'] ?>" placeholder="***-**-*****" maxlength="12" readonly >              
							<!-- <div class="joinDetail-btn-box joinDetail-btn-box3">
								<button type="button" class="ui-btn st3" onclick="getKFIAMember()">중앙회원조회</button>
								<button type="button" class="ui-btn st3" onclick="chkDuBnum()">중복확인</button>
								<button type="button" class="ui-btn st3" onclick="chkClosed()">휴/폐업조회</button>
							</div> -->
						</div>
					</div>

					<!-- } 사업자 회원가입일 경우 노출 -->
				</div>
			</div>
			<!-- } 사업자정보 -->
			<!-- 매장정보 { -->
      <?php //if($w == 'u') { ?>
      <div class="joinDetail-box">
				<div class="joinDetail-head">
					<p class="joinDetail-title">매장정보</p>
				</div>
				<div class="joinDetail-body">
					<div class="form-row store_info">
						<div class="form-head">
							<p class="title">매장 노출 여부<b>*</b></p>
						</div>
						<div class="form-body">
              <ul class="form-inline">
                <li>
                  <div class="frm-choice">
                    <input type="radio" name="store_display" id="store_display-y" value="1" <?php echo get_checked($member['ju_mem'], '1'); ?> >
                    <label for="store_display-y">예</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="radio" name="store_display" id="store_display-n" value="2" <?php echo get_checked($member['ju_mem'], '2'); ?> >
                    <label for="store_display-n">아니오</label>
                  </div>
                </li>
              </ul>
						</div>
					</div>
          <div class="form-row">
						<div class="form-head">
							<p class="title">업종</p>
						</div>
						<div class="form-body">
							<select name="ju_sectors" id="ju_sectors" class="frm-select w-per100">
                <option value="">선택</option>
                <?php foreach($ju_sectors as $key => $val) { ?> 
                  <option value="<?php echo $val ?>" <?php echo (($w=='u') && $val == $member['ju_sectors']) ? "selected" : "" ?> ><?php echo $val ?></option>
                <?php } ?>
              </select>
						</div>
					</div>
          <!-- 지회/지부 정보 _20240608_SY -->
          <div class="joinDetail-body">
            <div class="form-row">
              <div class="form-head">
                <p class="title">지회/지부</p>
              </div>
              <div class="form-body">
                <input type="hidden" name="ju_region2" value="<?php echo ($w=='') ? (int)$_POST['BRANCH_CODE'] : $member['ju_region2'] ?>" class="frm-input w-per100" >
                <input type="hidden" name="ju_region3" value="<?php echo ($w=='') ? (int)$_POST['OFFICE_CODE'] : $member['ju_region3'] ?>" class="frm-input w-per100" >
                <input type="text" name="ju_region_code" value="<?php echo ($w=='') ? $_POST['OFFICE_NAME'] : $jibu_name ?>" class="frm-input w-per100" readonly>
              </div>
            </div>
            <!-- <div class="form-row">
              <div class="form-head">
                <p class="title">업태</p>
              </div>
              <div class="form-body">
                <input type="text" name="ju_business_type" class="frm-input w-per100" value="<?php echo ($w != '') ? $member['ju_business_type'] : ""?>" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-head">
                <p class="title">업종</p>
              </div>
              <div class="form-body">
                <input type="text" name="ju_sectors" class="frm-input w-per100" value="<?php echo ($w != '') ? $member['ju_sectors'] : "" ?>" >
              </div>
            </div> -->
          </div>
          <!-- 매장명 추가 _20240604_SY -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">매장명</p>
            </div>
            <div class="form-body">
              <input type="text" name="ju_restaurant" class="frm-input w-per100" value="<?php echo ($w == '') ? $_POST['MEMBER_NAME'] : $member['ju_restaurant'] ?>" readonly >
            </div>
          </div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">매장 썸네일 사진</p>
						</div>
						<div class="form-body">
							<input type="file" name="" id="" class="frm-file w-per100">
						</div>
					</div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">매장 상세 사진</p>
						</div>
						<div class="form-body">
              <ul class="form-file_box">
                <li class="view">
                  <input type="file" name="" id="" class="frm-file w-per100">
                </li>
                <li>
                  <input type="file" name="" id="" class="frm-file w-per100">
                </li>
                <li>
                  <input type="file" name="" id="" class="frm-file w-per100">
                </li>
                <li>
                  <input type="file" name="" id="" class="frm-file w-per100">
                </li>
                <li>
                  <input type="file" name="" id="" class="frm-file w-per100">
                </li>
              </ul>
              <button type="button" class="ui-btn st2 w-per100 frm-file-add_btn" data="stIconRight">
                <span class="txt">상세 사진 추가</span>
                <i data-feather="plus" class="icn"></i>
              </button>
						</div>
					</div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">운영시간</p>
						</div>
						<div class="form-body">
							<ul class="form-inline time">
                <li>
                  <input type="text" name="" id="" class="timepicker frm-input w-per100" readonly>
                </li>
                <li class="time_mid_txt">~</li>
                <li>
                  <input type="text" name="" id="" class="timepicker frm-input w-per100" readonly>
                </li>
              </ul>
						</div>
					</div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">휴무일</p>
						</div>
						<div class="form-body">
              <ul class="form-inline yoil">
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">월요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">화요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">수요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">목요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">금요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">토요일</label>
                  </div>
                </li>
                <li>
                  <div class="frm-choice">
                    <input type="checkbox" name="" id="">
                    <label for="">일요일</label>
                  </div>
                </li>
              </ul>
						</div>
					</div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">브레이크 타임</p>
						</div>
						<div class="form-body">
              <ul class="form-inline time">
                <li>
                  <input type="text" name="" id="" class="timepicker frm-input w-per100" readonly>
                </li>
                <li class="time_mid_txt">~</li>
                <li>
                  <input type="text" name="" id="" class="timepicker frm-input w-per100" readonly>
                </li>
              </ul>
						</div>
					</div>
          <div class="form-row">
						<div class="form-head">
							<p class="title">매장주소</p>
						</div>
						<div class="form-body address">
              <label for="store_zip" class="sound_only">우편번호</label>
							<input type="tel" name="store_zip" value="<?php echo ($w == '') ? $_POST['ZIP_CODE'] : $member['zip']; ?>" id="store_zip" class="frm-input address-input_1" size="8" maxlength="5" placeholder="우편번호" >
							<button type="button" class="ui-btn st3" onclick="execDaumPostcode2()">주소검색</button>
							
							<input type="text" name="store_addr1" value="<?php echo ($w == '') ? get_text($doro1) : $member['ju_addr_full'] ?>" id="store_addr1" class="frm-input address-input_2 frm_address" size="60" placeholder="기본주소" autocapitalize="off">
							<label for="store_addr1" class="sound_only">기본주소</label>
							<input type="text" name="store_addr2" value="<?php echo ($w == '') ? get_text($doro2) : "" ?>" id="store_addr2" class="frm-input address-input_3 frm_address" size="60" placeholder="상세주소" autocapitalize="off">
							<label for="store_addr2" class="sound_only">상세주소</label>
							<input type="hidden" name="store_addr3" value="" id="store_addr3" class="frm-input address-input_4 frm_address" size="60" placeholder="참고항목" readonly="readonly" autocapitalize="off">
							<label for="store_addr3" class="sound_only">참고항목</label>

							<input type="hidden" name="store_addr_jibeon" value="">
						</div>
					</div>
          <div class="form-row store_info">
						<div class="form-head">
							<p class="title">매장설명</p>
						</div>
						<div class="form-body">
							<textarea name="" id="" class="frm-txtar w-per100 store-txtar"></textarea>
						</div>
					</div>
        </div>
      </div>
      <?php //} ?>
      <br>
      <br>
      <br>
      <br>
			<!-- } 매장정보 -->

		</div>
	</div>
	<div class="cp-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
				<input type="submit" value="<?php echo $w==''?'회원가입':'정보수정'; ?>" id="btn_submit" class="ui-btn round stBlack" accesskey="s">
			</div>
		</div>
	</div>

  
  <?php if($w != '') { ?>
    <div class="joinDetail-box">
        <div class="joinDetail-body">
          <button type="button" class="ui-btn mb-leave_btn" onclick="member_leave()">회원탈퇴하기<img src="/src/img/arrow-right2.svg" alt=""></button>
        </div>
    </div>
  <?php } ?>

  <div id="post_wrap" >
    <img src="/src/img/post_close.png" id="btnFoldWrap"
      style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()"
      alt="접기 버튼">
  </div>
</form>

<script src="/js/postcode.v2.js"></script>

<script>
let w = $('input[name=w]').val();

$(document).ready(function(){
  // 매장정보 > 매장 상세사진 추가하기
  $(".frm-file-add_btn").on('click', function(){
    let fileList = $(this).siblings(".form-file_box");
    let curFileLeng = fileList.find(".view").length;

    if(curFileLeng < 5) {
      fileList.find("li").eq(curFileLeng).addClass('view');
    } else {
      alert('최대 5개까지 추가할 수 있습니다.');
      return false;
    }
  });

  // 시간선택
  $('.timepicker').timepicker({
    timeFormat: 'h:mm p',
    interval: 30,
    minTime: '0',
    maxTime: '11:59pm',
    defaultTime: '10',
    startTime: '1:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true,
  });

  // 비밀번호 확인 일치여부
  $('#reg_mb_password_re').on('input', function() {
    // 비밀번호와 비밀번호 확인 입력란의 값을 가져오기
    var password = $('#reg_mb_password').val();
    var confirmPassword = $('#reg_mb_password_re').val();

    // 메시지 표시 요소
    var messageElement = $('#password-message');

    // 비밀번호 입력란이 비어 있는지 확인
    if (!password) {
        messageElement.text('비밀번호를 입력하세요.');
    } 
    // 비밀번호와 비밀번호 확인 입력란의 값이 일치하는지 확인
    else if (password !== confirmPassword) { 
        messageElement.text('비밀번호가 일치하지 않습니다.');
    } 
    // 비밀번호가 일치하는 경우
    else {
        messageElement.text('');
    }
  });


  // 매장정보 hide() _20240604_SY
  if(w == '') {
    $('.store_info').hide(); // 각 요소를 숨깁니다.
  }
});

/** 우편번호 찾기 */
var element_wrap0 = document.getElementById('post_wrap');

function foldDaumPostcode() {
  // iframe을 넣은 element를 안보이게 한다.
  element_wrap0.style.display = 'none';
}

function execDaumPostcode() {
  var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
  new daum.Postcode({
    oncomplete: function (data) {
      // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

      // 각 주소의 노출 규칙에 따라 주소를 조합한다.
      // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
      var addr = ''; // 주소 변수
      var extraAddr = ''; // 참고항목 변수

      //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
      if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
        addr = data.roadAddress;
      } else { // 사용자가 지번 주소를 선택했을 경우(J)
        addr = data.jibunAddress;
      }

      // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
      if (data.userSelectedType === 'R') {
        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
          extraAddr += data.bname;
        }
        // 건물명이 있고, 공동주택일 경우 추가한다.
        if (data.buildingName !== '' && data.apartment === 'Y') {
          extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
        }
        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
        if (extraAddr !== '') {
          extraAddr = ' (' + extraAddr + ')';
        }
        // 조합된 참고항목을 해당 필드에 넣는다.
        //     document.getElementById("sample3_extraAddress").value = extraAddr;

        // } else {
        //     document.getElementById("sample3_extraAddress").value = '';
      }

      // 우편번호와 주소 정보를 해당 필드에 넣는다.
      document.getElementById('reg_mb_zip').value = data.zonecode;
      document.getElementById("reg_mb_addr1").value = addr;
      // 커서를 상세주소 필드로 이동한다.
      document.getElementById("reg_mb_addr2").focus();

      // iframe을 넣은 element를 안보이게 한다.
      // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
      element_wrap0.style.display = 'none';

      // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
      document.body.scrollTop = currentScroll;
    },
    // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
    onresize: function (size) {
      element_wrap0.style.height = size.height + 'px';
    },
    width: '100%',
    height: '100%'
  }).embed(element_wrap0);
  element_wrap0.style.display = 'block';
}

function execDaumPostcode2() {
  var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
  new daum.Postcode({
    oncomplete: function (data) {
      // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

      // 각 주소의 노출 규칙에 따라 주소를 조합한다.
      // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
      var addr = ''; // 주소 변수
      var extraAddr = ''; // 참고항목 변수

      //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
      if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
        addr = data.roadAddress;
      } else { // 사용자가 지번 주소를 선택했을 경우(J)
        addr = data.jibunAddress;
      }

      // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
      if (data.userSelectedType === 'R') {
        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
          extraAddr += data.bname;
        }
        // 건물명이 있고, 공동주택일 경우 추가한다.
        if (data.buildingName !== '' && data.apartment === 'Y') {
          extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
        }
        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
        if (extraAddr !== '') {
          extraAddr = ' (' + extraAddr + ')';
        }
        // 조합된 참고항목을 해당 필드에 넣는다.
        //     document.getElementById("sample3_extraAddress").value = extraAddr;

        // } else {
        //     document.getElementById("sample3_extraAddress").value = '';
      }

      // 우편번호와 주소 정보를 해당 필드에 넣는다.
      document.getElementById('store_zip').value = data.zonecode;
      document.getElementById("store_addr1").value = addr;
      // 커서를 상세주소 필드로 이동한다.
      document.getElementById("store_addr2").focus();

      // iframe을 넣은 element를 안보이게 한다.
      // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
      element_wrap0.style.display = 'none';

      // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
      document.body.scrollTop = currentScroll;
    },
    // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
    onresize: function (size) {
      element_wrap0.style.height = size.height + 'px';
    },
    width: '100%',
    height: '100%'
  }).embed(element_wrap0);
  element_wrap0.style.display = 'block';
}
</script>

<script>
// 아이디 중복검사 _20240223_SY
var chkId = false;
function chk_id() {
  let idFocus = document.querySelector('#reg_mb_id');
  let getId   = document.querySelector('#reg_mb_id').value;


    if(getId.length > 2) {
      $.ajax({
        url: bv_url+"/m/bbs/ajax.register_chkId.php",
        type: "POST",
        data: { "id" : getId },
        dataType: "JSON",
        success: function(data) {
          // 세션 추가 _20240228_SY
          sessionStorage.setItem("chkId", data.res );
          sessionStorage.setItem("ID", getId );
          
          if(data.res == 'pass') {
            alert('사용가능한 아이디 입니다.');
            chkId = true;
          } else if(data.res == "reject") {
            alert('사용할 수 없는 아이디입니다.');
            chkId = false;
            idFocus.focus();
            return false;
          }
        }
      });
    } else {
      alert('회원아이디는 최소 3글자 이상 입력하세요.')
      return false;
    }
}

// 이메일 중복체크 _20240319_SY
var chkEmRes = false;
function chk_email() {
  let emFocus  = document.querySelector('#reg_mb_email');
  let chkEm    = document.querySelector('#reg_mb_email').value;
  
  // 이메일 유효성 검사
  let re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

  if (re.test(String(chkEm).toLowerCase()) == true) {
    $.ajax({
      url: bv_url + "/m/bbs/ajax.register_chkEm.php",
      type: "POST",
      data: { "email": chkEm },
      dataType: "JSON",
      success: function(data) {
        sessionStorage.setItem("chkEm", data.res);
        sessionStorage.setItem("Email", chkEm);
        
        if (data.res === 'pass') {
          alert('사용가능한 이메일입니다.');
          chkEmRes = true;
        } else if (data.res === "reject") {
          alert('사용할 수 없는 이메일입니다.');
          chkEmRes = false;
          emFocus.focus();
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  } else {
    alert('옳바른 이메일을 입력하여 주십시오.');
    emFocus.focus();
  }
}

// 전화번호 하이픈(-) _20240226_SY
const autoHyphen2 = (target) => { 
  let phNum = phoneNumber(target.value);
  
  target.value = phNum
}

// 전화번호 정규식 _20240226_SY
function phoneNumber(value) {
  if (!value) {
    return "";
  }

  value = value.replace(/[^0-9]/g, "");

  let result = [];
  let restNumber = "";

  // 지역번호와 나머지 번호로 나누기
  if (value.startsWith("02")) {
    // 서울 02 지역번호
    result.push(value.substr(0, 2));
    restNumber = value.substring(2);
  } else if (value.startsWith("1")) {
    // 지역 번호가 없는 경우
    // 1xxx-yyyy
    restNumber = value;
  } else {
    // 나머지 3자리 지역번호
    // 0xx-yyyy-zzzz
    result.push(value.substr(0, 3));
    restNumber = value.substring(3);
  }

  if (restNumber.length === 7) {
    // 7자리만 남았을 때는 xxx-yyyy
    result.push(restNumber.substring(0, 3));
    result.push(restNumber.substring(3));
  } else {
    result.push(restNumber.substring(0, 4));
    result.push(restNumber.substring(4));
  }

  return result.filter((val) => val).join("-");
}

// 담당자 조회하기 _20240603_SY
function getManager() {
  let search_input = document.querySelector('#KFIA_search');
  let search_words = search_input.value;

  let search_resIn = document.querySelector('.pop-result');
  
  if(search_words.length > 0) {
    $.ajax({
      url: bv_url+"/m/bbs/ajax.getManager.php",
      type: "POST",
      data: { "mcode" : search_words },
      dataType: "JSON",
      success: function(data) {
        console.log(data)
        let html = '';

        for(let i=0; i<data.res.length; i++) {
          html += '<div class="pop-result-item">';
          html += '<p class="pop-result-title">' + data.res[i].name + '</p>';
          html += '<p class="pop-result-text">담당자코드 : ' + data.res[i].id + '</p>';
          html += '<p class="pop-result-text">지회/지부 : ' + data.res[i].ju_region2 +'/'+ data.res[i].ju_region3 + '</p>';
          html += '<input type="hidden" class="pop-result-text" value="'+ data.res[i].index_no +'">';
          html += '</div>';
        }
        search_resIn.innerHTML = html;
        
        $('.pop-result').on('click', '.pop-result-item', function() {  
          $('.pop-result-item').css("border", "");
          $(this).css("border", "solid");

          let nm     = $(this).find('.pop-result-title').text();
          let id     = $(this).find('.pop-result-text:eq(0)').text();
          let region = $(this).find('.pop-result-text:eq(1)').text().split(':')[1].trim();
          let idx    = $(this).find('.pop-result-text:eq(2)').val();
          
          
          // 팝업 닫기
          $('#info_ok').on('click', function() {
            $('#pop_nm').val(nm);
            $('#mn_idx').val(idx);

            $('#popMemberSch').hide();
            $('.popDim').hide();
            $('#pop_nm').focus();
          })
        });
      }
    });

  } else {
    return false;
  }
}



// 외식업중앙회원 조회하기 _20240328_SY
var chkKFIA = false;
function getKFIAMember() {
  let inputNum = document.querySelector('#b_no').value;

  if(inputNum.length > 0) {
    $.ajax({
      url: bv_url+"/m/bbs/ajax.KFIA_info.php",
      type: "POST",
      data: { "b_num" : inputNum },
      dataType: "JSON",
      success: function(res) {
        console.log(res.data)
        if(res.data == null) {
          alert('사업자 정보 조회 실패')
          chkKFIA = false;
          return false;
        } else {
          alert(`조회 성공 : ${res.data.MEMBER_NAME}`)
          chkKFIA = true;
        }
      }
    });
  } else {
    return false;
  }
  
}


// 사업자번호 중복체크 _20240227_SY
function chkDuBnum() {
  b_num = document.querySelector('#b_no').value;

  if(b_num.length > 0) {
    $.ajax({
        url: bv_url+"/m/bbs/ajax.duplication_check.php",
        type: "POST",
        data: { "b_num" : b_num },
        dataType: "JSON",
        success: function(data) {
          if(data.res > 0 ) {
            $('#chk_bn_res').val('0');
            alert("이미 등록된 사업자등록번호입니다");
            return false;
          } else {
            alert("가입 가능한 사업자등록번호입니다");
            $('#chk_bn_res').val('1');
          }
        }
    });
  } else {
    alert("사업자등록번호가 존재하지 않습니다.")
    return false;
  }
}


// 휴/폐업 조회 _20240227_SY
let b_num = '';
function chkClosed() {
  b_num = document.querySelector('#b_no').value;
  
  let b_stt_cd = "";
  let end_dt   = "";
  
  if(b_num.length > 0) {
    $.ajax({
        url: bv_url+"/m/bbs/ajax.closed_check.php",
        type: "POST",
        data: { "b_num" : b_num },
        dataType: "JSON",
        success: function(res) {
          // API 값 호출 _20240318_SY
          if (res.hasOwnProperty('match_cnt')) {
            $('#chk_cb_res').val(res.data[0].b_stt_cd);
            let msg = res.data[0].b_stt;
            alert(msg);
          } else {
            $('#chk_cb_res').val('0');
            let msg = res.data[0].tax_type;
            alert(msg);
          }
        }
    });
  } else {
    alert("사업자등록번호가 존재하지 않습니다.")
    return false;
  }
}


$(function() {
	<?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
	// 아이핀인증
	$("#win_ipin_cert").click(function() {
		if(!cert_confirm())
			return false;

		var url = "<?php echo BV_OKNAME_URL; ?>/ipin1.php";
		certify_win_open('kcb-ipin', url);
		return;
	});

	<?php } ?>
	<?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	// 휴대폰인증
	$("#win_hp_cert").click(function() {
		if(!cert_confirm())
			return false;

		<?php
		switch($config['cf_cert_hp']) {
			case 'kcb':
				$cert_url = BV_OKNAME_URL.'/hpcert1.php';
				$cert_type = 'kcb-hp';
				break;
			case 'kcp':
				$cert_url = BV_KCPCERT_URL.'/kcpcert_form.php';
				$cert_type = 'kcp-hp';
				break;
			case 'lg':
				$cert_url = BV_LGXPAY_URL.'/AuthOnlyReq.php';
				$cert_type = 'lg-hp';
				break;
			default:
				echo 'alert("기본환경설정에서 휴대폰 본인인증 설정을 해주십시오");';
				echo 'return false;';
				break;
		}
		?>

		certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
		return;
	});
	<?php } ?>
});

function fregisterform_submit(f)
{
	// 회원아이디 검사
	if(f.w.value == "") {
		var msg = reg_mb_id_check();
		if(msg) {
			alert(msg);
			f.mb_id.select();
			return false;
		}
	}

  // 회원아이디 중복확인 여부 _20240223_SY
  let ss_Id     = sessionStorage.getItem("ID");
  let ss_Id_chk = sessionStorage.getItem("chkId");
  
  if(f.w.value == "") {
    if(chkId == false) {
      alert("아이디 중복을 확인해 주십시오.");
			f.mb_id.focus();
			return false;
    }

    // 세션 추가 _20240228_SY
    if(chkId == true) {
      if(ss_Id != f.reg_mb_id.value) {
        alert("아이디 중복을 확인해 주십시오");
        f.mb_id.focus();
        return false;
      }
    }
  }

	if(f.w.value == "") {
		if(f.mb_password.value.length < 4) {
			alert("비밀번호를 4글자 이상 입력하십시오.");
			f.mb_password.focus();
			return false;
		}
	}

	if(f.mb_password.value != f.mb_password_re.value) {
		alert("비밀번호가 같지 않습니다.");
		f.mb_password_re.focus();
		return false;
	}

	if(f.mb_password.value.length > 0) {
		if(f.mb_password_re.value.length < 4) {
			alert("비밀번호를 4글자 이상 입력하십시오.");
			f.mb_password_re.focus();
			return false;
		}
	}

	// 이름 검사
	if(f.w.value=="") {
		if(f.mb_name.value.length < 1) {
			alert("이름을 입력하십시오.");
			f.mb_name.focus();
			return false;
		}

		/*
		var pattern = /([^가-힣\x20])/i;
		if(pattern.test(f.mb_name.value)) {
			alert("이름은 한글로 입력하십시오.");
			f.mb_name.select();
			return false;
		}
		*/
	}

	<?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
	// 본인인증 체크
	if(f.cert_no.value=="") {
		alert("회원가입을 위해서는 본인인증을 해주셔야 합니다.");
		return false;
	}
	<?php } ?>


  // 휴대폰 유효성 검사 수정 _20240226_SY
  let chkPhoneNum = [];
  <?php if(($config['register_use_hp'] || $config['cf_cert_hp']) && $config['register_req_hp']) { ?>
  
    let getPhone = document.querySelectorAll("input[name='mb_hp[]']");
    getPhone.forEach(function(key, index) {
      let phoneNumber = key.value;
      chkPhoneNum[index] = phoneNumber;
    });
    let strPhoneNum = chkPhoneNum.join('-');


    // 휴대폰번호 체크
    var msg = reg_mb_hp_check(strPhoneNum);
    if(msg) {
      alert(msg);
      f.reg_mb_hp.select();
      return false;
    }
	<?php } ?>


	// E-mail 검사
	if((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
		var msg = reg_mb_email_check();
		if(msg) {
			alert(msg);
			f.reg_mb_email.select();
			return false;
		}
	}

  // 이메일 중복확인 여부 _20240319_SY
  let ss_em     = sessionStorage.getItem("Email");
  let ss_em_chk = sessionStorage.getItem('chkEm');
  
  if(f.w.value == "") {
    if(chkEmRes == false) {
      alert('이메일 중복을 확인해 주십시오.');
      f.mb_email.focus();
      return false;
    }
  }

  if(chkEmRes == true) {
    if(ss_em != f.reg_mb_email.value) {
      alert("이메일 중복을 확인해 주십시오.")
      f.mb_email.focus();
      return false;
    }
  }

  // 중앙회원조회 _20240328_SY
  // if(f.w.value == "") {
  //   if(chkKFIA == false) {
  //     alert('중앙회원이 아닐 경우 사업자회원으로 가입하실 수 없습니다.')
  //     f.b_no.focus();
  //     return false;
  //   }
  // }
  
  // 사업자번호 중복체크 _20240318_SY
  // if((f.w.value == "") || (f.w.value == "u" && f.chk_bn_res.defaultValue != f.chk_bn_res.value)) {
  //   if(f.chk_bn_res.value == "0") {
  //     alert('사업자등록번호 중복 확인을 해 주십시오');
  //     f.b_no.select();
  //     return false;
  //   };
  // }


  // 휴/폐업 검사 _20240227_SY
  // if((f.w.value == "") || (f.w.value == "u" && f.chk_cb_res.defaultValue != f.chk_cb_res.value)) {
  //   if(f.chk_cb_res.value == '0') {
  //     // 휴/폐업일때 어떤 작업 필요한지 확인 필요
  //     alert('휴/폐업조회를 해 주십시오.');
  //     f.b_no.select();
  //     return false;
  //   };
  // }

  
	if(typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
		if(f.mb_id.value == f.mb_recommend.value) {
			alert("본인을 추천할 수 없습니다.");
			f.mb_recommend.focus();
			return false;
		}

		var msg = reg_mb_recommend_check();
		if(msg) {
			alert(msg);
			f.mb_recommend.select();
			return false;
		}
	}

	document.getElementById("btn_submit").disabled = "disabled";

    return true;
}


function member_leave() {  // 회원 탈퇴 tto
  if (confirm("회원에서 탈퇴 하시겠습니까?"))
    location.href = '<?php echo BV_MBBS_URL ?>/leave_form_update.php';
 }
</script>
<!-- } 회원정보 입력/수정 끝 -->
