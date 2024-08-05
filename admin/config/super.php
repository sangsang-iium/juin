<?php
if (!defined('_BLUEVATION_')) exit;
/** 정보변경 _20240717_SY
 * $suepr -> $member로 수정
 */
?>

<form name="fregform" method="post" action="./config/super_update.php">
  <input type="hidden" name="id" value="<?php echo $member['id']?>">
  <input type="hidden" name="token" value="">

  <h5 class="htag_title">상점 관리에 사용될 비밀번호</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table>
      <colgroup>
        <col width="220px">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">관리자 비밀번호</th>
          <td>
            <input type="text" name="passwd" class="frm_input">
            <ul class="cnt_list step01 mart10">
              <li>비밀번호는 되도록 영,숫자를 같이 사용하시는 것이 좋습니다.</li>
              <li>비밀번호는 상점 관리에 매우 중요하므로 상점 관리자외 정보유출을 주의하시고 정기적으로 비밀번호를 변경하세요.</li>
            </ul>
            <?php /* echo help("비밀번호는 되도록 영,숫자를 같이 사용하시는 것이 좋습니다.<br>비밀번호는 상점 관리에 매우 중요하므로 상점 관리자외 정보유출을 주의하시고 정기적으로 비밀번호를 변경하세요."); */ ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <p class="gap50"></p>
  <h5 class="htag_title">상점 관리에 사용될 필수정보</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table>
      <colgroup>
        <col width="220px">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">회원명</th>
          <td><input type="text" name="name" value="<?php echo $member['name']; ?>" required itemname="회원명" class="frm_input required"></td>
        </tr>
        <tr>
          <th scope="row">이메일주소</th>
          <td>
            <input type="text" name="email" value="<?php echo $member['email']; ?>" required email itemname="이메일" class="frm_input required" size="30">
            <ul class="cnt_list step01 mart10">
              <li>회원 메일발송시 사용되므로 실제 사용중인 메일주소를 입력하세요.</li>
            </ul>
            <?php /* echo help("회원 메일발송시 사용되므로 실제 사용중인 메일주소를 입력하세요."); */ ?>
          </td>
        </tr>
        <tr>
          <th scope="row">핸드폰</th>
          <td><input type="text" name="cellphone" value="<?php echo $member['cellphone']; ?>" required itemname="핸드폰" class="frm_input required"></td>
        </tr>
        <tr>
          <th scope="row">주소</th>
          <td>
            <div class="write_address">
              <div class="file_wrap address">
                <input type="text" name="zip" value="<?php echo $member['zip']; ?>" class="frm_input" size="8" maxlength="5">
                <a href="javascript:win_zip('fregform', 'zip', 'addr1', 'addr2', 'addr3', 'addr_jibeon');" class="btn_file">주소검색</a>
              </div>
              <div class="addressMore">
                <input type="text" name="addr1" value="<?php echo $member['addr1']; ?>" class="frm_input" size="60">
                <label for="" class="hide">기본주소</label>
                <input type="text" name="addr2" value="<?php echo $member['addr2']; ?>" class="frm_input" size="60">
                <label for="" class="hide">상세주소</label>
              </div>
            </div>
            <div class="mart5">
              <input type="text" name="addr3" value="<?php echo $member['addr3']; ?>" class="frm_input" size="60">
              <label for="" class="hide">참고항목</label>
              <input type="hidden" name="addr_jibeon" value="<?php echo $member['addr_jibeon']; ?>">
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">이메일 수신</th>
          <td>
            <div class="chk_select">
              <select name="mailser">
                <?php echo option_selected('Y', $member['mailser'], '수신함'); ?>
                <?php echo option_selected('N', $member['mailser'], '수신안함'); ?>
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">SMS 수신</th>
          <td>
            <div class="chk_select">
              <select name="smsser">
                <?php echo option_selected('Y', $member['smsser'], '수신함'); ?>
                <?php echo option_selected('N', $member['smsser'], '수신안함'); ?>
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">포인트</th>
          <td>
            <b>
              <?php echo number_format($member['point']); ?>
            </b>
            <span>Point</span>
            <!-- <a href="<?php echo BV_ADMIN_URL; ?>/member/member_point_req.php?mb_id=<?php echo $member['id']; ?>" onclick="win_open(this,'pop_point_req','450','450','no');return false" class="btn_small grey marl10">강제적립</a> -->
          </td>
        </tr>
        <tr>
          <th scope="row">최후아이피</th>
          <td><?php echo $member['login_ip']; ?></td>
        </tr>
        <tr>
          <th scope="row">로그인횟수</th>
          <td><?php echo number_format($member['login_sum']); ?> 회</td>
        </tr>
        <tr>
          <th scope="row">마지막로그인</th>
          <td><?php echo (!is_null_time($member['today_login'])) ? $member['today_login'] : ''; ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="btn_confirm">
    <input type="submit" value="저장" class="btn_large" accesskey="s">
  </div>
</form>