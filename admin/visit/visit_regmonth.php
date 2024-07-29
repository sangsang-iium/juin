<?php
if (!defined('_BLUEVATION_')) exit;


// 지회지부 검색 추가 _20240717_SY
$sql_search = "";
if(!$_GET['branch']) {
  $branch = $member['ju_region2'];
} 


$qstr .= "&branch='".urlencode($branch);
$qstr .= "&office='".urlencode($office);

$query_string = "code=$code$qstr";
$q1           = $query_string;


if($branch != "00400" || $_GET['branch']) {
  $sql_search .= " AND ju_region2 = '{$branch}' ";
} 


$stx_and = "";
$stx_count = true;
if($stx) {
  $allColumns = array("id","name");
  $stx_and = allSearchSql($allColumns,$stx);
  $belong_add .= $stx_and;
  if($branch) {
    $stx_and .= " AND ju_region2 = '{$branch}' ";
  }
  if($office) {
    $stx_and .= " AND ju_region3 = '{$office}' ";
  }
  $stx_sql = " SELECT * FROM shop_manager WHERE (1) {$stx_and} ";
  $stx_res = sql_query($stx_sql);

  while($stx_row = sql_fetch_array($stx_res)) {
    $values[] = "'" . $stx_row['index_no'] . "'";
  }
  if (!empty($values)) {
    $stxAdd = implode(", ", $values);
    $sql_search .= " AND ju_manager IN ( $stxAdd ) ";
  } else {
    $stx_count = false;
  }
}

$mn_where = "";
// 담당자 정보 추가 _20240619_SY
// 수정 _20240717_SY
if ($_SESSION['ss_mn_id'] ) {
  if($member['ju_region2'] != "00400" && $_SESSION['ss_mn_id'] != "admin") {
    $belong_list = getBelongList($_SESSION['ss_mn_id'], "ju_manager");
    $mn_where .= $belong_list;
  }   
} 

if (!$year) $year = BV_TIME_YEAR;

$tot_count1 = sel_count("shop_member", "where grade between 6 and 9 {$mn_where}");
$tot_count2 = sel_count("shop_member", "where grade = 9 {$mn_where}");
$tot_count3 = sel_count("shop_member", "where grade = 8 {$mn_where}");
$tot_count4 = sel_count("shop_member", "where grade = 6 {$mn_where}");

$sql = " select MIN(reg_time) as min_year
		   from shop_member
		  where grade between 6 and 9 ";
$row = sql_fetch($sql);

$min_year = substr($row['min_year'], 0, 4); // 가장작은 년도
if (!$min_year) $min_year = BV_TIME_YEAR; // 내역이없다면 현재 년도로

// 지회 SELECT Box _20240717_SY
$branch_and = "";
if ($member['ju_region3'] != '00400' && $_SESSION['ss_mn_id'] != "admin") {
  $branch_and = " AND branch_code = '{$member['ju_region2']}' ";
} 
$branch_sel = " SELECT * FROM kfia_branch WHERE (1) {$branch_and} ORDER BY branch_code";
$branch_res = sql_query($branch_sel);

// 지부인지 지회인지 체크 _20240718_SY
$office_add ="";
if(!empty($member['ju_region3'])) {
  $ko_chk_sel = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$member['ju_region3']}' ";
  $ko_chk_res = sql_fetch($ko_chk_sel);
}


?>

<h5 class="htag_title">통계검색</h5>
<p class="gap20"></p>
<div class="board_selecter">
  <form name="fsearch" id="fsearch" method="get">
    <input type="hidden" name="code" value="<?php echo $code; ?>">
    <div class="board_selecter">
      <div class="search_container">
        <select name="year">
          <?php
          for ($i = $min_year; $i <= BV_TIME_YEAR; $i++) {
            echo "<option value=\"{$i}\"" . get_selected($year, $i) . ">{$i}년</option>\n";
          }
          ?>
        </select>
      </div>
      <div class="chk_select w200">
        <select name="branch" onchange="getChapter(this.value)">
          <?php if($branch == "00400" || $_SESSION['ss_mn_id'] == "admin")  { ?>
            <option value=''>지회선택</option>
          <?php } 
        while ($branch_row = sql_fetch_array($branch_res)) {
          echo option_selected($branch_row['branch_code'], $branch, $branch_row['branch_name']);
        } 
      ?>
        </select>
      </div>
      <div class='chk_select w200'>
          <select name="office" id="office">
        <?php // 지부 검색 추가 _20240717_SY
          if ($ko_chk_res['cnt'] < 1 && $member['id'] != "admin") {
            $office_add .= " AND a.office_code = '{$member['ju_region3']}' ";
          } elseif ($member['grade'] < 3) {
            echo "<option value=''>전체</option>";
          } else {
            $office_add .= " AND a.office_code = '{$member['ju_region3']}' ";
          }
          
          $office_where  = " WHERE b.branch_code = '{$branch}' {$office_add}";
          $office_select = getRegionFunc("office", $office_where);
          foreach ($office_select as $key => $val) { ?>
            <option value="<?php echo $val['office_code'] ?>" <?php echo ($val['office_code'] == $office) ? "selected" : "" ?> ><?php echo $val['office_name'] ?></option>
        <?php } ?>
        </select>
      </div>
      <div>
        <input type="text" name="stx" value="" class="frm_input" size="30">
      </div>
      <div class="search_container_input">
        <input type="submit" value="검색" class="btn_small">
      </div>
    </div>
  </form>
  <?php if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { ?>
    <a href="./visit_regmonth_excel.php?<?php echo $q1?>" class="fr btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
  <?php } ?>
</div>

<div class="local_ov mart20 fs18">
  총 회원수 : <b><?php echo number_format($tot_count1); ?></b>명
  <span class="ov_a">
    일반회원 : <b><?php echo number_format($tot_count2); ?></b>명,
    중앙회회원 : <b><?php echo number_format($tot_count3); ?></b>명
    임직원 : <b><?php echo number_format($tot_count4); ?></b>명
  </span>
</div>
<div class="board_list">
  <table>
    <colgroup>
      <col class="w150">
      <col>
      <col class="w100">
      <col class="w100">
      <col class="w100">
      <col class="w100">
      <col class="w100">
    </colgroup>
    <thead>
      <tr>
        <th scope="col">날짜</th>
        <th scope="col">그래프</th>
        <th scope="col">비율%</th>
        <th scope="col">전체</th>
        <th scope="col">일반</th>
        <th scope="col">중앙회</th>
        <th scope="col">임직원</th>
      </tr>
    </thead>
    <tbody class="list">
      <?php
      if (!$tot_count1) $tot_count1 = 1;
      
      $mn_where = "";
      // 지회지부 검색 추가 _20240717_SY

      $belong_add = "";
      
      if($office && $office != "00400") {
        $branch_search = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$office}' ";
        $branch_row = sql_fetch($branch_search);
        if ($branch_row['cnt'] < 1) {
          $sql_search .= " AND ju_region3 = '{$office}' ";
          $belong_add .= " AND ju_region3 = '{$office}' ";
        } else {
          $sql_search .= " AND ju_region2 = '{$office}' ";
        }
      }

      if ($_SESSION['ss_mn_id']) {
        if($member['ju_region2'] != "00400" && $_SESSION['ss_mn_id'] != "admin") {
          // $belong_list = getBelongList($_SESSION['ss_mn_id'], "ju_manager", $belong_add);
          if($ko_chk_res['cnt'] < 1) {
            $office = $member['ju_region3'];
          } 

          if($member['grade'] < 3) {
            $belong_list = forStatisticsFunc($branch, $office, $stx);
          } else {
            $belong_list = " AND ju_manager = '{$member['index_no']}' ";
          }
          $mn_where .= $belong_list;
        } else {
          $branch = !empty($_GET['branch']) ? $_GET['branch'] : "";
          $office = !empty($_GET['office']) ? $_GET['office'] : "";
          if(!empty($branch) || !empty($office)) {
            $belong_list = forStatisticsFunc($branch, $office, $stx_and);
            $mn_where .= $belong_list;
          }
        }
      } 

      for ($i = 1; $i <= 12; $i++) {

        $month = sprintf("%02d", $i);
        $date = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $year . $month);

        if($stx && $stx_count == false) {
          $count1 = 0;
          $count2 = 0;
          $count3 = 0;
          $count4 = 0;
        } else {
          $count1 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade between 6 and 9 {$mn_where}");
          $count2 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade = 9 {$mn_where}");
          $count3 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade = 8 {$mn_where}");
          $count4 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade = 6 {$mn_where}");
        }
      
        $rate = ($count1 / $tot_count1 * 100);
        $s_rate = number_format($rate, 1);

        $bg = 'list' . ($i % 2);
      ?>
        <tr class="<?php echo $bg; ?>">
          <td><?php echo $date; ?></td>
          <td><progress class="board_progress" max="100" value="<?php echo $s_rate; ?>"></td>
          <!-- <td><div class="graph"><span class="bar" style="width:<?php echo $s_rate; ?>%"></span></div></td> -->
          <td><?php echo $s_rate; ?></td>
          <td><?php echo number_format($count1); ?></td>
          <td><?php echo number_format($count2); ?></td>
          <td><?php echo number_format($count3); ?></td>
          <td><?php echo number_format($count4); ?></td>
        </tr>
      <?php
        // 이번달과 같다면 중지
        if ($date == BV_TIME_YM) break;
      }
      ?>
    </tbody>
  </table>
</div>

<script>
// 지부 SELECT BOX _20240717_SY
function getChapter(e) {
console.log(e)  
  $.ajax({
    url: '/admin/ajax.gruopdepth.php',
    type: 'POST',
    data: { 
      depthNum: 4,
      depthValue: e
    },
    success: function(res) {

      let reg = JSON.parse(res);

      let office = $("#office");
      office.empty();

      let defaultOption = $('<option>');
      defaultOption.val("");
      defaultOption.text("전체");
      office.append(defaultOption);

      for (var i = 0; i < reg.length; i++) {
        if(reg[i].region != "") {
          var option = $('<option>');
          option.val(reg[i].code);
          option.text(reg[i].region);
          office.append(option);
        }
      }
    },
    error: function(xhr, status, error) {
      console.log('요청 실패: ' + error);
    }
  })
  
}

</script>