<?php
if (!defined('_BLUEVATION_')) exit;

// 업종 분류 _20240611_SY
$cf_food = explode("|", $config['cf_food']);
$none = "style='display:none;'";
?>

<script src="<?php echo BV_JS_URL; ?>/jquery.register_form.js"></script>

<form name="fregisterform" id="fregisterform" action="./member/member_register_form_update.php" onsubmit="return fregisterform_submit(this);" method="post" autocomplete="off" enctype="MULTIPART/FORM-DATA">
  <input type="hidden" name="token" value="">

  <h5 class="htag_title">사이트 이용정보 입력</h5>
  <div class="board_table mart20">
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row"><label for="reg_mb_id">아이디</label></th>
          <td>
            <input type="text" name="mb_id" id="reg_mb_id" required class="frm_input required w400" size="20" maxlength="20">
            <span id="msg_mb_id"></span>
            <?php echo help('영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.'); ?>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_password">비밀번호</label></th>
          <td>
            <input type="password" name="mb_password" id="reg_mb_password" required class="frm_input required w400 marr10" size="20" maxlength="20">
            <?php echo help('4자 이상의 영문 및 숫자'); ?>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_password_re">비밀번호 확인</label></th>
          <td><input type="password" name="mb_password_re" id="reg_mb_password_re" required class="frm_input required w400" size="20" maxlength="20"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <p class="gap70"></p>
  <h5 class="htag_title">개인정보 입력</h5>
  <div class="board_table mart20">
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row"><label for="reg_mb_name">이름(실명)</label></th>
          <td><input type="text" name="mb_name" id="reg_mb_name" required class="frm_input required w400" size="20"></td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_tel">전화번호</label></th>
          <td><input type="text" name="mb_tel" id="reg_mb_tel" class="frm_input w400" size="20" maxlength="20"></td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_hp">휴대폰번호</label></th>
          <td>
            <input type="text" name="mb_hp" id="reg_mb_hp" class="frm_input w400" size="20" maxlength="20">
            <div class="checks mart10">
              <label><input type="checkbox" name="mb_sms" value="Y" checked="checked"> 휴대폰 문자메세지를 받겠습니다.</label>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_email">E-mail</label></th>
          <td>
            <input type="text" name="mb_email" id="reg_mb_email" required class="frm_input required w400" size="40" maxlength="100">
            <div class="checks mart10">
              <label><input type="checkbox" name="mb_mailling" value="Y" id="reg_mb_mailling" checked="checked"> 정보 메일을 받겠습니다.</label>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">본인확인방법</th>
          <td>
            <ul class="radio_group">
              <li class="radios">
                <input type="radio" name="mb_certify_case" value="ipin" id="mb_certify_ipin">
                <label for="mb_certify_ipin">아이핀</label>
              </li>
              <li class="radios">
                <input type="radio" name="mb_certify_case" value="hp" id="mb_certify_hp" checked="checked">
                <label for="mb_certify_hp">휴대폰</label>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row">본인확인</th>
          <td>
            <ul class="radio_group">
              <li class="radios">
                <input type="radio" name="mb_certify" value="1" id="mb_certify_yes">
                <label for="mb_certify_yes">예</label>
              </li>
              <li class="radios">
                <input type="radio" name="mb_certify" value="" id="mb_certify_no" checked="checked">
                <label for="mb_certify_no">아니오</label>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row">성인인증</th>
          <td>
            <ul class="radio_group">
              <li class="radios">
                <input type="radio" name="mb_adult" value="1" id="mb_adult_yes">
                <label for="mb_adult_yes">예</label>
              </li>
              <li class="radios">
                <input type="radio" name="mb_adult" value="0" id="mb_adult_no" checked="checked">
                <label for="mb_adult_no">아니오</label>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row">레벨</th>
          <td>
            <div class="chk_select">
              <?php echo get_member_select("mb_grade", $mb['grade']); ?>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">주소</th>
          <td>
            <div class="write_address">
              <div class="file_wrap address">
                <label for="reg_mb_zip" class="sound_only">우편번호</label>
                <input type="text" name="mb_zip" id="reg_mb_zip" class="frm_input" size="8" maxlength="5" placeholder="우편번호">
                <button type="button" class="btn_file" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button>
              </div>
              <div class="">
                <input type="text" name="mb_addr1" id="reg_mb_addr1" class="frm_input frm_address" size="60" placeholder="기본주소">
                <label for="reg_mb_addr1" class="hide">기본주소</label>
                <input type="text" name="mb_addr2" id="reg_mb_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                <label for="reg_mb_addr2" class="hide">상세주소</label>
                <input type="hidden" name="mb_addr_jibeon" value="">
                <input type="text" name="mb_addr3" id="reg_mb_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                <label for="reg_mb_addr3" class="hide">참고항목</label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mb_recommend">추천인</label></th>
          <td><input type="text" name="mb_recommend" value="admin" id="reg_mb_recommend" required class="frm_input required w400"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- 사업자회원조회 _20240611_SY -->
  <p class="gap70 store_info" <?php echo $none?> ></p>
  <h5 class="htag_title store_info"  <?php echo $none?> >사업자 회원 조회</h5>
  <div class="board_table mart20 store_info"  <?php echo $none?> >
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row"><label for="ju_b_num">사업자등록번호</label></th>
          <td>
            <input type="text" name="ju_b_num" id="b_no" class="frm_input" maxlength="10" placeholder="숫자만 입력" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <input type="hidden" name="chk_b_num" id="chk_b_num" value="0" alt="사업자여부">
            <input type="hidden" name="chk_cb_res" id="chk_cb_res" value="0" alt="휴/폐업조회">
            <div class="joinDetail-btn-box joinDetail-btn-box3"> 
              <button type="button" class="ui-btn st3" onclick="getKFIAMember()">중앙회 회원 조회</button>
              <button type="button" class="ui-btn st3" onclick="chkDuBnum()">중복확인</button>
              <button type="button" class="ui-btn st3" onclick="chkClosed()">휴/폐업조회</button>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="ju_restaurant">상호명</label></th>
          <td><input type="text" name="ju_restaurant" id="ju_restaurant" class="frm_input required" size="20"></td>
        </tr>
        <tr>
          <th scope="row"><label for="ju_member">대표자명</label></th>
          <td><input type="text" name="ju_member" id="ju_member" class="frm_input" size="20" maxlength="20"></td>
        </tr>
        <tr>
          <th scope="row"><label for="ju_tel">대표번호</label></th>
          <td>
            <input type="text" name="ju_tel" id="ju_tel" class="frm_input" size="20" maxlength="20">
          </td>
        </tr>
        
      </tbody>
    </table>
  </div>

  
  <!-- 매장정보 _20240611_SY -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#work1, #work2, #break1, #break2').timepicker({
        timeFormat: 'HH:mm',
        interval: 10,
        minTime: '00:00',
        maxTime: '23:50',
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
      });
    });
  </script>
  <p class="gap70 store_info_sec"  <?php echo $none?> ></p>
  <h5 class="htag_title store_info_sec"  <?php echo $none?> >매장 정보</h5>
  <div class="board_table mart20 store_info_sec"  <?php echo $none?> >
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">매장 노출 여부</th>
          <td>
            <ul class="radio_group">
              <li class="radios">
                <input type="radio" name="ju_mem" value="1" id="ju_mem_y" checked="checked">
                <label for="ju_mem_y">예</label>
              </li>
              <li class="radios">
                <input type="radio" name="ju_mem" value="2" id="ju_mem_n">
                <label for="ju_mem_n">아니오</label>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="">업종</label></th>
          <td>
            <div class="chk_select">
              <select name="ju_cate" id="ju_cate">
                  <?php foreach($cf_food as $key => $val) { ?> 
                    <option value="<?php echo $val ?>"><?php echo $val ?></option>
                  <?php } ?>
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">매장 외부 사진<br>(jpg, gif, png)</th>
          <td colspan="3">
            <div class="file_wrap">
              <input type="file" name="ju_mimg">
              <?php if ($mb['ju_mimg']) {
                echo '<img src="' . BV_DATA_URL . '/member/' . $mb['ju_mimg'] . '" class="w90p">';
              } ?>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">매장 내부 사진<br>(jpg, gif, png)</th>
          <td colspan="3">
            <ul class="file_wrap">
              <?php
              $sub_imgs = explode("|", $mb['ju_simg']);
              $sub_imgs = array_filter($sub_imgs);
              $sub_imgs = array_values($sub_imgs);
              for ($i = 0; $i < 5; $i++) {
                echo '<li><input type="file" name="ju_simg[]">';
                if ($sub_imgs[$i]) {
                  echo '<div class="img_container"><img src="' . BV_DATA_URL . '/member/' . $sub_imgs[$i] . '" class="w90p"> &nbsp; <span class="image_del curp fs18" data-img_name="' . $sub_imgs[$i] . '">X</span></a>';
                }
                echo '</li>';
              }

              //운영시간/브레이크타임/휴무일
              $works = explode("~", $mb['ju_worktime']);
              $breaks = explode("~", $mb['ju_breaktime']);
              $offs = explode("|", $mb['ju_off']);
              $yoils = ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'];
              ?>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row">운영시간</th>
          <td>
            <div class="write_address">
              <div class="addressMore">
                <input type="text" class="frm_input" name="worktime[]" id="work1" value="<?php echo $works[0] ?>">
                <p class="line marr10 marl10">~</p>
                <input type="text" class="frm_input" name="worktime[]" id="work2" value="<?php echo $works[1] ?>">
              </div>
            </div>
          </td>
          </tr>
          <tr>
          <th scope="row">브레이크타임</th>
          <td>
            <div class="write_address">
              <div class="addressMore">
                <input type="text" class="frm_input" name="breaktime[]" id="break1" value="<?php echo $breaks[0] ?>">
                <p class="line marr10 marl10">~</p>
                <input type="text" class="frm_input" name="breaktime[]" id="break2" value="<?php echo $breaks[1] ?>">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">휴무일</th>
          <td colspan="3">
            <ul class="checks">
              <?php
              foreach ($yoils as $k => $v) {
                if (in_array($v, $offs)) {
                  echo '<li><input type="checkbox" name="off[]" id="off' . $k . '" value="' . $v . '" checked><label for="off' . $k . '">' . $v . '</label></li>';
                } else {
                  echo '<li><input type="checkbox" name="off[]" id="off' . $k . '" value="' . $v . '"><label for="off' . $k . '">' . $v . '</label></li>';
                }
              }
              ?>
            </ul>
          </td>
        </tr>
        <tr>
          <th scope="row">주소</th>
          <td>
            <div class="write_address">
              <div class="file_wrap address">
                <label for="reg_mb_zip_st" class="sound_only">우편번호</label>
                <input type="text" name="mb_zip_st" id="reg_mb_zip_st" class="frm_input" size="8" maxlength="5" placeholder="우편번호">
                <button type="button" class="btn_file" onclick="win_zip('fregisterform', 'mb_zip_st', 'mb_addr1_st', 'mb_addr2_st', 'mb_addr3_st', 'mb_addr_jibeon_st');">주소검색</button>
              </div>
              <div class="">
                <input type="text" name="mb_addr1_st" id="reg_mb_addr1_st" class="frm_input frm_address" size="60" placeholder="기본주소">
                <label for="reg_mb_addr1_st" class="hide">기본주소</label>
                <input type="text" name="mb_addr2_st" id="reg_mb_addr2_st" class="frm_input frm_address" size="60" placeholder="상세주소">
                <label for="reg_mb_addr2_st" class="hide">상세주소</label>
                <input type="hidden" name="mb_addr_jibeon_st" value="">
                <input type="text" name="mb_addr3_st" id="reg_mb_addr3_st" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                <label for="reg_mb_addr3_st" class="hide">참고항목</label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">매장 설명</th>
          <td colspan="3"><textarea name="ju_content" class="frm_textbox" rows="3"><?php echo $mb['ju_content']; ?></textarea></td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- 담당자 정보 추가 _20240618_SY -->
  <?php if($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") { 
    $mn_sel = " SELECT * FROM shop_manager WHERE id = '{$_SESSION['ss_mn_id']}'";
    $mn_row = sql_fetch($mn_sel);
    $office_where = " WHERE a.office_code = '{$mn_row['ju_region3']}' ";
    $office_data = getRegionFunc("office", $office_where);
    $ju_region1 = $office_data[0]['areacode'];
    $ju_region2 = $office_data[0]['branch_code'];
    $ju_region3 = $office_data[0]['office_code'];
  ?>
  <p class="gap70"></p>
  <h5 class="htag_title">담당직원 정보</h5>
  <div class="board_table mart20">
    <table>
      <colgroup>
      <col class="w180">
      <col>
    </colgroup>
    <tbody>
      <tr>
        <th scope="row"><label for="reg_mn_id">아이디</label></th>
        <td>
          <input type="text" name="mn_id" id="reg_mn_id" value="<?php echo $mn_row['id']; ?>" class="frm_input w400" size="20" maxlength="20" readonly>
        </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mn_name">이름</label></th>
          <td>
            <input type="text" name="mn_name" id="reg_mn_name" value="<?php echo $mn_row['name'] ?>" class="frm_input w400" size="20" maxlength="20" readonly>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="reg_mn_name">지회/지부</label></th>
          <td>
            <input type="text" name="" id="" value="<?php echo $office_data[0]['branch_name']." / ".$office_data[0]['office_name'] ?>" class="frm_input w400" size="20" maxlength="20" readonly>
          </td>
        </tr>
        <input type="hidden" name="ju_manager" value="<?php echo $mn_row['index_no']; ?>" class="frm_input w400" size="20" maxlength="20">
        <input type="hidden" name="ju_region1" value="<?php echo $ju_region1; ?>" class="frm_input w400" size="20" maxlength="20">
        <input type="hidden" name="ju_region2" value="<?php echo $ju_region2; ?>" class="frm_input w400" size="20" maxlength="20">
        <input type="hidden" name="ju_region3" value="<?php echo $ju_region3; ?>" class="frm_input w400" size="20" maxlength="20">
        
      </tbody>
    </table>
  </div>
  <?php } ?>

  <div class="board_btns tac mart20">
    <div class="btn_wrap">
      <input type="submit" value="저장" id="btn_submit" class="btn_acc" accesskey="s">
    </div>
  </div>

</form>

<!-- 주소값 (위도/경도) 가져오기 _20240612_SY -->
<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<?php echo BV_POSTCODE_JS ?>

<script>
  // form 추가 _20240612_SY
  const form = $('#fregisterform');

  $('#mb_grade').click(function() {

    let chk_value = this.value;
    if (chk_value == '8') {
      $('.store_info').show();
    } else {
      $('.store_info').hide();
    }
  })

  $(document).ready(function() {
    $('#ju_region2').change(function() {
      var depth2 = $(this).val(); // 선택된 값 가져오기

      // Ajax 요청 보내기
      $.ajax({
        url: '/admin/ajax.gruopdepth.php', // 데이터를 처리할 서버 측 파일의 경로
        type: 'POST', // 요청 방식 (POST 또는 GET)
        data: {
          depthNum: '2',
          depthValue: depth2
        }, // 서버로 전송할 데이터
        success: function(res) {
          // var reg = JSON.parse(res); // JSON 형식의 응답을 JavaScript 객체로 파싱

          var ju_region3 = $("#ju_region3");
          ju_region3.empty(); // 기존 옵션 모두 제거

          var defaultOption = $('<option>'); // 새로운 옵션 요소 생성
          defaultOption.val(""); // 옵션의 값 설정
          defaultOption.text("지부 선택"); // 옵션의 텍스트 설정
          ju_region3.append(defaultOption); // ju_region3에 옵션 추가

          for (var i = 0; i < reg.length; i++) {
            var option = $('<option>'); // 새로운 옵션 요소 생성
            option.val(reg[i].region); // 옵션의 값 설정
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


  

  
  // 외식업중앙회원 조회하기 _20240611_SY
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
          if(res.data == null) {
            alert('사업자 정보 조회 실패')

            $('.store_info_sec').hide();
            $('#ju_restaurant').val('');
            $('#reg_mb_zip_st').val('');
            $('#reg_mb_addr1_st').val('');
            $('#chk_b_num').val('0');

            chkKFIA = false;
            return false;
          } else {
            alert(`조회 성공 : ${res.data.MEMBER_NAME}`)

            $('.store_info_sec').show();
            $('#ju_restaurant').val(res.data.MEMBER_NAME)
            $('#reg_mb_zip_st').val(res.data.ZIP_CODE)
            $('#reg_mb_addr1_st').val(res.data.DORO_ADDRESS)
            $('#chk_b_num').val('1');

            // 위도/경도 값 _20240612_SY
            var geocoder = new kakao.maps.services.Geocoder();
            var address = res.data.DORO_ADDRESS;
            address = address.trim();
            geocoder.addressSearch(address, function(result, status) {
              // 정상적으로 검색이 완료됐으면 
              if (status === kakao.maps.services.Status.OK) {
                //var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                form.append(`<input type="hidden" name="ju_lat" value="${result[0].y}">`);
                form.append(`<input type="hidden" name="ju_lng" value="${result[0].x}">`);
              } 
            });
            
            chkKFIA = true;
          }
        }
      });
    } else {
      return false;
    }

  }


  // 사업자번호 중복체크 _20240611_SY
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
              alert("이미 등록된 사업자등록번호입니다");
              $('#chk_b_num').val('0');
              $('.store_info_sec').hide();
              
              return false;
            } else {
              alert("가입 가능한 사업자등록번호입니다");
              if(chkKFIA == true) {
                $('#chk_b_num').val('1');
              }
            }
          }
      });
    } else {
      alert("사업자등록번호가 존재하지 않습니다.")
      return false;
    }
  }


  // 휴/폐업 조회 _20240611_SY
  let b_num = '';
  function chkClosed() {
    b_num = document.querySelector('#b_no').value;

    let b_stt_cd = "";
    let end_dt   = "";
    let msg = "";

    if(b_num.length > 0) {
      $.ajax({
          url: bv_url+"/m/bbs/ajax.closed_check.php",
          type: "POST",
          data: { "b_num" : b_num },
          dataType: "JSON",
          success: function(res) {
            // API 값 호출 _20240318_SY
            // 휴/폐업 가입불가 _20240612_SY
            if (res.hasOwnProperty('match_cnt') && res.data[0].b_stt_cd == '01') {
              $('#chk_cb_res').val(res.data[0].b_stt_cd);
              if(chkKFIA == true) {
                $('#chk_b_num').val('1');
              }
              msg = res.data[0].b_stt;
              alert(msg);
            } else {
              switch (res.data[0].b_stt_cd) {
              case "" :
                msg = res.data[0].tax_type;
                $('#chk_cb_res').val('0');
                break;
                default : 
                $('#chk_cb_res').val(res.data[0].b_stt_cd);
                msg = res.data[0].b_stt;
                break;
            }
              $('#chk_b_num').val('0');
              $('.store_info_sec').hide();
              alert(msg);
            }
          }
      });
    } else {
      alert("사업자등록번호가 존재하지 않습니다.")
      return false;
    }
  }



  function fregisterform_submit(f) {
    // 회원아이디 검사
    var msg = reg_mb_id_check();
    if (msg) {
      alert(msg);
      f.mb_id.select();
      return false;
    }

    if (f.mb_password.value.length < 4) {
      alert("비밀번호를 4글자 이상 입력하십시오.");
      f.mb_password.focus();
      return false;
    }

    if (f.mb_password.value != f.mb_password_re.value) {
      alert("비밀번호가 같지 않습니다.");
      f.mb_password_re.focus();
      return false;
    }

    if (f.mb_password.value.length > 0) {
      if (f.mb_password_re.value.length < 4) {
        alert("비밀번호를 4글자 이상 입력하십시오.");
        f.mb_password_re.focus();
        return false;
      }
    }

    // 이름 검사
    if (f.mb_name.value.length < 1) {
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

    // E-mail 검사
    var msg = reg_mb_email_check();
    if (msg) {
      alert(msg);
      f.reg_mb_email.select();
      return false;
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
      if (f.mb_id.value == f.mb_recommend.value) {
        alert("본인을 추천할 수 없습니다.");
        f.mb_recommend.focus();
        return false;
      }

      var msg = reg_mb_recommend_check();
      if (msg) {
        alert(msg);
        f.mb_recommend.select();
        return false;
      }
    }

    // 휴/폐업 중앙회 가입 불가 _20240612_SY
    if (f.mb_grade.value == 8) {
      if(f.chk_b_num.value == 0) {
        alert("레벨을 변경하여 가입해 주십시오.");
        f.mb_grade.focus();
        return false;
      }
    }

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
  }


</script>