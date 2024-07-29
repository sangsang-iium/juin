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
            <input type="text" name="push_subject" id="push_subject" class="frm_input w400">
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_contents">내용</label></th>
          <td>
            <textarea name="push_contents" id="push_contents" class="frm_input"></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_img">이미지 첨부</label></th>
          <td>
            <input type="file" name="push_img" id="push_img">
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="push_url">링크 URL</label></th>
          <td>
            <input type="text" name="push_url" id="push_url" class="frm_input w400">
          </td>
        </tr>
        <tr>
          <th scope="row" rowspan="2"><label for="">발송대상</label></th>
          <td>
            <div class="push_mb_select_wr">
              <span class="sb-text">그룹별선택</span>
              <select name="push_region2" id="push_mb_select1" class="push_mb_select">
                <option value="">==지회선택==</option>
                <!-- <option value="none">소속없음</option> -->
                <?php $depth1 = juinGroupInfo(1);
                  for ($d = 0; $d < count($depth1); $d++) { ?>
                    <option value="<?php echo $depth1[$d]['code'] ?>" <?php echo $mb['ju_region2'] == $depth1[$d]['code'] ? "selected" : "" ?>><?php echo $depth1[$d]['region'] ?></option>
                <?php } ?>
              </select>
              <select name="push_region3" id="push_mb_select2" class="push_mb_select">
                <option value="">==지부선택==</option>
                <?php $depth1 = juinGroupInfo(4, $mb['ju_region2']);
                  for ($d = 0; $d < count($depth1); $d++) { ?>
                    <option value="<?php echo $depth1[$d]['code'] ?>" <?php echo $mb['ju_region3'] == $depth1[$d]['code'] ? "selected" : "" ?>><?php echo $depth1[$d]['region'] ?></option>
                <?php } ?>
              </select>
              <select name="push_grade" id="push_mb_select3" class="push_mb_select">
                <option value="">==등급선택==</option>
                <?php echo getLevelCustomFunc(); ?>
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

<!-- 회원선택 팝업 -->
<div id="pushSchMbPop">
  <div class="pop_wrap">
    <div class="pop_top">
      <p class="pop_tit">회원 선택</p>
      <button type="button" class="pop_close" title="닫기" onclick="pushSchPopClose();"></button>
    </div>
    <div class="pop_con">
      <div class="pushSchMbForm">
        <select name="" id="search_keywords" class="pushSchMb_sel" title="검색구분">
          <option value="key_name" selected>회원명</option>
          <!-- <option value="key_id" >아이디</option> -->
        </select>
        <input type="text" name="" id="pushSearch_wrods" class="pushSchMb_keyword" title="검색어">
        <button type="button" class="pushSchMb_submit" onclick="searchMember()" title="검색"></button>
      </div>
      <div class="pushSchMbView">
        <p class="pushSchMbView_txt">검색된 회원 (<em id="search_cnt">00</em>)</p>
        <div class="pushSchMbView_inner">
          <div class="lev_datas">
            <ul class="lev lev1" id="pushSearch_result">
              <!-- loop { -->
              <li>
                <div class="lev_box">
                  회원을 검색하여 주십시오.
                  <!-- <input type="checkbox" name="" id="id001" value="001" class="lev_chk">
                  <label for="id001" class="lev_con">대전광역시지회 > 대전동구지부 > 홍길동</label> -->
                </div>
              </li>
              <!-- } loop -->
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
  const pushMbSelectChk = ".lev_chk"; //[그룹별선택]발송대상 적용버튼

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
    selectedMember = selectedMember.filter(function(item) {
      return item !== id;
    });

    $(`.selected_mb_wr #${id}`).remove();
    
    if(type == 'member') {
      $("input[type=checkbox][id='" + id + "']").prop('checked', false);
    }
  }


  // 회원 검색 _20240723_SY
  function searchMember() {
    let search_words = document.querySelector('#pushSearch_wrods').value;
    let search_resIn = document.querySelector('#pushSearch_result');
    let search_count = document.querySelector('#search_cnt');
    let search_key   = document.querySelector('#search_keywords').value;

    if(search_words.length > 0) {
      $.ajax({
        url: bv_url+"/admin/member/ajax.pushSearchMember.php",
        type: "POST",
        data: {
          "type" : search_key,
          "words" : search_words
        },
        dataType: "JSON",
        success: function(data) {
          console.log(data)
          search_count.innerHTML = data.res.length;

          let html      = '';
          let kfia_name = String
          let res_name  = String

          if(data.res.length > 0 ) {
            for(let i=0; i<data.res.length; i++) {
              
              if(data.res[i].ju_region2 == "" || data.res[i].ju_region2 == "") {
                kfia_name = "소속없음 > ";
              } else {
                kfia_name = `${data.res[i].branch_name} > ${data.res[i].office_name} > `;
              }
  
              res_name = `${data.res[i].name} (${data.res[i].id})`;
  
              html += `<li>`;
              html += `<div class="lev_box">`;
              html += `<input type="checkbox" name="" id="idx_${data.res[i].index_no}" value="${data.res[i].index_no}" class="lev_chk">`;
              html += `<label for="idx_${data.res[i].index_no}" class="lev_con">${kfia_name} ${res_name}</label>`;
              html += `</div>`;
              html += `</li>`;
            }
          } else {
            html += `<li>`;
            html += `<div class="">${data.msg}</div>`;
            html += `</li>`;
          }
          search_resIn.innerHTML = html;
        }
      });
    }
  }



  $(document).ready(function(){
    $pushMbSelect.on('change', checkPushMbSelects);
    $pushSchPop.on('change', pushMbSelectChk, function() {
      let code = $(this).val();
      let selId = $(this).attr("id");

      if ($(this).is(':checked')) {
        let selectedText = $(this).siblings('.lev_con').text();

        if(!selectedMember.includes(selId)) {
          selectedMember.push(selId);
          pushSelectedRender('member', selectedText, code, selId);
        }
      } else {
        selectedMember = selectedMember.filter(function(item) {
          return item !== selId;
        });

        $(`.selected_mb_wr #${selId}`).closest('.selected_mb').remove();
      }
      console.log(selectedMember);
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



    // 지부 SELECT BOX _20240723_SY
    $('#push_mb_select1').change(function() {
      var depth2 = $(this).val(); // 선택된 값 가져오기

      // Ajax 요청 보내기
      $.ajax({
        url: '/admin/ajax.gruopdepth.php', // 데이터를 처리할 서버 측 파일의 경로
        type: 'POST', // 요청 방식 (POST 또는 GET)
        data: {
          depthNum: '4',
          depthValue: depth2
        }, // 서버로 전송할 데이터
        success: function(res) {
          var reg = JSON.parse(res); // JSON 형식의 응답을 JavaScript 객체로 파싱

          var ju_region3 = $("#push_mb_select2");
          ju_region3.empty(); // 기존 옵션 모두 제거

          var defaultOption = $('<option>'); // 새로운 옵션 요소 생성
          defaultOption.val(""); // 옵션의 값 설정
          defaultOption.text("==지부선택=="); // 옵션의 텍스트 설정
          ju_region3.append(defaultOption); // ju_region3에 옵션 추가

          var allOption = $('<option>'); // 새로운 옵션 요소 생성
          allOption.val("all"); // 옵션의 값 설정
          allOption.text("전체"); // 옵션의 텍스트 설정
          ju_region3.append(allOption); // ju_region3에 옵션 추가

          for (var i = 0; i < reg.length; i++) {
            var option = $('<option>'); // 새로운 옵션 요소 생성
            option.val(reg[i].code); // 옵션의 값 설정
            option.text(reg[i].region); // 옵션의 텍스트 설정
            ju_region3.append(option); // ju_region3에 옵션 추가

            if (reg[i].region === '<?php echo $mb['ju_region3']; ?>') {
              option.prop('selected', true); // 선택 상태 설정
            }
          }
        },
        error: function(xhr, status, error) {
          console.log('요청 실패: ' + error);
        }
      });
    });
    
  });

  //폼 전송
  function fpushform_submit(f)
  { 
    //예외처리 필요

    return true;
  }
</script>