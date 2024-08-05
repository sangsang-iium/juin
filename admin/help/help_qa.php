<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_qa ";
$sql_search = " where (1) ";
$sql_order  = " order by index_no desc ";

if($sfl && $stx) {
	if($sfl == 'all') {
		$allColumns = array("mb_id","subject");
		$sql_search .= allSearchSql($allColumns,$stx);
	} else {
    	$sql_search .= " and $sfl like '%$stx%' ";
	}
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

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
						            <?php echo option_selected('all', $sfl, '전체'); ?>
                        <?php echo option_selected('mb_id', $sfl, '작성자'); ?>
                        <?php echo option_selected('subject', $sfl, '제목'); ?>
                    </select>
                </div>
                <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
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

<form name="fqalist" id="fqalist" method="post" action="./help/help_qa_delete.php" onsubmit="return fqalist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w100">
		<col class="w100">
		<col>
		<col class="w100">
		<col class="w170">
		<col class="w100">
		<col class="w150">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col">번호</th>
		<th scope="col">분류</th>
		<th scope="col">제목</th>
		<th scope="col">작성자</th>
		<th scope="col">작성일</th>
		<th scope="col">답변</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$s_upd = "<a href=\"./help.php?code=qa_form&w=u&index_no={$row['index_no']}$qstr&page=$page\" class=\"btn_fix bg_type2\"><span>수정</span></a>";		

		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="index_no[<?php echo $i; ?>]" value="<?php echo $row['index_no']; ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['mb_id']; ?> 님</label>
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>" id="chk_<?php echo $i; ?>">
		</td>	
		<td><?php echo $num--; ?></td>
		<td><b><?php echo $row['catename']; ?></b></td>
		<td class="tal"><?php echo cut_str($row['subject'],70); ?></td>
		<td class="tal"><?php echo $row['mb_id']; ?></td>
		<td><?php echo substr($row['wdate'],0,10); ?></td>
		<td><?php echo $row['result_yes']?'yes':'no'; ?></td>
		<td>
            <div class="btn_wrap">
                <?php echo $s_upd; ?>
            </div>
        </td>
	</tr>
	<?php 
	}
	if($i==0)
		echo '<tbody><tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
function fqalist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
