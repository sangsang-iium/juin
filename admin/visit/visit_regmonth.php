<?php
if(!defined('_BLUEVATION_')) exit;

// 담당자 정보 추가 _20240619_SY
$mn_where = "";
if($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  
  /* ------------------------------------------------------------------------------------- _20240716_SY 
    * 지회 통계 추가 grade > 3
  /* ------------------------------------------------------------------------------------- */
  $mn_sel = " SELECT * FROM shop_manager WHERE id = '{$_SESSION['ss_mn_id']}'";
  $mn_row = sql_fetch($mn_sel);

  if($mn_sel['grade'] < 3) {
    $b_master_sql = " SELECT index_no, id, name, grade, ju_region1, ju_region2, ju_region3
                        FROM shop_manager
                       WHERE ju_region2 = '{$mn_row['ju_region2']}'
                         AND grade > {$mn_row['grade']}" ;
    $b_master_res = sql_query($b_master_sql);
    $addIn = "";
    while ($b_master_row = sql_fetch_array($b_master_res)) {
      // if (!empty($addIn)) {
      //   $addIn .= ", ";
      // }
      $addIn .= ", '" . $b_master_row['index_no'] . "'";
    }
      $mn_where = " AND ju_manager IN ( '{$_SESSION['ss_mn_id']}' $addIn )";

  } else {
    $mn_where = " AND ju_manager IN ( SELECT index_no FROM shop_manager WHERE id = '{$_SESSION['ss_mn_id']}' ) ";
  }
} 

if(!$year) $year = BV_TIME_YEAR;

$tot_count1 = sel_count("shop_member", "where grade between 8 and 9 {$mn_where}");
$tot_count2 = sel_count("shop_member", "where grade = 9 {$mn_where}");
$tot_count3 = sel_count("shop_member", "where grade = 8 {$mn_where}");

$sql = " select MIN(reg_time) as min_year
		   from shop_member
		  where grade between 8 and 9 ";
$row = sql_fetch($sql);


$min_year = substr($row['min_year'],0,4); // 가장작은 년도
if(!$min_year) $min_year = BV_TIME_YEAR; // 내역이없다면 현재 년도로
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
                for($i=$min_year; $i<=BV_TIME_YEAR; $i++) {
                    echo "<option value=\"{$i}\"".get_selected($year, $i).">{$i}년</option>\n";
                }
                ?>
            </select>
        </div>
        <div class="search_container_input">
            <input type="submit" value="검색" class="btn_small">
        </div>
	</div>
</form>
</div>

<div class="local_ov mart20 fs18">
	총 회원수 : <b><?php echo number_format($tot_count1); ?></b>명
	<span class="ov_a">
		일반회원 : <b><?php echo number_format($tot_count2); ?></b>명,
		중앙회회원 : <b><?php echo number_format($tot_count3); ?></b>명
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
	</colgroup>
	<thead>
	<tr>
		<th scope="col">날짜</th>
		<th scope="col">그래프</th>
		<th scope="col">비율%</th>
		<th scope="col">전체</th>
		<th scope="col">일반</th>
		<th scope="col">중앙회</th>
	</tr>
	</thead>
	<tbody class="list">
        <?php
        if(!$tot_count1) $tot_count1 = 1;

        for($i=1; $i<=12; $i++) {
            $month = sprintf("%02d", $i);
            $date = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $year.$month);

            $count1 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade between 8 and 9 {$mn_where}");
            $count2 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade = 9 {$mn_where}");
            $count3 = sel_count("shop_member", "where left(reg_time,7)='$date' and grade = 8 {$mn_where}");

            $rate = ($count1 / $tot_count1 * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'list'.($i%2);
            if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { 
              echo $sel_count;
             }
        ?>
        <tr class="<?php echo $bg; ?>">
            <td><?php echo $date; ?></td>
            <td><progress class="board_progress" max="100" value="<?php echo $s_rate; ?>"></td>
            <!-- <td><div class="graph"><span class="bar" style="width:<?php echo $s_rate; ?>%"></span></div></td> -->
            <td><?php echo $s_rate; ?></td>
            <td><?php echo number_format($count1); ?></td>
            <td><?php echo number_format($count2); ?></td>
            <td><?php echo number_format($count3); ?></td>
        </tr>
        <?php
            // 이번달과 같다면 중지
            if($date == BV_TIME_YM) break;
        }
        ?>
	</tbody>
	</table>
</div>
