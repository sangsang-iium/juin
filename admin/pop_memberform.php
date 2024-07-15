<?php
define('_NEWWIN_', true);
include_once('./_common.php');
include_once('./_head.php');
include_once(BV_ADMIN_PATH . "/admin_access.php");

$tb['title'] = "회원정보수정";
include_once(BV_ADMIN_PATH . "/admin_head.php");

$mb = get_member($mb_id);
$pt = get_partner($mb_id);
$sl = get_seller($mb_id);

// 본인확인방법
switch ($mb['mb_certify']) {
  case 'hp':
    $mb_certify_case = '휴대폰';
    $mb_certify_val = 'hp';
    break;
  case 'ipin':
    $mb_certify_case = '아이핀';
    $mb_certify_val = 'ipin';
    break;
  case 'admin':
    $mb_certify_case = '관리자 수정';
    $mb_certify_val = 'admin';
    break;
  default:
    $mb_certify_case = '';
    $mb_certify_val = 'admin';
    break;
}

// 본인확인
$mb_certify_yes  =  $mb['mb_certify'] ? 'checked="checked"' : '';
$mb_certify_no  = !$mb['mb_certify'] ? 'checked="checked"' : '';

// 성인인증
$mb_adult_yes  =  $mb['mb_adult']   ? 'checked="checked"' : '';
$mb_adult_no  = !$mb['mb_adult']   ? 'checked="checked"' : '';

// function get_allDistrict($region, $val) {
//   $dist_sel = "SELECT {$region} FROM shop_member GROUP BY {$region} HAVING $region <> ''";
//   $dist_res = sql_query($dist_sel);

//   while($dist_row = sql_fetch_array($dist_res)) {
//     $selected=($val==$dist_row[$region])? "selected":"";
//     echo "<option value='". $dist_row[$region] ."'".$selected.">".$dist_row[$region]."</option>";
//   }
// }
?>

<form name="fmemberform" id="fmemberform" action="./pop_memberformupdate.php" method="post" enctype="MULTIPART/FORM-DATA">
  <input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">

  <div id="memberform_pop" class="new_win">
    <h1><?php echo $tb['title']; ?></h1>

    <section class="new_win_desc marb50">

      <?php echo mb_pg_anchor($mb_id); ?>
      <p class="gap30"></p>
      <h5 class="htag_title">기본정보</h5>
      <p class="gap20"></p>
      <div class="board_table">
        <table>
          <colgroup>
            <col class="w200">
            <col>
            <col class="w200">
            <col>
          </colgroup>
          <tbody>
            <tr>
              <th scope="row">회원명</th>
              <td>
                <input type="text" name="name" value="<?php echo $mb['name']; ?>" required itemname="회원명" class="frm_input required">
                <?php if ($mb['intercept_date']) { ?><strong class="fc_red">[차단된회원]</strong><?php } ?>
              </td>
              <th scope="row">아이디</th>
              <td><?php echo $mb['id']; ?></td>
            </tr>
            <tr>
              <th scope="row">비밀번호</th>
              <td><input type="text" name="passwd" value="" class="frm_input"></td>
              <!-- <th scope="row">추천인아이디</th>
              <td><input type="text" name="pt_id" value="<?php //echo $mb['pt_id']; ?>" required memberid itemname="추천인아이디" class="frm_input required"></td> -->
            </tr>
            <tr>
              <th scope="row">생년월일(8자)</th>
              <td><input type="text" name="mb_birth" value="<?php echo $mb['mb_birth']; ?>" class="frm_input" placeholder="예)19750101"></td>
              <th scope="row">E-Mail</th>
              <td><input type="text" name="email" value="<?php echo $mb['email']; ?>" email itemname="E-Mail" class="frm_input" size="30"></td>
            </tr>
            <tr>
              <th scope="row">전화번호</th>
              <td><input type="text" name="telephone" value="<?php echo $mb['telephone']; ?>" class="frm_input"></td>
              <th scope="row">휴대전화</th>
              <td><input type="text" name="cellphone" value="<?php echo $mb['cellphone']; ?>" class="frm_input"></td>
            </tr>
            <tr>
              <th scope="row">주소</th>
              <td colspan="3">
                <div class="write_address">
                  <div class="file_wrap address">
                    <input type="text" name="zip" value="<?php echo $mb['zip']; ?>" class="frm_input" size="8" maxlength="5">
                    <a href="javascript:win_zip('fmemberform', 'zip', 'addr1', 'addr2', 'addr3', 'addr_jibeon');" class="btn_file">주소검색</a>
                  </div>
                  <div class="addressMore">
                    <input type="text" name="addr1" value="<?php echo $mb['addr1']; ?>" class="frm_input frm_address" size="60">
                    <!-- <p class="mart5">기본주소</p> -->
                    <input type="text" name="addr2" value="<?php echo $mb['addr2']; ?>" class="frm_input frm_address" size="60">
                    <!-- <p class="mart5">상세주소</p> -->
                  </div>
                  <input type="text" name="addr3" value="<?php echo $mb['addr3']; ?>" class="frm_input frm_address" size="60">
                  <!-- <p class="mart5">참고항목 -->
                  <input type="hidden" name="addr_jibeon" value="<?php echo $mb['addr_jibeon']; ?>"></p>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">본인확인</th>
              <td>
                <ul class="radio_group">
                  <li class="radios">
                    <input type="radio" name="mb_certify" value="1" id="mb_certify_yes" <?php echo $mb_certify_yes; ?>>
                    <label for="mb_certify_yes">예</label>
                  </li>
                  <li class="radios">
                    <input type="radio" name="mb_certify" value="" id="mb_certify_no" <?php echo $mb_certify_no; ?>>
                    <label for="mb_certify_no">아니오</label>
                  </li>
                </ul>
              </td>
              <th scope="row">성별</th>
              <td>
                <ul class="radio_group">
                  <li class="radios">
                    <input type="radio" name="gender" value="M" id="gender1" <?php echo get_checked($mb['gender'], 'M'); ?>>
                    <label for="gender1">남자</label>
                  </li>
                  <li class="radios">
                    <input type="radio" name="gender" value="F" id="gender2" <?php echo get_checked($mb['gender'], 'F'); ?>>
                    <label for="gender2">여자</label>
                  </li>
                </ul>
              </td>
            </tr>
            <!-- 본인확인방법 / 성인인증 없앰 _20240627_SY -->
            <!-- <tr>
              <th scope="row">본인확인방법</th>
              <td>
                <ul class="radio_group">
                  <li class="radios">
                    <input type="radio" name="mb_certify_case" value="ipin" id="mb_certify_ipin" <?php if ($mb['mb_certify'] == 'ipin') echo 'checked="checked"'; ?>>
                    <label for="mb_certify_ipin">아이핀</label>
                  </li>
                  <li class="radios">
                    <input type="radio" name="mb_certify_case" value="hp" id="mb_certify_hp" <?php if ($mb['mb_certify'] == 'hp') echo 'checked="checked"'; ?>>
                    <label for="mb_certify_hp">휴대폰</label>
                  </li>
                </ul>
              </td>
              <th scope="row">성인인증</th>
              <td>
                <ul class="radio_group">
                  <li class="radios">
                    <input type="radio" name="mb_adult" value="1" id="mb_adult_yes" <?php echo $mb_adult_yes; ?>>
                    <label for="mb_adult_yes">예</label>
                  </li>
                  <li class="radios">
                    <input type="radio" name="mb_adult" value="0" id="mb_adult_no" <?php echo $mb_adult_no; ?>>
                    <label for="mb_adult_no">아니오</label>
                  </li>
                </ul>
              </td>
            </tr> -->
            <tr>
              <th scope="row">레벨</th>
              <td>
                <div class="chk_select">
                  <?php echo get_member_select("mb_grade", $mb['grade']); ?>
                </div>
              </td>
              <th scope="row">포인트</th>
              <td>
                <b><?php echo number_format($mb['point']); ?></b> Point
                <a href="<?php echo BV_ADMIN_URL; ?>/member/member_point_req.php?mb_id=<?php echo $mb_id; ?>" onclick="win_open(this,'pop_point_req','600','500','yes');return false;" class="btn_small grey marl10 fs14">강제적립</a>
              </td>
            </tr>
            <!-- 담당자 정보 추가 _20240621_SY -->
            <?php
              $mn_sel = " SELECT * FROM shop_manager WHERE index_no = '{$mb['ju_manager']}' ";
              $mn_row = sql_fetch($mn_sel);
            ?>
            <tr class="kfia_info">
              <th scope="row">담당직원</th>
              <td>
                <input type="text" name="mn_name" id="mn_name" value="<?php echo $mn_row['name']; ?>" class="frm_input w200" readonly>
                <input type="hidden" name="mn_idx" id="mn_idx" value="<?php echo $mn_row['index_no']; ?>">
                <a href="<?php echo BV_ADMIN_URL; ?>/member/member_manager_list.php?mb_id=<?php echo $mb_id; ?>" onclick="win_open(this,'pop_manager_list','600','500','yes');return false;" class="btn_small grey marl10 fs14">담당직원 변경</a>
              </td>
            </tr>            
            
            <tr class="mb_adm_fld">
              <th scope="row">부운영자 접근허용</th>
              <td colspan="3">
                <div class="sub_frm02">
                  <table>
                    <tr>
                      <?php for ($i = 0; $i < 5; $i++) {
                        $k = ($i + 1); ?>
                        <td>
                          <input id="auth_<?php echo $k; ?>" type="checkbox" name="auth_<?php echo $k; ?>" value="1" <?php echo get_checked($mb['auth_' . $k], '1'); ?>>
                          <label for="auth_<?php echo $k; ?>"><?php echo $gw_auth[$i]; ?></label>
                        </td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <?php for ($i = 5; $i < 10; $i++) {
                        $k = ($i + 1); ?>
                        <td>
                          <input id="auth_<?php echo $k; ?>" type="checkbox" name="auth_<?php echo $k; ?>" value="1" <?php echo get_checked($mb['auth_' . $k], '1'); ?>>
                          <label for="auth_<?php echo $k; ?>"><?php echo $gw_auth[$i]; ?></label>
                        </td>
                      <?php } ?>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr class="pt_pay_fld">
              <th scope="row" class="th_bg fc_00f">PC 쇼핑몰스킨</th>
              <td>
                <?php echo get_theme_select('theme', $mb['theme']); ?>
              </td>
              <th scope="row" class="th_bg fc_00f">모바일 쇼핑몰스킨</th>
              <td>
                <?php echo get_mobile_theme_select('mobile_theme', $mb['mobile_theme']); ?>
              </td>
            </tr>
            <tr class="pt_pay_fld">
              <th scope="row" class="th_bg fc_00f">추가 판매수수료</th>
              <td>
                <input type="text" name="payment" value="<?php echo $mb['payment']; ?>" class="frm_input" size="10">
                <select name="payflag">
                  <?php echo option_selected('0', $mb['payflag'], '%'); ?>
                  <?php echo option_selected('1', $mb['payflag'], '원'); ?>
                </select>
                <?php echo help('판매수수료를 개별적으로 추가적립 하실 수 있습니다.'); ?>
              </td>
              <th scope="row" class="th_bg fc_00f">개별 도메인</th>
              <td>
                <span class="sitecode">www.</span><input type="text" name="homepage" value="<?php echo $mb['homepage']; ?>" class="frm_input" placeholder="Ex) sample.com">
                <?php echo help('단독서버인경우만 입력하세요. (포워딩으로 설정된 도메인은 입력금지)'); ?>
              </td>
            </tr>
            <tr class="pt_pay_fld">
              <th scope="row" class="th_bg fc_00f">입금계좌</th>
              <td colspan="3">
                <input type="text" name="bank_name" value="<?php echo $pt['bank_name']; ?>" class="frm_input" placeholder="은행명">
                <input type="text" name="bank_account" value="<?php echo $pt['bank_account']; ?>" class="frm_input" placeholder="계좌번호" size="30">
                <input type="text" name="bank_holder" value="<?php echo $pt['bank_holder']; ?>" class="frm_input" placeholder="예금주명">
                <?php echo help('위 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.'); ?>
              </td>
            </tr>
            <!-- 정산일 추가 _20240402_SY -->
            <!-- <tr class="pt_pay_fld">
        <th scope="row" class="th_bg fc_00f">정산일</th>
        <td colspan="3">
          <input type="text" name="ju_settle" value="<?php //echo $sl['settle']
                                                      ?>" class="frm_input" placeholder="정산일">
          <?php //echo help('매달 입력하신 날짜에 수수료 정산하실 수 있습니다. 숫자만 입력해주세요. ex) 15(◯), 15일(X) 월요일(X)'); 
          ?>
        </td>
      </tr> -->
            <!-- <tr class="pt_pay_fld">
        <th scope="row" class="th_bg fc_00f">본사지정 권한</th>
        <td colspan="3">
          <input type="checkbox" name="use_pg" value="1" id="use_pg"<?php echo get_checked($mb['use_pg'], '1'); ?>> <label for="use_pg">개별 PG결제 허용</label>
          <input type="checkbox" name="use_good" value="1" id="use_good"<?php echo get_checked($mb['use_good'], '1'); ?>> <label for="use_good">개별 상품판매 허용</label>
        </td>
      </tr> -->
          </tbody>
        </table>
      </div>

      <script>
        $(document).ready(function() {
          $('#ju_region2').change(function() {
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

                var ju_region3 = $("#ju_region3");
                ju_region3.empty(); // 기존 옵션 모두 제거

                var defaultOption = $('<option>'); // 새로운 옵션 요소 생성
                defaultOption.val(""); // 옵션의 값 설정
                defaultOption.text("지부 선택"); // 옵션의 텍스트 설정
                ju_region3.append(defaultOption); // ju_region3에 옵션 추가

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
      </script>

      <!-- 사업장 주소, 사업자 대표 번호 정보 추가, 대표자 명, 대표 연락처 추가 20240416_SY -->
      <script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
      <?php echo BV_POSTCODE_JS ?>
      <script>
        // 주소-좌표 변환 객체를 생성합니다
        var geocoder = new kakao.maps.services.Geocoder();
        // 주소로 좌표를 검색합니다
        function getPosition() {
          var address = $("#ju_addr_full").val();
          address = address.trim();

          geocoder.addressSearch(address, function(result, status) {
            console.log(result)
            // 정상적으로 검색이 완료됐으면 
            if (status === kakao.maps.services.Status.OK) {
              //var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
              $("#ju_lat").val(result[0].y);
              $("#ju_lng").val(result[0].x);
            } else {
              alert("좌표를 확인할 수 없습니다. 주소를 확인해 주세요.");
            }
          });
        }

        function daumAddress(){
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }
                    
                    document.getElementById('ju_addr_full').value = addr;
                    //getPosition();
                }
            }).open();
        }

        /* 서브이미지 삭제 */
        const mb_id = "<?php echo $mb['id'] ?>";
        $(document).on("click", ".image_del", function() {
          var idx = $(".image_del").index(this);
          var img_name = $(this).data("img_name");
          if (confirm("이미지를 삭제하시겠습니까?")) {
            $.post(bv_admin_url + "/member/ajax.sub.image.del.php", {
              mb_id: mb_id,
              img_name: img_name
            }, function(obj) {
              if (obj == 'Y') {
                $(".img_container").eq(idx).remove();
              }
            })
          }
        });
        /* 서브이미지 삭제 */
      </script>
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
      <p class="gap50"></p>
      <div class="kfia_info">
        <h5 class="htag_title">매장정보</h5>
        <p class="gap20"></p>
        <div class="board_table">
          <table>
            <colgroup>
              <col class="w200">
              <col>
              <col class="w200">
              <col>
            </colgroup>
            <tbody>
           <!-- ------------------------------------------------------------------------------------- _20240713_SY 
                  * 노출여부 ju_display로 name값 변경
                ------------------------------------------------------------------------------------- -->
              <tr>
                <th scope="row">노출여부</th>
                <td>
                  <ul class="radio_group">
                    <li class="radios">
                      <input type="radio" name="ju_display" value="1" id="ju_mem_y" <?php echo get_checked($mb['ju_display'], '1'); ?>>
                      <label for="ju_mem_y">예</label>
                    </li>
                    <li class="radios">
                      <input type="radio" name="ju_display" value="2" id="ju_mem_n" <?php echo get_checked($mb['ju_display'], '2'); ?>>
                      <label for="ju_mem_n">아니오</label>
                    </li>
                  </ul>
                </td>
                <th scope="row">음식점분류</th>
                <td>
                  <div class="chk_select">
                    <select name="ju_cate" id="ju_cate">
                      <option value="">분류 선택</option>
                      <?php
                      foreach ($food_categorys as $v) {
                        if ($mb['ju_cate'] == $v) {
                          echo '<option value="' . $v . '" selected>' . $v . '</option>';
                        } else {
                          echo '<option value="' . $v . '">' . $v . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <th scope="row">매장 외부 사진<br>(jpg, gif, png)</th>
                <td colspan="3">
                  <div class="file_wrap">
                    <input type="file" name="ju_mimg">
                    <?php
                    if ($mb['ju_mimg']) {
                      echo '<img src="' . BV_DATA_URL . '/member/' . $mb['ju_mimg'] . '" class="w90p">';
                    }
                    ?>
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
                <th scope="row">브레이크타임</th>
                <td>
                  <div class="write_address">
                    <div class="addressMore">
                      <input type="text" class="frm_input" name="breaktime[]" id="break1" value="<?php echo $breaks[0] ?>">
                      <p class="line marr10 marl10">~</p>
                      <input type="text" class="frm_input" name="breaktime[]" id="break2" value="<?php echo $breaks[1] ?>">
                      
                    </div>
                    <div style="margin-top:3px;">
                      <input type="checkbox" id="nobreak"><label for="nobreak">브레이크타임 없음</label>
                      <script>
                      $("#nobreak").click(function(){
                        if($(this).is(":checked")){
                          $("#break1").val('').prop("disabled", true);
                          $("#break2").val('').prop("disabled", true);
                        } else {
                          $("#break1").prop("disabled", false);
                          $("#break2").prop("disabled", false);
                        }
                      });
                      </script>
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
                <th scope="row">매장 설명</th>
                <td colspan="3"><textarea name="ju_content" class="frm_textbox" rows="3"><?php echo $mb['ju_content']; ?></textarea></td>
              </tr>
              <tr>
                <th scope="row">상호(법인명)</th>
                <td>
                  <input type="text" name="ju_restaurant" value="<?php echo $mb['ju_restaurant']; ?>" class="frm_input">
                </td>
                <th scope="row">대표자명</th>
                <td>
                  <input type="text" name="ju_name" value="<?php echo $mb['ju_name']; ?>" class="frm_input">
                </td>
              </tr>
              <tr>
                <th scope="row">사업장 연락처</th>
                <td>
                  <input type="text" name="" value="<?php echo $mb['telephone']; ?>" class="frm_input">
                </td>
                <th scope="row">대표자 연락처</th>
                <td>
                  <input type="text" name="" value="<?php echo $mb['cellphone']; ?>" class="frm_input">
                </td>
              </tr>
              <tr>
                <th scope="row">사업장 주소</th>
                <td>
                  <div class="write_address">
                    <div class="file_wrap address">
                      <input type="text" name="ju_addr_full" id="ju_addr_full" value="<?php echo $mb['ju_addr_full']; ?>" class="frm_input w200" size="50">
                      <a href="#none" onclick="daumAddress();" class="btn_file">주소검색</a>
                      <a href="#none" onclick="getPosition();" class="btn_file">좌표가져오기</a>
                    </div>
                  </div>
                </td>
                <th scope="row">좌표(위도/경도)</th>
                <td>
                  <div class="write_address">
                    <div class="addressMore">
                      <input type="text" name="ju_lat" id="ju_lat" value="<?php echo $mb['ju_lat']; ?>" class="frm_input">
                      <input type="text" name="ju_lng" id="ju_lng" value="<?php echo $mb['ju_lng']; ?>" class="frm_input">
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <th scope="row">지회/지부</th>
                <td>
                  <div class="chk_select">
                    <select name="ju_region2" id="ju_region2">
                      <option value="">지회 선택</option>
                      <?php
                      $depth1 = juinGroupInfo(1);
                      for ($d = 0; $d < count($depth1); $d++) { ?>
                        <option value="<?php echo $depth1[$d]['code'] ?>" <?php echo $mb['ju_region2'] == $depth1[$d]['code'] ? "selected" : "" ?>><?php echo $depth1[$d]['region'] ?></option>
                      <?php  }
                      ?>
                    </select>
                  </div>
                  <div class="chk_select">
                    <!-- 지부정보수정 _20240618_SY -->
                    <select name="ju_region3" id="ju_region3">
                      <?php
                      $depth1 = juinGroupInfo(4, $mb['ju_region2']);
                      for ($d = 0; $d < count($depth1); $d++) { ?>
                        <option value="<?php echo $depth1[$d]['code'] ?>" <?php echo $mb['ju_region3'] == $depth1[$d]['code'] ? "selected" : "" ?>><?php echo $depth1[$d]['region'] ?></option>
                      <?php  }
                      ?>
                    </select>
                  </div>
                </td>

                <th scope="row">사업자번호</th>
                <td>
                    <input type="text" name="ju_b_num" value="<?php echo $mb['ju_b_num']; ?>" class="frm_input">
                </td>
              </tr>
              <tr>
                <th scope="row">업태</th>
                <td>
                  <input type="text" name="ju_business_type" value="<?php echo $mb['ju_business_type']; ?>" class="frm_input">
                </td>
                <th scope="row">종목</th>
                <td>
                  <input type="text" name="ju_sectors" value="<?php echo $mb['ju_sectors']; ?>" class="frm_input">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <p class="gap50"></p>
      <h5 class="htag_title">기타정보</h5>
      <p class="gap20"></p>
      <div class="board_table">
        <table>
          <colgroup>
            <col class="w200">
            <col class="w400">
            <col class="w200">
            <col>
          </colgroup>
          <tbody>
            <tr>
              <th scope="row">메일수신</th>
              <td>
                <ul class="radio_group">
                  <li>
                    <input type="radio" name="mailser" value="Y" id="mb_mailling_yes" <?php echo get_checked($mb['mailser'], 'Y'); ?>>
                    <label for="mb_mailling_yes">예</label>
                  </li>
                  <li>
                    <input type="radio" name="mailser" value="N" id="mb_mailling_no" <?php echo get_checked($mb['mailser'], 'N'); ?>>
                    <label for="mb_mailling_no">아니오</label>
                  </li>
                </ul>
              </td>
              <th scope="row">문자수신</th>
              <td>
                <ul class="radio_group">
                  <li>
                    <input type="radio" name="smsser" value="Y" id="mb_sms_yes" <?php echo get_checked($mb['smsser'], 'Y'); ?>>
                    <label for="mb_sms_yes">예</label>
                  </li>
                  <li>
                    <input type="radio" name="smsser" value="N" id="mb_sms_no" <?php echo get_checked($mb['smsser'], 'N'); ?>>
                    <label for="mb_sms_no">아니오</label>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <th scope="row">회원가입일</th>
              <td><?php echo $mb['reg_time']; ?></td>
              <th scope="row">최근아이피</th>
              <td><?php echo $mb['login_ip']; ?></td>
            </tr>
            <tr>
              <th scope="row">로그인횟수</th>
              <td><?php echo number_format($mb['login_sum']); ?> 회</td>
              <th scope="row">최근접속일</th>
              <td><?php echo (!is_null_time($mb['today_login'])) ? $mb['today_login'] : ''; ?></td>
            </tr>
            <tr>
              <th scope="row">구매횟수</th>
              <td><?php echo number_format(shop_count($mb['id'])); ?> 회</td>
              <th scope="row">총구매금액</th>
              <td><?php echo number_format(shop_price($mb['id'])); ?> 원</td>
            </tr>
            <tr>
              <th scope="row">접근차단일자</th>
              <td>
                <input type="text" name="intercept_date" value="<?php echo $mb['intercept_date']; ?>" id="intercept_date" class="frm_input w300" size="10" maxlength="8">
                <div class="checks mart10">
                  <input type="checkbox" value="<?php echo date("Ymd"); ?>" id="mb_intercept_date_set_today" onclick="if(this.form.intercept_date.value==this.form.intercept_date.defaultValue) { this.form.intercept_date.value=this.value; } else { this.form.intercept_date.value=this.form.intercept_date.defaultValue; }">
                  <label for="mb_intercept_date_set_today">접근차단일을 오늘로 지정</label>
                </div>
              </td>
              <th scope="row">IP</th>
              <td><?php echo $mb['mb_ip']; ?></td>
            </tr>
            <tr>
              <th scope="row">관리자메모</th>
              <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"><?php echo $mb['memo']; ?></textarea></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="board_btns tac mart20">
        <div class="btn_wrap btn_type">
          <input type="submit" value="저장" class="btn_acc marr10" accesskey="s">
          <button type="button" class="btn_medium bx-red marr10" onclick="member_leave();">탈퇴</button>
          <button type="button" class="btn_medium bx-white" onclick="window.close();">닫기</button>
        </div>
      </div>
    </section>
  </div>
</form>

<script>
  function member_leave() {
    if (confirm("영구 탈퇴처리 하시겠습니까?\n한번 삭제된 데이터는 복구 불가능합니다.")) {
      var token = get_ajax_token();
      if (!token) {
        alert("토큰 정보가 올바르지 않습니다.");
        return false;
      }
      location.href = "./member_delete.php?mb_id=<?php echo $mb_id; ?>&token=" + token;
      return true;
    } else {
      return false;
    }
  }

  $(function() {
    $(".pt_pay_fld").hide();
    $(".mb_adm_fld").hide();
    <?php if (is_partner($mb[id])) { ?>
      $(".pt_pay_fld").show();
    <?php } ?>
    <?php if ($mb[grade] == 1) { ?>
      $(".mb_adm_fld").show();
    <?php } ?>
    // 중앙회 level 추가 _20240604_SY
    <?php if ($mb[grade] != 8) { ?>
      $('.kfia_info').hide();
    <?php } ?>
    $("#mb_grade").on("change", function() {
      $(".pt_pay_fld:visible").hide();
      $(".mb_adm_fld:visible").hide();
      var level = $(this).val();
      if (level >= 2 && level <= 6) {
        $(".pt_pay_fld").show();
      } else if (level == 1) {
        $(".mb_adm_fld").show();
      } 

      // 중앙회 level 추가 _20240604_SY
      if (level == 8) {
        $('.kfia_info').show();  
      } else {
        $('.kfia_info').hide();  
      }
    });

   
  });
</script>

<?php
include_once(BV_ADMIN_PATH . "/admin_tail.sub.php");
?>