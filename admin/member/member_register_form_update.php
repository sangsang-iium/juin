<?php
include_once("./_common.php");
include_once(BV_LIB_PATH."/register.lib.php");

// check_demo();

// check_admin_token();

$mb_id = trim($_POST['mb_id']);

// 중앙회 회원 여부 (0:false / 1:true) _20240611_SY
$chk_b_num = $_POST['chk_b_num'];

// 전화번호 체크 _20240612_SY
$mb_tel = hyphen_hp_number($_POST['mb_tel']);
if($mb_tel) {
    $result = exist_mb_hp($mb_tel, $mb_id);
    if($result)
        alert($result);
}

// 휴대폰번호 체크
$mb_hp = hyphen_hp_number($_POST['mb_hp']);
if($mb_hp) {
    $result = exist_mb_hp($mb_hp, $mb_id);
    if($result)
        alert($result);
}

// 인증정보처리
if($_POST['mb_certify_case'] && $_POST['mb_certify']) {
    $mb_certify = $_POST['mb_certify_case'];
    $mb_adult = $_POST['mb_adult'];
} else {
    $mb_certify = '';
    $mb_adult = 0;
}

$mb = get_member($mb_id);
if($mb['id'])
	alert('이미 존재하는 회원아이디입니다.\\nＩＤ : '.$mb['id'].'\\n이름 : '.$mb['name'].'\\n메일 : '.$mb['email']);

// 이메일중복체크
if(!empty($_POST['mb_email'])){
  $sql = " select id, name, email from shop_member where email = '{$_POST['mb_email']}' ";
  $row = sql_fetch($sql);
  if($row['id'])
  	alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['id'].'\\n이름 : '.$row['name'].'\\n메일 : '.$row['email']);
}

unset($value);
$value['id']			    = $mb_id; //회원아이디
$value['passwd']		  = $mb_password; //비밀번호
$value['name']			  = $mb_name; //이름
$value['email']			  = $mb_email; //이메일
$value['cellphone']		= $mb_hp; //핸드폰
$value['telephone']		= $mb_tel;	 //전화번호
$value['zip']			    = $mb_zip; //우편번호
$value['addr1']			  = $mb_addr1; //주소
$value['addr2']			  = $mb_addr2; //상세주소
$value['addr3']			  = $mb_addr3; //참고항목
$value['addr_jibeon']	= $mb_addr_jibeon; //지번주소
$value['today_login']	= BV_TIME_YMDHIS; //최근 로그인일시
$value['reg_time']		= BV_TIME_YMDHIS; //가입일시
$value['mb_ip']			  = $_SERVER['REMOTE_ADDR']; //IP
$value['grade']			  = $mb_grade; //레벨
$value['pt_id']			  = $mb_recommend; //추천인아이디
$value['login_ip']		= $_SERVER['REMOTE_ADDR']; //최근 로그인IP
$value['mailser']		  = $mb_mailling ? $mb_mailling : 'N'; //E-Mail을 수신
$value['smsser']		  = $mb_sms ? $mb_sms : 'N'; //SMS를 수신
$value['mb_certify']	= $mb_certify;
$value['mb_adult']		= $mb_adult;
$value['ju_b_num']    = formatBno($ju_b_num);

// 담당자 추가 _20240618_SY
if($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  $value['ju_manager'] = $ju_manager;
  $value['ju_region1'] = $ju_region1;
  $value['ju_region2'] = $ju_region2;
  $value['ju_region3'] = $ju_region3;
}

if($chk_b_num == 1) {
  // 매장 대표번호 체크 _20240612_SY
  $ju_tel = hyphen_hp_number($_POST['ju_tel']);
  if($ju_tel) {
    $result = exist_mb_hp($ju_tel, $mb_id);
    if($result)
      alert($result);
  }

  // 중앙회 매장 정보 _20240612_SY
  $value['ju_restaurant'] = $_POST['ju_restaurant'];
  $value['ju_mem']        = $_POST['ju_mem'];
  $value['ju_cate']       = $_POST['ju_cate'];
  $value['ju_lat']        = $_POST['ju_lat'];
  $value['ju_lng']        = $_POST['ju_lng'];
  $value['ju_sectors']		= $_POST['ju_cate'];
  $value['ju_addr_full']  = $_POST['mb_addr1_st'];
  $value['ju_name']       = $_POST['ju_member'];
  $value['ju_worktime']   = implode("~", $_POST['worktime']);
  $value['ju_breaktime']  = implode("~", $_POST['breaktime']);
  $value['ju_off']        = implode("|", $_POST['off']);
  $value['ju_content']    = $_POST['ju_content'];
  $value['ju_tel']        = $ju_tel;
}

// 관리자인증을 사용하지 않는다면 인증으로 간주함.
if(!$config['cert_admin_yes'])
	$value['use_app']	= '1';

insert("shop_member", $value);
$mb_no = sql_insert_id();

if($mb_no && $chk_b_num == 1) {
  /* 매장 사진 */
  $sub_imgs = explode("|", $value['ju_simg']);
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

alert("회원가입이 완료 되었습니다.", BV_ADMIN_URL."/member.php?code=register_form");
?>