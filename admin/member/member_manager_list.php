<?php // 담당직원 조회 추가 _20240621_SY
include_once("./_common.php");

$tb['title'] = '담당직원 조회';
include_once(BV_ADMIN_PATH."/admin_head.php");

$query_string = $qstr;
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_manager ";
$sql_search = " WHERE (1) ";

if($sfl) {
    // $sql_search .= " and id LIKE '%$sfl%' ";
    $allColumns = array("id", "name");
    $sql_search .= allSearchSql($allColumns,$sfl);
}

if(!$orderby) {
    $filed = "index_no";
    $sod = "desc";
} else {
	$sod = $orderby;
}

$sql_order = " order by $filed $sod ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt $sql_common $sql_search";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
// $num = $total_count - (($page-1)*$rows);
$num = (($page - 1) * $rows)+1;

// if(!empty($sfl)) {
  $sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
  $result = sql_query($sql);
  $total_count = $row['cnt'];
// }


?>

<h1 class="newp_tit"><?php echo $tb['title']; ?></h1>
<div class="new_win_body">
	<form name="fsearch" id="fsearch" method="get">
	<div class="guidebox tac">
		<b>직원사번 : </b> <input type="text" name="sfl" value="<?php echo $sfl; ?>" class="frm_input marr10">
		<input type="submit" value="검색" class="btn_small">
	</div>
	</form>

	<div class="local_ov mart20">
		전체 : <b class="fc_197"><?php echo number_format($total_count); ?></b> 건 조회
	</div>
	<div class="tbl_head01">
		<table>
		<colgroup>
			<col class="w50">
			<col class="w80">
			<col class="w80">
			<col class="w60">
		</colgroup>
		<thead>
		<tr>
			<th scope="col">번호</th>
			<th scope="col">직원사번</th>
			<th scope="col"><?php echo subject_sort_link('company_name',$q2); ?>사원명</a></th>
			<th scope="col">선택</th>
		</tr>
		</thead>
		<?php
		for($i=0; $row=sql_fetch_array($result); $i++) {
			if($i==0)
				echo '<tbody class="list">'.PHP_EOL;

			$bg = 'list'.($i%2);
      // 특수문자 인코딩 추가 _20240621_SY
      $data = json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
		?>
		<tr class="<?php echo $bg; ?>">
			<td><?php echo $num++; ?></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><button type="button" onclick='yes(<?php echo $data; ?>)' class="btn_small grey">선택</button></td>
		</tr>
		<?php
		}
		if($i==0)
			echo '<tbody><tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<?php
	echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
	?>
</div>

<script>
function yes(data) {
  
  if (typeof data === 'string') {
    data = JSON.parse(data);
  }
  
  // opener.document.fmemberform.mn_name.value = data.name;
  // opener.document.fmemberform.mn_idx.value = data.index_no;

  // form 이름 달라서 수정 _20240723_SY
  let forms = opener.document.forms;
  let targetForm = null;

  for (let i = 0; i < forms.length; i++) {
    if (forms[i].elements['mn_name'] && forms[i].elements['mn_idx']) {
        targetForm = forms[i];
        break;
    }
  }

  if (targetForm) {
      targetForm.mn_name.value = data.name;
      targetForm.mn_idx.value = data.index_no;
  } else {
      console.error('적절한 form을 찾을 수 없습니다.');
  }


  self.close();
}
</script>

<?php
include_once(BV_ADMIN_PATH.'/admin_tail.sub.php');
?>