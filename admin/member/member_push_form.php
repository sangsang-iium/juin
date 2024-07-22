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
                <label for="push_tm_0"><input type="radio" id="push_tm_0" name="push_tm" value="0" checked="checked">즉시 발송</label>
                <label for="push_tm_1"><input type="radio" id="push_tm_1" name="push_tm" value="1">예약 발송</label>
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
          <th scope="row"><label for="push_contents">내용</label></th>
          <td>
            <textarea name="" id="push_contents" class="frm_input"></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_img">이미지 첨부</label></th>
          <td>
            <input type="file" name="" id="push_img">
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_url">링크 URL</label></th>
          <td>
            <input type="text" name="" id="push_url" class="frm_input w400">
          </td>
        </tr>
        <tr>
          <th scope="row" rowspan="2"><label for="">발송대상</label></th>
          <td>
            <div class="push_mb_select_wr">
              <span class="sb-text">그룹별선택</span>
              <select name="" id="push_mb_select1" class="push_mb_select">
                <option value="">==지회선택==</option>
                <option value="region2_all">전체지회</option>
                <option value="region2_1">외식가족공제회</option>
                <option value="region2_2">부산광역시지회</option>
                <option value="region2_3">대전광역시지회</option>
              </select>
              <select name="" id="push_mb_select2" class="push_mb_select">
                <option value="">==지부선택==</option>
                <option value="region3_all">전체지부</option>
                <option value="region3_1">대전동구지부</option>
                <option value="region3_2">대전중구지부</option>
                <option value="region3_3">대전서구지부</option>
                <option value="region3_4">대전유성구지부</option>
                <option value="region3_5">대전대덕구지부</option>
              </select>
              <select name="" id="push_mb_select3" class="push_mb_select">
                <option value="">==등급선택==</option>
                <option value="grade_all">전체회원</option>
                <option value="grade_1">일반회원</option>
                <option value="grade_2">중앙회원</option>
                <option value="grade_3">임직원 회원</option>
              </select>
              <button type="button" id="push_mb_btn" class="btn_small disabled" disabled onclick="pushSelectedApply('group');">적용하기</button>
            </div>
            <div class="push_mb_select_wr mt">
              <span class="sb-text">개별선택</span>
              <button type="button" id="push_mbSch_btn" class="btn_small" onclick="pushSchPopOpen();">회원선택</button>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="selected_mb_wr">
              <!-- loop { 
              <div class="selected_mb">
                <span class="txt">대전광역시지회 > 대전서구지부 > 임직원 회원</span>
                <button type="button" class="btn_small mgr5"></button>
              </div>
              loop -->
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

<div id="pushSchMbPop">
  <div class="pop_wrap">
    <div class="pop_top">
      <p class="pop_tit">회원 선택</p>
      <button type="button" class="pop_close" title="닫기" onclick="pushSchPopClose();"></button>
    </div>
    <div class="pop_con">
      <div class="pushSchMbForm">
        <select name="" id="" class="pushSchMb_sel" title="검색구분">
          <option value="" selected>회원명</option>
        </select>
        <input type="text" name="" id="" class="pushSchMb_keyword" title="검색어">
        <button type="button" class="pushSchMb_submit" title="검색"></button>
      </div>
      <div class="pushSchMbView">
        <p class="pushSchMbView_txt">선택된 회원 (<em>00</em>)</p>
        <div class="pushSchMbView_inner">
          <div class="lev_datas">
            <ul class="lev lev1">
              <!-- loop { -->
              <li>
                <div class="lev_box">
                  <input type="checkbox" name="" id="id001" value="001" class="lev_chk">
                  <label for="id001" class="lev_con">대전광역시지회 > 대전동구지부 > 홍길동</label>
                </div>
              </li>
              <!-- } loop -->
              <li>
                <div class="lev_box">
                  <input type="checkbox" name="" id="id002" value="002" class="lev_chk">
                  <label for="id002" class="lev_con">대전광역시지회 > 대전서구지부 > 김철수</label>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="pushSchMbBtn_wr">
        <button type="button" class="pushSchMbBtn close" onclick="pushSchPopClose();">닫기</button>
        <button type="button" class="pushSchMbBtn open" onclick="pushSchPopClose();">확인</button>
        <!-- <button type="button" class="pushSchMbBtn open" onclick="pushSelectedApply('member');">확인</button> -->
      </div>
    </div>
  </div>
</div>

<script>
  const $pushMbSelect = $(".push_mb_select"); //[그룹별선택]발송대상 모든 select
  const $pushMbSelect1 = $("#push_mb_select1"); //[그룹별선택]발송대상 지회
  const $pushMbSelect2 = $("#push_mb_select2"); //[그룹별선택]발송대상 지부
  const $pushMbSelect3 = $("#push_mb_select3"); //[그룹별선택]발송대상 등급
  const $pushMbSelectBtn = $("#push_mb_btn"); //[그룹별선택]발송대상 적용버튼
  const $pushMbSelectChk = $(".lev_chk"); //[그룹별선택]발송대상 적용버튼

  const $pushSchPop = $("#pushSchMbPop"); //[개별선텍]회원선택 팝업

  const $pushSelectedArea = $(".selected_mb_wr"); //선택된 발송대상 영역

  let selectedMember = []; //[개별선택]선택된 회원

  const groupName = "group_code";
  const memberName = "member_code";

  //[그룹별선택]초기화
  function groupSelInit() {
    $pushMbSelect.each(function() {
      $(this).find('option:first').prop('selected', true);
    });
    $pushMbSelectBtn.attr('disabled',true).addClass('disabled');
  }

  //[개별선택]초기화
  function memberSelInit() {
    $(`input[name^=${memberName}]`).closest('.selected_mb').remove();
    selectedMember = [];
  }

  //[그룹별선택]빈값여부
  function checkPushMbSelects() {
    if ($pushMbSelect1.val() !== '' && $pushMbSelect2.val() !== '' && $pushMbSelect3.val() !== '') {
      $pushMbSelectBtn.attr('disabled',false).removeClass('disabled');
    } else {
      $pushMbSelectBtn.attr('disabled',true).addClass('disabled');
    }
  }

  //[개별선택]회원선택 팝업 열기/닫기
  function pushSchPopOpen() {
    $pushSchPop.fadeIn(200);
  }

  function pushSchPopClose() {
    $pushSchPop.hide();
  }

  /**
   * [그룹별선택/개별선택]적용하기 랜더링
   */
  function pushSelectedRender(type, txt, code, selid) {
    let pushSelectedHtml = "";
    let inputName = "";
    let btnId = "";

    if(type == 'group') {
      inputName = String(groupName+'[]');
      btnId = "gp_"+selid;
    } else if(type == 'member') {
      inputName = String(memberName+'[]');
      btnId = selid;
    }
    
    pushSelectedHtml += `
      <div id="${btnId}" class="selected_mb ${type}">
        <span class="txt">${txt}</span>
        <button type="button" class="btn_small mgr5" onclick="pushSelectedDelete('${type}' ,'${btnId}')"></button>
        <input type="hidden" name="${inputName}" value="${code}">
      </div>
    `;

    $pushSelectedArea.append(pushSelectedHtml);
  }

  /** [그룹별선택/개별선택]적용하기
   * type (string) : group, member
   */
  function pushSelectedApply(type) {
    if(type == 'group') {
      let codeArray = [];
      let selectedTextArray = [];
      let selectedId = "";
      
      $pushMbSelect.each(function() {
        codeArray.push($(this).find('option:selected').val());
        selectedTextArray.push($(this).find('option:selected').text());
        selectedId += $(this).find('option:selected').index();
      });

      let code = codeArray.join("|");
      let selectedText = selectedTextArray.join(" > ");

      groupSelInit();

      pushSelectedRender(type, selectedText, code, selectedId);
    } else if(type == 'member') {
      // memberSelInit();

      // $(".lev_chk:checked").map(function() {
      //   let code = $(this).val();
      //   let selectedText = $(this).siblings('.lev_con').text();

      //   if(!selectedMember.includes(code)) {
      //     selectedMember.push(code);
      //     pushSelectedRender(type, selectedText, code);
      //   }
      // });
      
      // pushSchPopClose();
    }
  }

  function pushSelectedDelete(type, id) {
    $(`.selected_mb_wr #${id}`).remove();
    console.log(type, id);
    if(type == 'member') {
      $("input[type=checkbox][id='" + id + "']").prop('checked', false);
    }
  }

  $(document).ready(function(){
    $pushMbSelect.on('change', checkPushMbSelects);
    $pushMbSelectChk.on('change', function() {
      let code = $(this).val();
      let selId = $(this).attr("id");

      if ($(this).is(':checked')) {
        let selectedText = $(this).siblings('.lev_con').text();

        if(!selectedMember.includes(code)) {
          selectedMember.push(code);
          pushSelectedRender('member', selectedText, code, selId);
        }
      } else {
        selectedMember = selectedMember.filter(function(item) {
          return item !== code;
        });

        $(`#${code}`).closest('.selected_mb').remove();
      }
    });

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

    //발송시간(tm)
    const $pushTmRadio = $("input[name='push_tm']"); //발송시간 라디오 버튼(tm1)(name값)
    let pushTmRadio_val = ""; //발송시간 라디오 버튼의 선택값(tm2)(초기화)

    $pushTmRadio.on('change', function(){
      pushTmRadio_val = $(this).val(); //(tm2)(할당)

      if(pushTmRadio_val == 0) { //(tm2)(0)즉시발송
        $("#resv_date").attr('disabled', true).addClass('disabled');
      } else if(pushTmRadio_val == 1) { //(tm2)(1)예약발송
        $("#resv_date").attr('disabled', false).removeClass('disabled').focus();
      }
    });
  });

  //폼 전송
  function fpushform_submit(f)
  { 
    //예외처리 필요

    return true;
  }
</script>