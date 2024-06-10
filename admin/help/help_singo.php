<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

$query_string = "code=$code$qstr";
$q1           = $query_string;
$q2           = $query_string . "&page=$page";

$sql_common = " from shop_used_singo AS a join shop_used AS b on a.pno = b.no";
$sql_search = " where (1) ";

if ($sfl && $stx) {
  if($sfl=='title'){
    $sql_search .= " and b.title like '%$stx%' ";
  } else if($sfl=='singo_id'){
    $sql_search .= " and a.mb_id like '%$stx%' ";
  } else if($sfl=='target_id'){
    $sql_search .= " and b.mb_id like '%$stx%' ";
  }
}

// 기간검색
if ($fr_date && $to_date) {
  $sql_search .= " and a.regdate between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
} else if ($fr_date && !$to_date) {
  $sql_search .= " and a.regdate between '$fr_date 00:00:00' and '$fr_date 23:59:59' ";
} else if (!$fr_date && $to_date) {
  $sql_search .= " and a.regdate between '$to_date 00:00:00' and '$to_date 23:59:59' ";
}

$sql_order = " order by a.no desc ";

// 테이블의 전체 레코드수만 얻음
$sql         = " select count(*) as cnt $sql_common $sql_search ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$rows       = 15;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {$page = 1;}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
$num         = $total_count - (($page - 1) * $rows);

$sql    = " select a.*, b.mb_id as target_id, b.title $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
EOF;
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="board_table">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col style="width:auto">
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
            <div class="tel_input">
                <div class="chk_select w200">
                    <select name="sfl">
                        <?php echo option_selected('title', $sfl, '제목'); ?>
                        <?php echo option_selected('singo_id', $sfl, '작성자ID'); ?>
                        <?php echo option_selected('target_id', $sfl, '대상자ID'); ?>
                    </select>
                </div>
                <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">기간검색</th>
		<td>
            <div class="tel_input">
                <?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
            </div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="board_btns tac mart20">
    <div class="btn_wrap">
        <input type="submit" value="검색" class="btn_acc marr10">
        <input type="button" value="초기화" id="frmRest" class="btn_cen">
    </div>
</div>
</form>

<div class="local_ov mart30 fs18">
	총 신고수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>
</div>

<form name="ffaqlist" id="ffaqlist" method="post" action="./help/help_singo_delete.php" onsubmit="return ffaqlist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="board_list">
	<table class="list01">
	<colgroup>
		<col class="w50">
		<col class="w100">
		<col class="">
		<col class="w100">
		<col class="w100">
		<col class="w150">
		<col class="w200">
		<col class="w200">
	</colgroup>
	<thead>
	<tr>
	    <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col">번호</th>
		<th scope="col">제목</th>
		<th scope="col">작성자</th>
		<th scope="col">대상자</th>
		<th scope="col">신고사유</th>
		<th scope="col">신고일시</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<tbody class="list">
	<?php
	for ($i = 0; $row = sql_fetch_array($result); $i++) {
  	    $bg = 'list' . ($i % 2);
  	    $vlink = '/admin/help.php?code=singod&no='.$row['no'].'&sfl='.$sfl.'&stx='.$stx.'&fr_date='.$fr_date.'&to_date='.$to_date.'&page='.$page;
    ?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="no[<?php echo $i; ?>]" value="<?php echo $row['no']; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td><a href="<?php echo $vlink ?>"><b><?php echo $row['title']; ?></b></a></td>
		<td><?php echo $row['mb_id']; ?></td>
		<td><?php echo $row['target_id']; ?></td>
		<td><?php echo $row['category']; ?></td>
		<td><?php echo $row['regdate']; ?></td>
		<td>
		<?php
		if($row['status']){
		    echo '삭제 완료';
		} else {
		    echo '<a href="#none" onclick="singoUsedDelete('.$row['pno'].',\''.$row['title'].'\','.$row['no'].')" class="btn_small red">게시글 삭제</a>';
		    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		    echo '<a href="/m/used/view.php?no='.$row['pno'].'" target="_blank" class="btn_small">바로가기</a>';
		}
		?>
	    </td>
	</tr>
	<?php
	}
	if ($i == 0) {
		echo '<tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
	}
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $q1 . '&page=');
?>

<script>
function singoUsedDelete(pno, title, sno){
    if(confirm('['+title+']\n판매글을 삭제하시겠습니까?\n삭제하시면 복구하실 수 없습니다.')){
        $.post(bv_admin_url+"/help/ajax.used.del.php", {pno:pno,sno:sno}, function(obj){
            if(obj=='Y'){
                location.reload();
            }
        })
    }
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function ffaqlist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택하신 신고글을 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>