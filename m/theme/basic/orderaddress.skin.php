<?php
if (!defined('_BLUEVATION_')) exit;
//echo test;
?>

<form name="forderaddress" method="post">
  <div id="sod_addr" class="new_win">
    <div class="win_desc">
      <ul class="sod_addr_li">
        <?php
        $sep = chr(30);
        $k = 0;
        $ar_mk = array();

        $mb_id = $member['id'];


        $sql = "select * from b_address where mb_id='$mb_id' ";
        //echo $sql;
        $result = sql_query($sql);

        for ($i = 0; $row = sql_fetch_array($result); $i++) {
          $info = array();
          $info[] = $row['b_name'];
          $info[] = $row['b_cellphone'];
          $info[] = $row['b_telephone'];
          $info[] = $row['b_zip'];
          $info[] = $row['b_addr1'];
          $info[] = $row['b_addr2'];
          $info[] = $row['b_addr3'];


          $addr = implode($sep, $info);
          $addr = get_text($addr);

          if (!in_array($addr, $ar_mk)) {
            $k++;
            $ar_mk[$i] = $addr;
        ?>
            <li>
              <div class="od-dtn-info">
                <p class="od-dtn__name">
                  <span class="nm"><?php echo $row['b_name']; ?></span>
                  <?php
                  if ($row['b_base'] == "1") {
                  ?>
                    <span class="tag">기본배송지</span>
                  <?php
                  }
                  ?>


                </p>
                <p class="od-dtn__addr"><?php echo print_address($row['b_addr1'], $row['b_addr2'], $row['b_addr3'], $row['b_addr_jibeon']); ?></p>
                <p class="od-dtn__contact"><?php echo $row['b_cellphone']; ?></p>
              </div>
              <ul class="od-dtn-btns">
                <li class="mngArea">
                  <button type="button" class="ui-btn st3 " onclick="edit_address(<?php echo $row['wr_id'] ?>)">수정</button>
                  <button type="button" class="ui-btn st3 " onclick="del_address(<?php echo $row['wr_id'] ?>)">삭제</button>
                </li>
                <li class="mngArea">
                  <input type="hidden" value="<?php echo $addr; ?>">
                  <button type="button" id="btn_sel" class="ui-btn st3 sel_address">선택</button>
                </li>
              </ul>
            </li>
        <?php
          }
        }

        if (!$total_count) {
          echo '<li class="empty_list">자료가 없습니다.</li>';
        }
        ?>
      </ul>
    </div>

    <div class="pop-btm">
      <button type="button" class="ui-btn round stBlack od-dtn__add">배송지 추가</button>
    </div>
  </div>
</form>

<script>
  // 도서/산간 배송비 검사
  function calculate_sendcost(code) {
    $.post(bv_shop_url + "/ordersendcost.php", {
      zipcode: code
    }, function(data) {
      $("input[name=baesong_price2]").val(data);
      $("#send_cost2").text(number_format(String(data)));

      calculate_order_price();
    });
  }

  function calculate_order_price() {
    var sell_price = parseInt($("input[name=org_price]").val()); // 합계금액
    var send_cost2 = parseInt($("input[name=baesong_price2]").val()); // 추가배송비
    var mb_coupon = parseInt($("input[name=coupon_total]").val()); // 쿠폰할인
    var mb_point = parseInt(
      $("input[name=use_point]").val().replace(/[^0-9]/g, "")
    ); //포인트결제
    var tot_price = sell_price + send_cost2 - (mb_coupon + mb_point);

    $("input[name=tot_price]").val(number_format(String(tot_price)));
  }

  $(function() {
    $(".sel_address").on("click", function() {
      var addr = $(this)
        .siblings("input")
        .val()
        .split(String.fromCharCode(30));

      // var f = window.opener.buyform;
      var f = buyform;

      f.b_name.value = addr[0];
      f.b_cellphone.value = addr[1];
      f.b_telephone.value = addr[2];
      f.b_zip.value = addr[3];
      f.b_addr1.value = addr[4];
      f.b_addr2.value = addr[5];
      f.b_addr3.value = addr[6];
      f.b_addr_jibeon.value = addr[7];

      $("#od-dtn .od-dtn__name .nm").text(addr[0]);
      $("#od-dtn .od-dtn__addr").text(addr[4] + ", " + addr[5] + " " + addr[6]);
      $("#od-dtn .od-dtn__contact").text(addr[1]);

      var zip = addr[3].replace(/[^0-9]/g, "");
      if (zip != "") {
        var code = String(zip);
        // window.opener.calculate_sendcost(code);
        calculate_sendcost(code);
      }

      // window.close();
      $(".popDim").fadeOut(200);
      $("#delv-popup")
        .fadeOut(200)
        .removeClass("on");
    });
  });


  //del_address
  function del_address(wr_id) {
    console.log("del_address", wr_id);


    $.ajax({
      url: '/m/shop/del_address.php',
      data: {
        "wr_id": wr_id
      },
      success: function(data) {
        orderaddress_open();
      }
    });
  }

  //edit_address 
  function edit_address(wr_id) {
    console.log("edit_address", wr_id);
    var delvWritePopId1 = 'delv-write-popup';
    $.ajax({
      url: '/m/shop/orderaddress_write.php',
      data: {
        'wr_id': wr_id
      },
      success: function(data) {
        $(`#${delvWritePopId1}`).find(".pop-content-in").html(data);
        popupOpen1(delvWritePopId1);
      }
    });

  }

  function orderaddress_open() {
    $.ajax({
      url: '/m/shop/orderaddress.php',
      success: function(data) {
        var popid = "delv-popup";
        $(`#${popid}`).find(".pop-content-in").html(data);
        console.log(data);
      }
    });
  }



  // 팝업 열기
  popupOpen1 = (id) => {
    $('#' + id).fadeIn(200).addClass("on");
  }

  // 팝업 닫기
  popupClose1 = (t) => {
    t.fadeOut(200).removeClass("on");
  }
</script>



<!-- 배송 메시지 주석 _20240713_SY -->
<!-- <div id="sod_addr" class="new_win">
  <div class="pop-top">
    <p class="tit">배송메시지 추가</p>
  </div>

  <div id="sod_addr_write">
    <div class="form-wrap">
      <div class="form-row">
        <div class="form-head">
          <p class="title">메시지추가<b>*</b>
          </p>
        </div>
        <div class="form-body">
          <input type="text" name="b_addr_req2" id="b_addr_req_save" value="" class="w-per100 frm-input">
          <button type="button" class="ui-btn st3 " onclick="fn_b_addr_req_save()">등록</button>
        </div>
      </div>
    </div>
    <div class="pop-btm">

    </div>
  </div>

  <div class="win_desc">
    <ul class="sod_addr_li address_area">
      <li>
        <div class="od-dtn-info">
          <p class="od-dtn__name">
            <span class="nm">aaa</span>
            <span class="tag">기본메시지</span>
          </p>
          <p class="od-dtn__addr">초인종을 눌러 주세요</p>
          <p class="od-dtn__contact"></p>
        </div>
        <ul class="od-dtn-btns">
          <li class="mngArea">
            <button type="button" class="ui-btn st3 ">삭제</button>
          </li>
          <li class="mngArea">
            <button type="button" id="btn_sel" class="ui-btn st3 sel_address">배송메시지로선택</button>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div> -->
<script>
  function fn_b_addr_req_save() {
    var msg = $("#b_addr_req_save").prop('value');
    $.ajax({
      type: 'post',
      url: '/m/shop/b_addr_req_sql.php',
      data: {
        'b_addr_req': msg
      },
      success: function(data) {
        $("#b_addr_req_save").prop('value', '');
        fn_b_addr_req_list();
      }
    });
  }

  function fn_b_addr_req_list() {
    console.log("aaa")
    var msg = $("#b_addr_req_save").prop('value');
    $.ajax({
      type: 'post',
      url: '/m/shop/b_addr_req_list.php',
      data: {
        'b_addr_req': msg
      },
      success: function(data) {
        var aa = JSON.parse(data);
        var htmls = "";
        var k = 1;
        for (var i = 0; i < aa.length; i++) {
          console.log(aa[i]['idx'])
          console.log(aa[i]['msg'])
          if (aa[i]['msg'] != '') {
            htmls += '<li>';
            htmls += '    <div class="od-dtn-info">';
            htmls += '        <p class="od-dtn__name">';
            htmls += '            <span class="nm">' + k + '</span> ';
            // htmls+='            <span class="tag">기본메시지</span>  ';
            htmls += '        </p>';
            htmls += '        <p class="od-dtn__addr">' + aa[i]['msg'] + '</p>';
            htmls += '        <p class="od-dtn__contact"></p>';
            htmls += '    </div>';
            htmls += '    <ul class="od-dtn-btns">';
            htmls += '        <li class="mngArea"> ';
            htmls += '            <button type="button" class="ui-btn st3 " onclick="fn_basong_del(\'' + aa[i]['idx'] + '\')">삭제</button>';
            htmls += '        </li>';
            htmls += '        <li class="mngArea"> ';
            htmls += '            <button type="button" id="btn_sel" class="ui-btn st3 sel_address" onclick="fn_basong(\'' + aa[i]['msg'] + '\')">배송메시지로선택</button>';
            htmls += '        </li>';
            htmls += '    </ul>';
            htmls += '</li>';
            k += 1;
          }



        }

        $(".address_area").html(htmls);
      }
    });
  }
  fn_b_addr_req_list();

  function fn_basong(msg) {
    $.ajax({
      type: 'post',
      url: '/m/shop/b_addr_req_set.php',
      data: {
        'b_addr_req': msg,
        'cd': 'set'
      },
      success: function(data) {
        var f = buyform;
        f.b_addr_req.value = msg;
        alert(msg + '로 메시지가 변경되었습니다.');
      }
    })
  }

  function fn_basong_del(idx) {
    console.log('front', idx)
    $.ajax({
      type: 'post',
      url: '/m/shop/b_addr_req_set.php',
      data: {
        'idx': idx,
        'cd': 'del'
      },
      success: function(data) {
        alert('메시지를 삭제 했습니다.');
      }
    })
    fn_b_addr_req_list();
  }
</script>