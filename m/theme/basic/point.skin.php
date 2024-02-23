<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="point">
  <div id="contents">

    <div class="bottomBlank point-retention">
      <div class="container">
        <div class="hold-box">
          <p class="tit">보유 포인트</p>
          <p class="num">
            <?php echo number_format($member['point']); ?><span class="unit">P</span>
          </p>
        </div>
      </div>
    </div>

    <div class="point-sort">
      <div class="container">
        <select name="" id="" class="frm-select">
          <option value="">선택</option>
          <option value="">1개월</option>
          <option value="">3개월</option>
          <option value="">12개월</option>
        </select>
      </div>
    </div>

    <div class="point-sum">
      <div class="container">
        <div class="calc-box">
          <div class="calc-item">
            <p class="tit">지급</p>
            <p class="num"><?php echo $sum_point1; ?></p>
          </div>
          <div class="calc-item">
            <p class="tit">사용</p>
            <p class="num"><?php echo $sum_point2; ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="point-brkdown">
      <div class="container">
        <div class="point-list">
          <div class="point-cnt">
            총 <span class="cnt"><?php echo number_format($total_count); ?></span>건
          </div>
          <div class="point-board">
            <?php
            $sum_point1 = $sum_point2 = $sum_point3 = 0;

            for($i=0; $row=sql_fetch_array($result); $i++) {
              $point1 = $point2 = 0;
              if($row['po_point'] > 0) {
                $point1 = '+' .number_format($row['po_point']);
                $sum_point1 += $row['po_point'];
              } else {
                $point2 = number_format($row['po_point']);
                $sum_point2 += $row['po_point'];
              }

              $expr = '';
              //if($row['po_expired'] == 1)
                $expr = ' txt_expired';
            ?>
            <div class="point-board-item">
              <p class="tit"><?php echo $row['po_content']; ?></p>
              <p class="num">
                <?php if($point1) echo $point1; else echo $point2; ?><span class="unit">P</span>
              </p>
              <p class="date">
                <?php echo conv_date_format('Y.m.d', $row['po_datetime']); ?>
                <?php if($row['po_expired'] == 1) { ?>
                (만료일 <?php echo conv_date_format('Y.m.d', $row['po_expire_date']); ?>)
                <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '' : $row['po_expire_date']; ?>
              </p>
            </div>
            <?php
            }

            if($i == 0)
                echo '<div class="empty_list">자료가 없습니다.</div>';
            else {
                if($sum_point1 > 0)
                    $sum_point1 = "+" . number_format($sum_point1);
                $sum_point2 = number_format($sum_point2);
            }
            ?>
          </div>
        </div>
      </div>
    </div>

    <!-- <p id="sod_fin_no">
      총 <b class="fc_red"><?php echo number_format($total_count); ?></b>건의 포인트내역이 있습니다.
    </p>

    <ul id="point_ul">
      <?php
      $sum_point1 = $sum_point2 = $sum_point3 = 0;

      for($i=0; $row=sql_fetch_array($result); $i++) {
        $point1 = $point2 = 0;
        if($row['po_point'] > 0) {
          $point1 = '+' .number_format($row['po_point']);
          $sum_point1 += $row['po_point'];
        } else {
          $point2 = number_format($row['po_point']);
          $sum_point2 += $row['po_point'];
        }

        $expr = '';
        //if($row['po_expired'] == 1)
          $expr = ' txt_expired';
      ?>
          <li>
              <div class="point_wrap01">
                  <span class="point_date"><?php echo conv_date_format('y-m-d H시', $row['po_datetime']); ?></span>
                  <span class="point_log"><?php echo $row['po_content']; ?></span>
              </div>
              <div class="point_wrap02">
                  <span class="point_expdate<?php echo $expr; ?>">
                      <?php if($row['po_expired'] == 1) { ?>
                      만료<?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                      <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                  </span>
                  <span class="point_inout"><?php if($point1) echo $point1; else echo $point2; ?></span>
              </div>
          </li>
          <?php
          }

          if($i == 0)
              echo '<li class="empty_list">자료가 없습니다.</li>';
          else {
              if($sum_point1 > 0)
                  $sum_point1 = "+" . number_format($sum_point1);
              $sum_point2 = number_format($sum_point2);
          }
          ?>
    </ul>

    <div id="point_sum">
        <div class="sum_row">
            <span class="sum_tit">지급</span>
            <b class="sum_val"><?php echo $sum_point1; ?></b>
        </div>
        <div class="sum_row">
            <span class="sum_tit">사용</span>
            <b class="sum_val"><?php echo $sum_point2; ?></b>
        </div>
        <div class="sum_row">
            <span class="sum_tit">보유</span>
            <b class="sum_val"><?php echo number_format($member['point']); ?></b>
        </div>
    </div> -->

    <?php
    echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
    ?>

  </div>
</div>