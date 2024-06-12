<?php
include_once("./_common.php");
include_once(BV_LIB_PATH."/register.lib.php");

/*
Array
  (
      [token] => 68dd00aa9b74ffda6e3557ca9a134dfa
      [mb_id] => test0611
      [mb_password] => 1234
      [mb_password_re] => 1234
      [mb_name] => test0611
      [mb_tel] => 
      [mb_hp] => 
      [mb_sms] => Y
      [mb_email] => test0611@test.com
      [mb_mailling] => Y
      [mb_certify] => 
      [mb_adult] => 0
      [mb_grade] => 8
      [mb_zip] => 17999
      [mb_addr1] => 경기도 평택시 팽성읍 추팔2길 91
      [mb_addr2] => 
      [mb_addr_jibeon] => 
      [mb_addr3] => 
      [mb_recommend] => admin
      [ju_b_num] => 8631801050
      [chk_b_num] => 1
      [chk_cb_res] => 0
      [ju_restaurant] => 백년손님
      [ju_member] => 대표이름
      [ju_mem] => 1
      [ju_cate] => 한식
      [ju_mimg] => 백년손님외관.jpg
      [ju_simg] => Array
          (
              [0] => 백년손님내관.jpg
              [1] => 
              [2] => 
              [3] => 
              [4] => 
          )

      [worktime] => Array
          (
              [0] => 07:00
              [1] => 22:00
          )

      [breaktime] => Array
          (
              [0] => 
              [1] => 
          )

      [off] => Array
          (
              [0] => 월요일
          )

      [ju_content] => 
  )
*/

check_demo();

check_admin_token();

$mb_id = trim($_POST['mb_id']);

// 중앙회 회원 여부 (0:false / 1:true) _20240611_SY
$chk_b_num = $_POST['chk_b_num'];

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
$sql = " select id, name, email from shop_member where email = '{$_POST['mb_email']}' ";
$row = sql_fetch($sql);
if($row['id'])
	alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['id'].'\\n이름 : '.$row['name'].'\\n메일 : '.$row['email']);

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

// 관리자인증을 사용하지 않는다면 인증으로 간주함.
if(!$config['cert_admin_yes'])
	$value['use_app']	= '1';

insert("shop_member", $value);

alert("회원가입이 완료 되었습니다.", BV_ADMIN_URL."/member.php?code=register_form");
?>