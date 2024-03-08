<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가
?>

<!-- 회원가입결과 시작 { -->
<div id="contents" class="sub-contents joinComplete">
    <div class="joinComplete-wrap">
        <div class="container">
            <div class="joinComplete-head">
                <div class="joinComplete-img">
                <img src="/src/img/icon-check.svg" alt="회원가입 완료 아이콘">
                </div>
                <h5 class="joinComplete-title"><?php echo get_text($mb['name']); ?>님, <b>회원가입</b>을 <b>축하</b>합니다.</h5>
                <p class="joinComplete-text">주인장에서 다양한 제품과 컨텐츠를 확인하세요.</p>
            </div>
            <div class="joinComplete-body">
                <!-- <a href="" class="ui-btn stWhite round joinComplete-btn">로그인 하기</a> -->
                <!-- <a href="<?php echo BV_MURL; ?>" class="ui-btn stBlack round joinComplete-btn">메인으로 돌아가기</a> -->
                <a href="<?php echo BV_MURL."/bbs/login.php"; ?>" class="ui-btn stBlack round joinComplete-btn">확인</a>
                <p class="joinComplete-explan">회원정보는 마이페이지에서 확인 및 수정하실 수 있습니다.</p>
            </div>
        </div>
    </div>
</div>

<!-- <div id="reg_result">
    <p>
        <strong><?php echo get_text($mb['name']); ?></strong>님의 회원가입을 진심으로 축하합니다.<br>
    </p>
    <div id="result_email">
        <span>아이디</span>
        <strong><?php echo $mb['id']; ?></strong><br>
        <span>E-mail</span>
        <strong><?php echo $mb['email']; ?></strong>
    </div>
    <p>
        회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br>
        아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.
    </p>
    <p>
        회원 탈퇴는 언제든지 가능하며 회원 탈퇴시 회원님의 정보는 영구삭제하고 있습니다.<br>
        감사합니다.
    </p>
    <p class="homebtn">
		<a href="<?php echo BV_MURL; ?>" class="btn_medium grey">메인으로 돌아가기</a>
	</p>
</div> -->
<!-- } 회원가입결과 끝 -->