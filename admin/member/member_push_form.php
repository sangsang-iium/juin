<?php
if (!defined('_BLUEVATION_')) exit;
?>

<script src="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css">

<script src="<?php echo BV_JS_URL; ?>/jquery.register_form.js"></script>

<form name="fpushform" id="fpushform" action="./member/member_push_form_update.php" onsubmit="return fpushform_submit(this);" method="post" autocomplete="off" enctype="MULTIPART/FORM-DATA">
  <input type="hidden" name="token" value="">

  <h5 class="htag_title">Push 메세지 설정</h5>
  <div class="board_table mart20">
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <!-- <tr>
          <th scope="row"><label for="">발송시간</label></th>
          <td>
            <input type="text" name="" id="" required class="frm_input required w400">
            <?php //echo help('4자 이상의 영문 및 숫자'); ?>
          </td>
        </tr> -->
        <tr>
          <th scope="row"><label for="">발송시간</label></th>
          <td>
            <div style="display: flex;">
              <div class="radio_group">
                <label><input type="radio" name="test001" value="" checked="checked">즉시 발송</label>
                <label><input type="radio" name="test001" value="">예약 발송</label>
              </div>
              <div style="margin-left: 5px;">
                <label for="resv_date" class="sound_only">발송예약일시</label>
                <input type="text" name="resv_date" value="" id="resv_date" disabled class="frm_input w190 disabled">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_subject">제목</label></th>
          <td>
            <input type="text" name="" id="push_subject" class="frm_input w400">
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="">내용</label></th>
          <td>
            <?php echo editor_html('push_memo', ''); ?>
            <?php //echo editor_html('memo', get_text($nw['memo'], 0)); ?>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_img">이미지 첨부</label></th>
          <td>
            <input type="file" name="" id="push_img">
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="">링크 URL</label></th>
          <td>
            <input type="text" name="" id="push_subject" class="frm_input w400">
          </td>
        </tr>
        <tr>
          <th scope="row" rowspan="2"><label for="">발송대상</label></th>
          <td>
            <div class="radio_group">
              <label><input type="radio" name="push_mb" value="0" checked="checked">전체회원</label>
              <span class="chk_select">
                <!-- 
                [백엔드] 수정의 경우 '선택회원'이 체크된 경우 disabled 처리
                - disabled : <select name="" id="" class="disabled" disabled> 
                - non-disabled : <select name="" id="" class="">
                -->
                <select name="" id="push_mb_select" class="">
                  <option value="">전체회원</option>
                  <option value="">일반회원</option>
                  <option value="">중앙회원</option>
                  <option value="">임직원 회원</option>
                </select>
              </span>
              <label><input type="radio" name="push_mb" value="1">선택회원</label>
                <!-- 
                [백엔드] 수정의 경우 '전체회원'이 체크된 경우 disabled 처리
                - disabled : <button type="button" class="btn_small push_mbSch_btn disabled" disabled>선택</button>
                - non-disabled : <button type="button" class="btn_small push_mbSch_btn">선택</button>
                -->
              <button type="button" id="push_mbSch_btn" class="btn_small disabled" disabled>선택</button>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="selected_mb_wr">
              <!-- loop { -->
              <div class="selected_mb">
                <span>중앙회</span>
                <em>(00)</em>
                <button type="button" class="btn_small mgr5"></button>
              </div>
              <!-- } loop -->
              <div class="selected_mb">
                <span>대전광역시지회</span>
                <em>(00)</em>
                <button type="button" class="btn_small mgr5"></button>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="btn_wrap mart30">
    <input type="submit" value="저장" class="btn_write" accesskey="s">
    <a href="./member.php?code=push" class="btn_list bg_type1">목록</a>
  </div>
</form>

<script>
  //폼 전송
  function fpushform_submit(f)
  {
    <?php echo get_editor_js('push_memo'); ?>
    
    //예외처리 필요

    return true;
  }

  $(document).ready(function(){
    //예약발송(일시)
    const setToday = new Date();
    setToday.setHours(0, 0, 0, 0);

    $.datetimepicker.setLocale('kr'); 
    $("#resv_date").datetimepicker({
      timepicker: true,
      format: 'Y-m-d H:i',
      step: 30, // 30분 간격으로 설정
      minDate: setToday, // 오늘 이전 날짜를 선택할 수 없도록 설정
      lang: 'ko',
      i18n:{
        kr:{
          months: [
            '1월','2월','3월','4월',
            '5월','6월','7월','8월',
            '9월','10월','11월','12월',
          ],
          dayOfWeek: [
            "일", "월", "화", "수", 
            "목", "금", "토",
          ]
        }
      },
      onGenerate: function(ct) {
        const times = $(this).find('.xdsoft_time');
        times.each(function() {
          const time = $(this).text();
          const [hours, minutes] = time.split(':').map(Number);
          if (minutes !== 0 && minutes !== 30) {
            $(this).hide();
          }
        });
      }
    });

    //발송대상
    // > 전체회원, 선택회원 라디오 이벤트
    const $pushMbSelect = $("#push_mb_select");
    const $pushMbSchBtn = $("#push_mbSch_btn");
    const $pushMbRadio = $("input[name='push_mb']"); //발송대상 라디오 버튼(a1)(name값)
    let pushMbRadio_val = ""; //발송대상 라디오 버튼의 선택값(a2)(초기화)

    $pushMb.on('change', function(){
      pushMbRadio_val = $(this).val(); //(a2)(할당)

      if(pushMbRadio_val != "") {
        if(pushMbRadio_val == 0) { //(a2)전체회원
          $pushMbSchBtn.attr('disabled', true).addClass('disabled');
          $pushMbSelect.attr('disabled', false).removeClass('disabled');
        } else if(pushMbRadio_val == 1) { //(a2)선택회원
          $pushMbSelect.attr('disabled', true).addClass('disabled');
          $pushMbSchBtn.attr('disabled', false).removeClass('disabled');
        } else {
          console.error('발송대상 라디오 버튼의 선택값을 확인하세요.');
        }
      }
    });
  });
</script>