<?php
if(!defined('_BLUEVATION_')) exit;

if($board['read_list']=='1') {
	$sql_search2 = "";
	if($default['de_board_wr_use']) {
		$sql_search2 = " and pt_id = '$pt_id' ";
	}

	$sql_common = " from shop_board_{$boardid} ";
	$sql_search = " where btype = '2' {$sql_search2} ";

	if($sfl && $stx) {
		$sql_search .= " and ($sfl like '%$stx%') ";
	}

	$sql_order = " order by fid desc, thread asc ";

	$sql = " select count(*) as cnt $sql_common $sql_search ";
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];

	$rows = $board['page_num'];
	$total_page = ceil($total_count / $rows); // 전체 페이지 계산
	if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함
	$num = $total_count - (($page-1)*$rows);

	$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
	$result = sql_query($sql);

	$reply_limit = 6;
	$run = 0;
?>

<div class="tbl_head01 tbl_wrap mart30">
	<table>
	<colgroup>
		<col width="50">
		<col>
		<col width="90">
		<col width="50">
		<col width="50">
		<col width="90">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">제목</th>
		<th scope="col">작성자</th>
		<th scope="col">파일</th>
		<th scope="col">조회</th>
		<th scope="col">등록일</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$sql = " select * from shop_board_{$boardid} where btype = '1' {$sql_search2} order by fid desc ";
	$rst = sql_query($sql);
	for($i=0; $row=sql_fetch_array($rst); $i++) {
		$bo_subject	= cut_str($row['subject'], $board['list_cut']);
		$bo_wdate	= date("Y-m-d", $row['wdate']);

		if($row['fileurl1'] || $row['fileurl2'])
			$bo_file_yes ="<img src='".$bo_img_url."/img/file_on.gif'>";
		else
			$bo_file_yes ="<img src='".$bo_img_url."/img/file_off.gif'>";

		if((BV_SERVER_TIME-$row['wdate']) < (60*60*24))
			$bo_newicon = "&nbsp;<img src='".$bo_img_url."/img/iconY.gif'>";
		else
			$bo_newicon = "";

		$bo_href = './read.php?index_no='.$row['index_no'].'&'.$qstr1;
	?>
	<tr>
		<td class="tac"><img src="<?php echo $bo_img_url; ?>/img/notice.gif"></td>
		<td class="tal">
			<a href="<?php echo $bo_href; ?>"><b><?php echo $bo_subject; ?></b></a><?php if($row['issecret'] == 'Y') { ?>&nbsp;<img src="<?php echo $bo_img_url; ?>/img/icon_secret.gif"><?php } ?><?php if($row['tailcount']) { ?>&nbsp;<img src="<?php echo $bo_img_url; ?>/img/dot_cnum.gif">&nbsp;<span class="fc_197">(<?php echo $row['tailcount']; ?>)</span><?php } ?><?php echo $bo_newicon; ?>
		</td>
		<td class="tac"><?php echo $row['writer_s']; ?></td>
		<td class="tac"><?php echo $bo_file_yes; ?></td>
		<td class="tac"><?php echo $row['readcount']; ?></td>
		<td class="tac"><?php echo $bo_wdate; ?></td>
	</tr>
	<?php
		$run++;
	}

	for($i=0; $row=sql_fetch_array($result); $i++) {
		$bo_wdate = date("Y-m-d", $row['wdate']);

		if($row['fileurl1'] || $row['fileurl2'])
			$bo_file_yes ="<img src='".$bo_img_url."/img/file_on.gif'>";
		else
			$bo_file_yes ="<img src='".$bo_img_url."/img/file_off.gif'>";

		$spacer = strlen($row['thread'] != 'A');
		if($spacer > $reply_limit) {
			$spacer = $reply_limit;
		}

		$bo_subject = "";
		for($g=0; $g<$spacer; $g++) {
			$bo_subject .= "<img src='".$bo_img_url."/img/icon_reply.gif'>&nbsp;";
		}

		if($board['use_category'] == '1'  && $row['ca_name']) {
			$bo_subject .= '<strong>['.$row['ca_name'].']</strong>&nbsp;';
		}

		$bo_subject .= cut_str($row['subject'], $board['list_cut']);

		if((BV_SERVER_TIME-$row['wdate']) < (60*60*24))
			$bo_newicon = "&nbsp;<img src='".$bo_img_url."/img/iconY.gif'>";
		else
			$bo_newicon = "";

		$bo_href = './read.php?index_no='.$row['index_no'].'&'.$qstr1;
	?>
	<tr>
		<td class="tac"><?php echo $num--; ?></td>
		<td class="tal">
			<a href="<?php echo $bo_href; ?>"><?php echo $bo_subject; ?></a><?php if($row['issecret'] == 'Y') { ?>&nbsp;<img src="<?php echo $bo_img_url; ?>/img/icon_secret.gif"><?php } ?>&nbsp;<?php if($row['tailcount']) { ?><img src="<?php echo $bo_img_url; ?>/img/dot_cnum.gif">&nbsp;<span class="fc_197">(<?php echo $row['tailcount']; ?>)</span><?php } ?><?php echo $bo_newicon; ?>
		</td>
		<td class="tac"><?php echo $row['writer_s']; ?></td>
		<td class="tac"><?php echo $bo_file_yes; ?></td>
		<td class="tac"><?php echo $row['readcount']; ?></td>
		<td class="tac"><?php echo $bo_wdate; ?></td>
	</tr>
	<?php
		$run++;
	}
	?>
	<?php if(!$run) { ?>
	<tr><td colspan="6" class="empty_table">게시물이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="page_wrap">
	<div class="lbt_box">
		<a href="./list.php?<?php echo $qstr1; ?>" class="btn_lsmall bx-white">목록</a>
	</div>
	<?php if($member['grade'] <= $board['write_priv']) { ?>
	<div class="rbt_box">
		<a href="./write.php?boardid=<?php echo $boardid; ?>" class="btn_lsmall">글쓰기</a>
	</div>
	<?php } ?>
</div>

<form name="searchform" method="get">
<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
<div class="bottom_sch">
	<select name="sfl">
	<?php
	for($i=0;$i<sizeof($gw_search_value);$i++) {
		echo "<option value='{$gw_search_value[$i]}'".get_selected($gw_search_value[$i], $sfl).">{$gw_search_text[$i]}</option>\n";
	}
	?>
	</select>
	<input type="text" name="stx" class="frm_input" value="<?php echo $stx; ?>">
	<input type="submit" value="검색" class="btn_lsmall grey">
</div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, BV_BBS_URL.'/list.php?'.$qstr3.'&page=');
?>

<?php } else if($board['read_list']=='2') { ?>
<div class="tbl_frm01 tbl_wrap mart30">
	<table>
	<?php
	$sql = "select * from shop_board_{$boardid} where wdate > '{$write['wdate']}' {$sql_search2}";
	if($sfl && $stx)
		$sql .= " and $sfl like '%$stx%'";
	$sql .= " order by wdate asc limit 0,1";
	$res = sql_query($sql);
	if(sql_num_rows($res)) {
		$row = sql_fetch_array($res);
		$prev_no = $row['index_no'];
		$prev_subject = $row['subject'];
		$prev_tailcount = $row['tailcount'];
		$prev_href = "./read.php?index_no=$prev_no&boardid=$boardid$qstr&page=$page";
	?>
	<tr>
		<th width="15%">▲ 이전 글</th>
		<td width="85%"><a href="<?php echo $prev_href ?>"><?php echo $prev_subject; ?> [<?php echo $prev_tailcount; ?>]</a></td>
	</tr>
	<?php
	}

	$sql = "select * from shop_board_{$boardid} where wdate < '{$write['wdate']}' {$sql_search2}";
	if($sfl && $stx)
		$sql .= " and $sfl like '%$stx%'";
	$sql .= " order by wdate asc limit 0,1";
	$res = sql_query($sql);
	if(sql_num_rows($res)) {
		$row = sql_fetch_array($res);
		$next_no = $row['index_no'];
		$next_subject = $row['subject'];
		$next_tailcount = $row['tailcount'];
		$next_href = "./read.php?index_no=$next_no&boardid=$boardid$qstr&page=$page";
	?>
	<tr>
		<th width="15%">▼ 다음 글</th>
		<td width="85%"><a href="<?php echo $next_href ?>"><?php echo $next_subject; ?> [<?php echo $next_tailcount; ?>]</a></td>
	</tr>
	<?php } ?>
	</table>
</div>
<?php } ?>
