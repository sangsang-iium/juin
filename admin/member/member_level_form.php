<?php
if(!defined('_BLUEVATION_')) exit;

// 추가 _20240617_SY
if($_SESSION['ss_mb_id'] != "admin") {
  alert("최고관리자만 이용가능합니다.");
}

$sql_common = " from shop_member_grade ";
$sql_order  = " order by gb_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select * $sql_common $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$arr_memo = array();
$arr_memo[0] = '주인장 이용회원';
$arr_memo[1] = '주인장 이용회원';
$arr_memo[2] = '주인장 이용회원';
$arr_memo[3] = '지회/지부 직원';
$arr_memo[4] = '입점 업체';
$arr_memo[5] = '-';
$arr_memo[6] = '-';
$arr_memo[7] = '-';
$arr_memo[8] = '최고 관리자';
?>

<h5 class="htag_title">세부설정</h5>
<p class="gap20"></p>
<form name="frmlist" method="post" action="./member/member_level_form_update.php">
<div class="board_list">
	<table class="list01">
	<colgroup>
		<col class="w150">
		<col class="w300">
		<col class="w300">
		<col class="w150">
		<col class="w300">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">No</th>
		<th scope="col">회원 구분</th>
		<th scope="col">할인률</th>
		<th scope="col">판매가 절삭</th>
		<th scope="col">포인트</th>
		<th scope="col">적립 포인트</th>
		<th scope="col">비고</th>
	</tr>
	</thead>
	<tbody class="list">
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			Lv.<?php echo $num--; ?>
			<input type="hidden" name="gb_no[<?php echo $i; ?>]" value="<?php echo $row['gb_no']; ?>">
			<input type="hidden" name="chk[]" value="<?php echo $i; ?>" checked>
		</td>
		<td><input type="text" name="gb_name[<?php echo $i; ?>]" value="<?php echo $row['gb_name']; ?>" class="frm_input wfull"></td>
		<td>
			<input type="text" name="gb_sale[<?php echo $i; ?>]" value="<?php echo $row['gb_sale']; ?>" class="frm_input w100">
            <div class="chk_select w100">
                <select name="gb_sale_rate[<?php echo $i; ?>]">
                    <option value="0"<?php echo get_selected($row['gb_sale_rate'], '0'); ?>>%</option>
                    <option value="1"<?php echo get_selected($row['gb_sale_rate'], '1'); ?>>원</option>
                </select>
            </div>
		</td>
		<td>
            <div class="chk_select">
                <select name="gb_sale_unit[<?php echo $i; ?>]">
                    <?php echo option_selected('0', $row['gb_sale_unit'], '사용안함'); ?>
                    <?php echo option_selected('10', $row['gb_sale_unit'], '십원 단위절삭'); ?>
                    <?php echo option_selected('100', $row['gb_sale_unit'], '백원 단위절삭'); ?>
                    <?php echo option_selected('1000', $row['gb_sale_unit'], '천원 단위절삭'); ?>
                    <?php echo option_selected('10000', $row['gb_sale_unit'], '만원 단위절삭'); ?>
                </select>
            </div>
		</td>
		<td>
			<input type="text" name="gb_point[<?php echo $i; ?>]" value="<?php echo $row['gb_point']; ?>" class="frm_input wfull">
		</td>
		<td>
			<input type="text" name="gb_get_point[<?php echo $i; ?>]" value="<?php echo $row['gb_get_point']; ?>" class="frm_input w100">
			<a href="/admin/member/pop_get_point.php?gb_no=<?php echo $row['gb_no'] ?>" onclick="win_open(this,'pop_get_point','750','500','no');return false" class="w100">카테고리설정</a>
		</td>
		<td><?php echo $arr_memo[$i]; ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="board_btns tac mart20">
    <div class="btn_wrap">
	    <input type="submit" value="저장" class="btn_acc">
    </div>
</div>
</form>
