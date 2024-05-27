<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_goods_live ";
$sql_search = " ";

if($stx) {
    $sql_search .= " WHERE like '%$stx%' ";
}

if(!$orderby) {
    $filed = "index_no DESC";
    $sod = "";
} else {
	$sod = $orderby;
}

$sql_order = " order by $filed $sod ";

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

<h2>기본검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
			<select name="sst">
				<option value="라이브존 타이틀">라이브존 타이틀</option>
				<!-- <option value="상품"<?php echo get_selected($sst, '상품'); ?>>상품</option> -->
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>

<div>
	<a href="./goods.php?code=live_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 라이브 등록</a>
</div>

<form name="fqalist" id="fqalist" method="post" action="./goods/goods_qa_delete.php" onsubmit="return fqalist_submit(this);">
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
		<col class="w50">
		<col class="w130">
		<col class="w130">
		<col class="w80">
		<col class="w60">
		<col class="w60">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col">번호</th>
		<th scope="col"><?php echo subject_sort_link('iq_subject',$q2); ?>라이브존 타이틀</a></th>
		<th scope="col"><?php echo subject_sort_link('iq_name',$q2); ?>라이브 시간</a></th>
		<th scope="col"><?php echo subject_sort_link('iq_time',$q2); ?>URL</a></th>
		<th scope="col"><?php echo subject_sort_link('iq_reply',$q2); ?>등록일</a></th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$iq_id = $row['iq_id'];

		$iq_name = get_sideview($row['mb_id'], $row['iq_name']);
		$iq_url = "code=qa_form&w=u&iq_id=$iq_id$qstr&page=$page";
		$iq_upd = "<a href=\"./goods.php?{$iq_url}\" class=\"btn_small\">수정</a>";
		$iq_subject = "<a href=\"./goods.php?{$iq_url}\">".cut_str($row['iq_subject'],50)."</a>";

		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="iq_id[<?php echo $i; ?>]" value="<?php echo $iq_id; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td><?php echo $row['iq_ty']; ?></td>
		<td class="tal"><?php echo $iq_subject; ?></td>
		<td><?php echo $iq_name; ?></a></td>
		<td><?php echo substr($row['iq_time'],0,10); ?></td>
		<td><?php echo $row['iq_answer']?'yes':''; ?></td>
		<td><?php echo $iq_upd; ?></td>
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
