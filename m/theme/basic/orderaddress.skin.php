<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="forderaddress" method="post">
<div id="sod_addr" class="new_win">
  <div class="win_desc">
    <ul class="sod_addr_li">
      <?php
      $sep = chr(30);
      $k = 0; $ar_mk = array();
      for($i=0; $row=sql_fetch_array($result); $i++)
      {
        $info = array();
        $info[] = $row['b_name'];			
        $info[] = $row['b_cellphone'];
        $info[] = $row['b_telephone'];
        $info[] = $row['b_zip'];
        $info[] = $row['b_addr1'];
        $info[] = $row['b_addr2'];
        $info[] = $row['b_addr3'];
        $info[] = $row['b_addr_jibeon'];

        $addr = implode($sep, $info);			
        $addr = get_text($addr);

        if(!in_array($addr, $ar_mk)) {
          $k++;
          $ar_mk[$i] = $addr;
      ?>
      <li>
        <div class="od-dtn-info">
          <p class="od-dtn__name">
            <span class="nm"><?php echo $row['b_name']; ?></span>
            <span class="tag">기본배송지</span>
          </p>
          <p class="od-dtn__addr"><?php echo print_address($row['b_addr1'], $row['b_addr2'], $row['b_addr3'], $row['b_addr_jibeon']); ?></p>
          <p class="od-dtn__contact"><?php echo $row['b_cellphone']; ?></p>
        </div>
        <ul class="od-dtn-btns">
          <li class="mngArea">
            <button type="button" class="ui-btn st3">수정</button>
            <button type="button" class="ui-btn st3">삭제</button>
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

      if(!$total_count) {
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
$(function() {
  $(".sel_address").on("click", function () {
    var addr = $(this).siblings("input").val().split(String.fromCharCode(30));

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
    $("#od-dtn .od-dtn__addr").text(addr[4]+", "+addr[5]+" "+addr[6]);
    $("#od-dtn .od-dtn__contact").text(addr[1]);

    var zip = addr[3].replace(/[^0-9]/g, "");
    if (zip != "") {
      var code = String(zip);
      // window.opener.calculate_sendcost(code);
      calculate_sendcost(code);
    }

    // window.close();
    $(".popDim").fadeOut(200);
    $("#delv-popup").fadeOut(200).removeClass("on");
  });
});
</script>
