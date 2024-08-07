<?php
include_once('./_common.php');
include_once(BV_LIB_PATH.'/register.lib.php');
include_once(BV_LIB_PATH.'/mailer.lib.php');

// check_demo();

if(!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

/* ------------------------------------------------------------------------ _20240715_SY
  *  본인인증 필수일 떄 토큰값 매칭 오류로 주석처리
  ------------------------------------------------------------------------ */
// if($_SESSION['ss_hash_token'] != BV_HASH_TOKEN) {
//     alert('잘못된 접근입니다.', BV_MURL);
// }

if($w == 'u')
    $mb_id = isset($_SESSION['ss_mb_id']) ? trim($_SESSION['ss_mb_id']) : '';
else if($w == '')
    $mb_id = trim($_POST['mb_id']);
else
    // alert('잘못된 접근입니다.', BV_MURL);

if(!$mb_id)
    // alert('회원아이디 값이 없습니다. 올바른 방법으로 이용해 주십시오.');

$mb_password    = trim($_POST['mb_password']);
$mb_password_re = trim($_POST['mb_password_re']);
$mb_name        = trim($_POST['mb_name']);
$mb_email       = trim($_POST['mb_email']);


// mb_tel 배열로 들어옴 _20240531_SY
if (isset($_POST['mb_tel']) && is_array($_POST['mb_tel'])) {
  $mb_tel = implode('-', array_map('trim', $_POST['mb_tel']));
} else {
  $mb_tel = isset($_POST['mb_tel']) ? trim($_POST['mb_tel']) : "";
}


// mb_hp 배열로 들어옴 _20240228_SY
if(is_array($_POST['mb_hp'])) {
  foreach($_POST['mb_hp'] as $val) {
    if(!next($_POST['mb_hp'])) {
      $mb_hp .= trim($val) ;
    } else {
      $mb_hp .= trim($val)."-";
    }
  }
} else {
  $mb_hp        = isset($_POST['mb_hp'])            ? trim($_POST['mb_hp'])          : "";
}
$mb_zip			    = isset($_POST['mb_zip'])           ? trim($_POST['mb_zip'])		     : "";
$mb_addr1       = isset($_POST['mb_addr1'])         ? trim($_POST['mb_addr1'])       : "";
$mb_addr2       = isset($_POST['mb_addr2'])         ? trim($_POST['mb_addr2'])       : "";
$mb_addr3       = isset($_POST['mb_addr3'])         ? trim($_POST['mb_addr3'])       : "";
$mb_addr_jibeon = isset($_POST['mb_addr_jibeon'])   ? trim($_POST['mb_addr_jibeon']) : "";
$mb_recommend   = isset($_POST['mb_recommend'])     ? trim($_POST['mb_recommend'])   : "";
$mb_mailling    = isset($_POST['mb_mailling'])      ? trim($_POST['mb_mailling'])    : "";
$mb_sms         = isset($_POST['mb_sms'])           ? trim($_POST['mb_sms'])         : "";

$mb_name        = clean_xss_tags($mb_name);
$mb_email       = get_email_address($mb_email);
$mb_tel         = clean_xss_tags($mb_tel);
$mb_zip			    = preg_replace('/[^0-9]/', '', $mb_zip);
$mb_addr1       = clean_xss_tags($mb_addr1);
$mb_addr2       = clean_xss_tags($mb_addr2);
$mb_addr3       = clean_xss_tags($mb_addr3);
$mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';

// 추가 _20240604_SY
$manager_idx    = isset($_POST['mn_idx'])        ? trim($_POST['mn_idx']) : "";
$ju_restaurant  = isset($_POST['ju_restaurant']) ? trim($_POST['ju_restaurant']) : "";
$ju_sectors     = isset($_POST['ju_sectors'])    ? trim($_POST['ju_sectors']) : "";
// 추가 _20240608_SY
$ju_region2     = isset($_POST['ju_region2']) ? trim($_POST['ju_region2']) : "";
$ju_region3     = isset($_POST['ju_region3']) ? trim($_POST['ju_region3']) : "";
// 추가 20240612_SY
$ju_lat         = isset($_POST['ju_lat']) ? trim($_POST['ju_lat']) : "";
$ju_lng         = isset($_POST['ju_lng']) ? trim($_POST['ju_lng']) : "";

// 추가 _20240617_SY
$ju_region_code = isset($_POST['ju_region_code']) ? trim($_POST['ju_region_code']) : "";
$ju_region_code = trim(explode("/", $ju_region_code)[1]);

// 추가 _20240723_SY
$ju_region1     = isset($_POST['ju_region1']) ? trim($_POST['ju_region1']) : "";

if($ju_region_code) {
  $office_where = " WHERE a.office_name = '{$ju_region_code}' ";
  $office_data = getRegionFunc("office", $office_where);
  $ju_region1 = $office_data[0]['areacode'];
  $ju_region2 = $office_data[0]['branch_code'];
  $ju_region3 = $office_data[0]['office_code'];
}

// 추가 _20240712_SY
$store_display   = isset($_POST['store_display'])   ? trim($_POST['store_display']) : "2";
$b_addr_req_base = isset($_POST['b_addr_req_base']) ? $_POST['b_addr_req_base']     : "";

if($w == '' || $w == 'u') {

    if($msg = empty_mb_id($mb_id))	alert($msg);
    if($msg = valid_mb_id($mb_id))	alert($msg);
    if($msg = count_mb_id($mb_id))	alert($msg);

    // 이름에 utf-8 이외의 문자가 포함됐다면 오류
    // 서버환경에 따라 정상적으로 체크되지 않을 수 있음.
    $tmp_mb_name = iconv('UTF-8', 'UTF-8//IGNORE', $mb_name);
    if($tmp_mb_name != $mb_name) {
        alert('이름을 올바르게 입력해 주십시오.');
    }

    if($w == '' && !$mb_password)
        alert('비밀번호가 넘어오지 않았습니다.');
    if($w == '' && $mb_password != $mb_password_re)
        alert('비밀번호가 일치하지 않습니다.');

    if($msg = empty_mb_name($mb_name))		alert($msg);
    // 이메일 필수값 X _20240712_SY
    // if($msg = empty_mb_email($mb_email))	alert($msg);
    if($msg = reserve_mb_id($mb_id))		alert($msg);
    // 이름에 한글명 체크를 하지 않는다.
    //if($msg = valid_mb_name($mb_name))	alert($msg);
    // 이메일 필수값 X _20240712_SY
    if(!empty($mb_email)) {
      if($msg = valid_mb_email($mb_email))	alert($msg);
      if($msg = prohibit_mb_email($mb_email))	alert($msg);
    }

    // 휴대폰 필수입력일 경우 휴대폰번호 유효성 체크
    if(($config['register_use_hp'] || $config['cf_cert_hp']) && $config['register_req_hp']) {
        if($msg = valid_mb_hp($mb_hp))		alert($msg);
    }

    if($w == '') {
        if($msg = exist_mb_id($mb_id))		alert($msg);

        // if(get_session('ss_check_mb_id') != $mb_id || get_session('ss_check_mb_email') != $mb_email) {
        if(get_session('ss_check_mb_id') != $mb_id) {
            set_session('ss_check_mb_id', '');
            // set_session('ss_check_mb_email', '');

            alert('올바른 방법으로 이용해 주십시오.');
        }

        // 본인확인 체크
        if($config['cf_cert_use'] && $config['cf_cert_req']) {

          if(trim($_POST['cert_no']) != $_SESSION['ss_cert_no'] || !$_SESSION['ss_cert_no']){
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
          }
        }

        if($mb_recommend) {
            if(!exist_mb_id($mb_recommend))
                alert("추천인이 존재하지 않습니다.");
        }

        if(strtolower($mb_id) == strtolower($mb_recommend)) {
            alert('본인을 추천할 수 없습니다.');
        }
    } else {
		// 자바스크립트로 정보변경이 가능한 버그 수정
		// 회원정보의 메일을 이전 메일로 옮기고 아래에서 비교함
		$old_email = $member['email'];
	}
  // 이메일 필수값 X _20240712_SY
  if(!empty($mb_email)) {
    if($msg = exist_mb_email($mb_email, $mb_id))   alert($msg);
  }
}

//===============================================================
//  본인확인
//---------------------------------------------------------------
$mb_hp = hyphen_hp_number($mb_hp);
if($config['cf_cert_use'] && $_SESSION['ss_cert_type'] && $_SESSION['ss_cert_dupinfo']) {
    // 중복체크
    $sql = " select id from shop_member where id <> '{$member['id']}' and mb_dupinfo = '{$_SESSION['ss_cert_dupinfo']}' ";
    $row = sql_fetch($sql);
    if($row['id']) {
        alert("입력하신 본인확인 정보로 가입된 내역이 존재합니다..\\n회원아이디 : ".$row['id']);
    }
}

unset($value);
$md5_cert_no = $_SESSION['ss_cert_no'];
$cert_type = $_SESSION['ss_cert_type'];
if($config['cf_cert_use'] && $cert_type && $md5_cert_no) {
    // 해시값이 같은 경우에만 본인확인 값을 저장한다.
    log_write(md5($mb_name.$cert_type.$_SESSION['ss_cert_birth'].$md5_cert_no));
    log_write($_SESSION['ss_cert_hash']);
    if($_SESSION['ss_cert_hash'] == md5($mb_name.$cert_type.$_SESSION['ss_cert_birth'].$md5_cert_no)) {
        $value['cellphone']		= $mb_hp;
        $value['mb_certify']	= $cert_type;
        $value['mb_adult']		= $_SESSION['ss_cert_adult'];
        $value['mb_birth']		= $_SESSION['ss_cert_birth'];
        $value['gender']		  = $_SESSION['ss_cert_sex'];
        $value['mb_dupinfo']	= $_SESSION['ss_cert_dupinfo'];
		    $value['age']			    = get_birth_age($_SESSION['ss_cert_birth']);
        if($w == 'u'){
			    $value['name'] = $mb_name;
        }
    } else {
        $value['cellphone']		= $mb_hp;
        $value['mb_certify']	= '';
        $value['mb_adult']		= '0';
        $value['mb_birth']		= '';
        $value['gender']		  = '';
        $value['age']			    = '';
    }
} else {
    if(get_session("ss_reg_mb_name") != $mb_name || get_session("ss_reg_mb_hp") != $mb_hp) {
        $value['cellphone']		= $mb_hp;
        $value['mb_certify']	= '';
        $value['mb_adult']		= '0';
        $value['mb_birth']		= '';
        $value['gender']		  = '';
		    $value['age']			    = '';
    }
}
//===============================================================

$msg = "";

if($w == '') {
	$value['id']			    = $mb_id; //회원아이디
	$value['passwd']		  = $mb_password; //비밀번호
	$value['name']			  = $mb_name; //이름
	$value['email']			  = $mb_email; //이메일
  $value['telephone']	  = $mb_tel;	 //전화번호
	$value['zip']			    = $mb_zip; //우편번호
	$value['addr1']			  = $mb_addr1; //주소
	$value['addr2']			  = $mb_addr2; //상세주소
	$value['addr3']			  = $mb_addr3; //참고항목
	$value['addr_jibeon']	= $mb_addr_jibeon; //지번주소
	$value['today_login']	= "0000-00-00 00:00:00"; //최근 로그인일시
	$value['reg_time']		= BV_TIME_YMDHIS; //가입일시
	$value['mb_ip']			  = $_SERVER['REMOTE_ADDR']; //IP
	$value['grade']			  = ($reg_type == 1) ? 8 : 9; //레벨
	$value['pt_id']			  = $mb_recommend; //추천인아이디
	$value['login_ip']	  = $_SERVER['REMOTE_ADDR']; //최근 로그인IP
	$value['mailser']		  = $mb_mailling ? $mb_mailling : 'N'; //E-Mail을 수신
	$value['smsser']		  = $mb_sms ? $mb_sms : 'N'; //SMS를 수신
  $value['ju_mem']      = $reg_type; // 사업자 여부

    $value['refund_bank']   =$refund_bank;//환불은행
    $value['refund_num']   =$refund_num;//환불계좌번호
    $value['refund_name']   =$refund_name;//환불계좌주
    $value['b_addr_req_base']   =$b_addr_req_base;//배송기본메시지


    $value['ju_b_num']      = $b_no;                      // 사업자등록번호
    $value['ju_display']    = $store_display;             // 매장 노출 여부 추가 _20240712_SY

    $value['mb_agent'] = getOs(); //os 가져와
    if ($value['mb_agent'] != "Windows") {
      $value['login_sum'] = 1;
    }
    // store_display (매장 노출 여부) 체크 추가 _20240712_SY
  if($reg_type == 1) {
    $value['ju_name']       = $mb_name;                   // 중앙회원 이름
    $value['ju_unique_num'] = $pop_u_no;                  // 중앙회원 고유번호
    $value['ju_closed']     = $chk_cb_res;                // 휴/폐업
    // 추가 _20240604_SY
    $value['ju_restaurant'] = $ju_restaurant;             // 상호명
    $value['ju_sectors']    = $ju_sectors;                // 업종
    $value['ju_cate']       = $ju_sectors;                // 업태
    $value['ju_manager']    = $manager_idx;               // 담당직원
    $value['ju_addr_full']  = $mb_addr1." ".$mb_addr2;    // 엑셀 업로드 주소
    $value['ju_region1']    = $ju_region1;                // 지역
    $value['ju_region2']    = $ju_region2;                // 지회
    $value['ju_region3']    = $ju_region3;                // 지부
    $value['ju_lat']        = $ju_lat;                    // 위도
    $value['ju_lng']        = $ju_lng;                    // 경도
    $value['ju_content']    = $ju_content;                // 매장정보
    // 추가 _20240712_SY
    $value['ju_worktime']   = implode("~", $_POST['worktime']);  // 영업시간
    $value['ju_breaktime']  = implode("~", $_POST['breaktime']); // 브레이크타임
    $value['ju_off']        = implode("|", $_POST['off']);       // 휴무요일
  }
    // 관리자인증을 사용하지 않는다면 인증으로 간주함.
    if(!$config['cert_admin_yes'])
        $value['use_app']	= '1';

	insert("shop_member", $value);
	$mb_no = sql_insert_id();


  // 추가 _20240712_SY
  /* 매장 사진 */
  if($reg_type == 1) {
    $sub_imgs = explode("|", $member['ju_simg']);
    $image_regex = "/(\.(jpg|gif|png))$/i";
    $save_dir = BV_DATA_PATH.'/member/';
    $dir = $save_dir.$mb_id;

    //폴더생성
    if(!is_dir($dir)) {
        @mkdir($dir, BV_DIR_PERMISSION);
        @chmod($dir, BV_DIR_PERMISSION);
    }

    // 매장외부 대표 이미지
    if(is_uploaded_file($_FILES['ju_mimg']['tmp_name'])){
      if(preg_match($image_regex, $_FILES['ju_mimg']['name'])){
          $exts = explode(".", $_FILES['ju_mimg']['name']);
        $save_name = $mb_id.'/main_image.'.strtolower($exts[count($exts)-1]);
        $dest_path = $save_dir.$save_name;
        move_uploaded_file($_FILES['ju_mimg']['tmp_name'], $dest_path);
        chmod($dest_path, BV_FILE_PERMISSION);

        sql_query(" update shop_member set ju_mimg = '$save_name' where id = '$mb_id' ");
      }
    }

    // 매장내부 서브 이미지
    $idx = time();
    for($i=0;$i < count($_FILES['ju_simg']['tmp_name']);$i++){
        if(is_uploaded_file($_FILES['ju_simg']['tmp_name'][$i])){
          if(preg_match($image_regex, $_FILES['ju_simg']['name'][$i])){
              $exts = explode(".", $_FILES['ju_simg']['name'][$i]);
            $save_name = $mb_id.'/sub_image_'.$idx.'.'.strtolower($exts[count($exts)-1]);
            $dest_path = $save_dir.$save_name;
            move_uploaded_file($_FILES['ju_simg']['tmp_name'][$i], $dest_path);
            chmod($dest_path, BV_FILE_PERMISSION);
            array_push($sub_imgs, $save_name);
            $idx++;
          }
        }
    }
    $sub_imgs = array_filter($sub_imgs);
    $sub_imgs = array_values($sub_imgs);
    $save_img = implode("|", $sub_imgs);
    sql_query(" update shop_member set ju_simg = '$save_img' where id = '$mb_id' ");
  }
  /* 매장 사진 */


  /* ------------------------------------------------------------------------------------- _20240713_SY
    * 기본배송지 추가
  /* ------------------------------------------------------------------------------------- */
    $b_addr_table = "b_address";
    $b_addr_value['mb_id']        = $mb_id;
    $b_addr_value['b_cellphone']  = $mb_hp;
    $b_addr_value['b_telephone']  = $mb_tel;
    $b_addr_value['b_zip']        = $mb_zip;
    $b_addr_value['b_addr1']      = $mb_addr1;
    $b_addr_value['b_addr2']      = $mb_addr2;
    $b_addr_value['b_addr3']      = $mb_addr3;
    $b_addr_value['b_addr_jibun'] = $mb_addr_jibeon;
    $b_addr_value['b_name']       = "기본배송지";
    $b_addr_value['b_base']       = "1";
    $b_addr_value['b_addr_jibeon']= $mb_addr_jibeon;
    $b_addr_value['b_addr_req']   = $b_addr_req_base;

    $INSERT_BADDR = new IUD_Model;
    $INSERT_BADDR->insert($b_addr_table, $b_addr_value);



    // 회원가입 포인트 부여
    insert_point($mb_id, $config['register_point'], '회원가입 축하', '@member', $mb_id, '회원가입');

    // 추천인에게 포인트 부여
	insert_point($mb_recommend, $config['partner_point'], $mb_id.'의 추천인', '@member', $mb_recommend, $mb_id.' 추천');

	// 회원님께 메일 발송
	$subject = '['.$config['company_name'].'] 회원가입을 축하드립니다.';

	ob_start();
	include_once(BV_BBS_PATH.'/register_form_update_mail1.php');
	$content = ob_get_contents();
	ob_end_clean();

	mailer($config['company_name'], $super['email'], $mb_email, $subject, $content, 1);


	// 최고관리자님께 메일 발송
	$subject = '['.$config['company_name'].'] '.$mb_name .'님께서 회원으로 가입하셨습니다.';

	ob_start();
	include_once(BV_BBS_PATH.'/register_form_update_mail2.php');
	$content = ob_get_contents();
	ob_end_clean();

	mailer($mb_name, $mb_email, $super['email'], $subject, $content, 1);

	// 회원가입 문자발송
	icode_register_sms_send($mb_recommend, $mb_id);

    // 관리자인증을 사용하지 않는 경우에만 로그인
	if($config['cert_admin_yes'])
		$msg = "회원가입이 완료 되었으며 승인 처리 이후 로그인 가능합니다";
	else
    // 회원가입 후 바로 로그인 처리 _20240308_SY
		// set_session('ss_mb_id', $mb_id);

	set_session('ss_mb_reg', $mb_id);

} else if($w == 'u') {
    if(!trim($_SESSION['ss_mb_id']))
        alert('로그인 되어 있지 않습니다.');

    if(trim($_POST['mb_id']) != $mb_id)
        alert("로그인된 정보와 수정하려는 정보가 틀리므로 수정할 수 없습니다.\\n만약 올바르지 않은 방법을 사용하신다면 바로 중지하여 주십시오.");

    if($mb_password)
        $value['passwd']	= $mb_password; //비밀번호

	$value['email']			= $mb_email; //이메일
	$value['telephone']		= $mb_tel;	 //전화번호
	$value['zip']			= $mb_zip; //우편번호
	$value['addr1']			= $mb_addr1; //주소
	$value['addr2']			= $mb_addr2; //상세주소
	$value['addr3']			= $mb_addr3; //참고항목
	$value['addr_jibeon']	= $mb_addr_jibeon; //지번주소
	$value['mailser']		= $mb_mailling ? $mb_mailling : 'N'; //E-Mail을 수신
	$value['smsser']		= $mb_sms ? $mb_sms : 'N'; //SMS를 수신

    $value['refund_bank']   =$refund_bank;//환불은행
    $value['refund_num']   =$refund_num;//환불계좌번호
    $value['refund_name']   =$refund_name;//환불계좌주
    $value['b_addr_req_base']   =$b_addr_req_base;//배송기본메시지

  // 중앙회 회원 정보 수정 _20240621_SY
  // 수정 _20240712_SY
  // if($member['grade'] < 9) {
  if($member['ju_mem'] == '1') {
    $value['ju_display']    = $store_display; // 매장 노출 여부 추가 _20240712_SY
    $value['ju_name']       = $mb_name;
    $value['ju_unique_num'] = $pop_u_no;
    $value['ju_closed']     = $chk_cb_res;
    $value['ju_restaurant'] = $ju_restaurant;
    $value['ju_sectors']    = $ju_sectors;
    $value['ju_cate']       = $ju_sectors;
    $value['ju_manager']    = $manager_idx;
    $value['ju_addr_full']  = $mb_addr1." ".$mb_addr2;
    $value['ju_region1']    = $ju_region1;
    $value['ju_region2']    = $ju_region2;
    $value['ju_region3']    = $ju_region3;
    $value['ju_content']    = $ju_content;
    $value['ju_worktime']   = implode("~", $_POST['worktime']);
    $value['ju_breaktime']  = implode("~", $_POST['breaktime']);
    $value['ju_off']        = implode("|", $_POST['off']);
    $value['ju_tel']        = $_POST['ju_tel'];
    $value['ju_hp']         = $_POST['ju_hp'];
  }

	update("shop_member", $value, " where id = '{$member['id']}' ");


  /* 매장 사진 */
  $sub_imgs = explode("|", $member['ju_simg']);
  $image_regex = "/(\.(jpg|gif|png))$/i";
  $save_dir = BV_DATA_PATH.'/member/';
  $dir = $save_dir.$mb_id;

  //폴더생성
  if(!is_dir($dir)) {
      @mkdir($dir, BV_DIR_PERMISSION);
      @chmod($dir, BV_DIR_PERMISSION);
  }

  // 매장외부 대표 이미지
  if(is_uploaded_file($_FILES['ju_mimg']['tmp_name'])){
    if(preg_match($image_regex, $_FILES['ju_mimg']['name'])){
        $exts = explode(".", $_FILES['ju_mimg']['name']);
      $save_name = $mb_id.'/main_image.'.strtolower($exts[count($exts)-1]);
      $dest_path = $save_dir.$save_name;
      move_uploaded_file($_FILES['ju_mimg']['tmp_name'], $dest_path);
      chmod($dest_path, BV_FILE_PERMISSION);

      sql_query(" update shop_member set ju_mimg = '$save_name' where id = '$mb_id' ");
    }
  }

  // 매장내부 서브 이미지
  $idx = time();
  for($i=0;$i < count($_FILES['ju_simg']['tmp_name']);$i++){
      if(is_uploaded_file($_FILES['ju_simg']['tmp_name'][$i])){
        if(preg_match($image_regex, $_FILES['ju_simg']['name'][$i])){
            $exts = explode(".", $_FILES['ju_simg']['name'][$i]);
          $save_name = $mb_id.'/sub_image_'.$idx.'.'.strtolower($exts[count($exts)-1]);
          $dest_path = $save_dir.$save_name;
          move_uploaded_file($_FILES['ju_simg']['tmp_name'][$i], $dest_path);
          chmod($dest_path, BV_FILE_PERMISSION);
          array_push($sub_imgs, $save_name);
          $idx++;
        }
      }
  }
  $sub_imgs = array_filter($sub_imgs);
  $sub_imgs = array_values($sub_imgs);
  $save_img = implode("|", $sub_imgs);
  sql_query(" update shop_member set ju_simg = '$save_img' where id = '$mb_id' ");
  /* 매장 사진 */
}



/* ------------------------------------------------------------------------------------- _20240713_SY
  * 중앙회회원등급 회원 가입시 5천원, 1만원 할인 쿠폰 2장 발급
  * Type으로 구분하는게 가장 좋을 거 같은데 우선 cp_explane 문구로 구분함
  ------------------------------------------------------------------------------------- */
if($w == '' && $config['coupon_yes'] && $reg_type == 1) {
	$cp_used = false;
	$cp_sel = " SELECT * FROM shop_coupon WHERE cp_type = '5' AND cp_id < 3 ";
  $cp_res = sql_query($cp_sel);
  while($cp = sql_fetch_array($cp_res)) {
    if($cp['cp_id'] && $cp['cp_use']) {
      if(($cp['cp_pub_sdate'] <= BV_TIME_YMD || $cp['cp_pub_sdate'] == '9999999999') &&
         ($cp['cp_pub_edate'] >= BV_TIME_YMD || $cp['cp_pub_edate'] == '9999999999'))
        $cp_used = true;

      if($cp_used)
        insert_used_coupon($mb_id, $mb_name, $cp);
    }
  }
} else {

  // 신규회원가입 쿠폰발급
  if($w == '' && $config['coupon_yes']) {
    $cp_used = false;
    $cp = sql_fetch("select * from shop_coupon where cp_type = '5' AND cp_id >= 3 ");
    if($cp['cp_id'] && $cp['cp_use']) {
      if(($cp['cp_pub_sdate'] <= BV_TIME_YMD || $cp['cp_pub_sdate'] == '9999999999') &&
        ($cp['cp_pub_edate'] >= BV_TIME_YMD || $cp['cp_pub_edate'] == '9999999999'))
        $cp_used = true;

      if($cp_used)
        insert_used_coupon($mb_id, $mb_name, $cp);
    }
  }

}


unset($_SESSION['ss_cert_type']);
unset($_SESSION['ss_cert_no']);
unset($_SESSION['ss_cert_hash']);
unset($_SESSION['ss_cert_birth']);
unset($_SESSION['ss_cert_adult']);
unset($_SESSION['ss_hash_token']);

if($msg)
    echo '<script>alert(\''.$msg.'\');</script>';

if($w == '') {
    goto_url(BV_MBBS_URL.'/register_result.php');
  } else if($w == 'u') {
    $row = sql_fetch(" select passwd from shop_member where id = '{$member['id']}' ");
    $tmp_password = $row['passwd'];

	echo '
	<!doctype html>
	<html lang="ko">
	<head>
	<meta charset="utf-8">
	<title>회원정보수정</title>
	<body>
	<form name="fregisterupdate" method="post" action="'.BV_MSHOP_URL.'/mypage.php">
	<input type="hidden" name="w" value="u">
	<input type="hidden" name="mb_id" value="'.$mb_id.'">
	<input type="hidden" name="mb_password" value="'.$tmp_password.'">
	<input type="hidden" name="is_update" value="1">
	</form>
	<script>
	//alert("회원 정보가 수정 되었습니다.");
	document.fregisterupdate.submit();
	</script>
	</body>
	</html>';
}
?>