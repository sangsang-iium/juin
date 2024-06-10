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

$sql_common = " from shop_used ";
$sql_search = " where del_yn = 'N' ";

if ($sfl && $stx) {
  $sql_search .= " and $sfl like '%$stx%' ";
}

// 기간검색
if ($fr_date && $to_date) {
  $sql_search .= " and regdate between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
} else if ($fr_date && !$to_date) {
  $sql_search .= " and regdate between '$fr_date 00:00:00' and '$fr_date 23:59:59' ";
} else if (!$fr_date && $to_date) {
  $sql_search .= " and regdate between '$to_date 00:00:00' and '$to_date 23:59:59' ";
}

// 팝니다/삽니다
if(is_numeric($gubun)){
    $sql_search .= " and gubun = '$gubun' ";
}

$sql_order = " order by no desc ";

// 테이블의 전체 레코드수만 얻음
$sql         = " select count(*) as cnt $sql_common $sql_search ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$rows       = 15;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {$page = 1;}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
$num         = $total_count - (($page - 1) * $rows);

$sql    = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$colspan  = 12;

$btn_frmline = <<<EOF
<a href="#none" class="fr btn_lsmall" style="float:left;" onclick="chkDelete();">선택삭제</a>
<a href="./used.php?code=form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 상품등록</a>
EOF;

$q1 = "code=".$code."&gubun=".$gubun.$qstr;
$q2 = "&gubun=".$gubun.$qstr."&page=".$page;

include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
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
                        <?php echo option_selected('content', $sfl, '내용'); ?>
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
	<tr>
	    <th scope="row">구분검색</th>
	    <td>
	        <ul class="radio_group">
	            <li class="radios"><input type="radio" name="gubun" value="" id="gubun1"<?php echo ($gubun=='') ? ' checked' : '';?>><label for="gubun1">전체</label></li>
	            <li class="radios"><input type="radio" name="gubun" value="0" id="gubun2"<?php echo ($gubun=='0') ? ' checked' : '';?>><label for="gubun2">팝니다</label></li>
	            <li class="radios"><input type="radio" name="gubun" value="1" id="gubun3"<?php echo ($gubun=='1') ? ' checked' : '';?>><label for="gubun3">삽니다</label></li>
	        </ul>
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

<div class="local_ov mart30">
	총 상품수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col class="w100">
		<col>
		<col class="w100">
		<col class="w100">
		<col class="w60">
		<col class="w60">
		<col class="w60">
		<col class="w100">
		<col class="w200">
		<col class="w110">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" class="allchk"></th>
		<th scope="col">No</th>
		<th scope="col">유형</th>
		<th scope="col">제목</th>
		<th scope="col">상태</th>
		<th scope="col">분류</th>
		<th scope="col">조회수</th>
		<th scope="col">댓글수</th>
		<th scope="col">관심</th>
		<th scope="col">등록자</th>
		<th scope="col">등록일시</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for ($i = 0; $row = sql_fetch_array($result); $i++) {
		if ($i == 0) {
			echo '<tbody class="list">' . PHP_EOL;
		}

  	    $bg = 'list' . ($i % 2);
  	    $gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
    ?>
	<tr class="<?php echo $bg; ?>">
	    <td><input type="checkbox" class="chk" data-no="<?php echo $row['no']; ?>"></td>
		<td><?php echo $num--; ?></td>
		<td><?php echo $gubun_status[0]; ?></td>
		<td class="tal"><?php echo $row['title']; ?></td>
		<td><?php echo $gubun_status[1]; ?></td>
		<td><?php echo $row['category']; ?></td>
		<td><?php echo $row['hit']; ?></td>
		<td><?php echo getUsedCommentCount($row['no']); ?></td>
		<td><?php echo getUsedGoodCount($row['no']); ?></td>
		<td><?php echo $row['mb_id']; ?></td>
		<td><?php echo $row['regdate']; ?></td>
		<td>
		    <a href="<?php echo BV_ADMIN_URL.'/used.php?code=view&no='.$row['no'].$q2; ?>" class="btn_ssmall red">상세</a> &nbsp; &nbsp;
			<a href="<?php echo BV_ADMIN_URL.'/used.php?code=form&no='.$row['no'].$q2; ?>" class="btn_ssmall">수정</a>
		</td>
	</tr>
	<?php
    }
	if ($i == 0) {
		echo '<tbody><tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
	}
?>
	</tbody>
	</table>
</div>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $q1 . '&page=');
?>

<script>
$(document).ready(function(){
    $(".allchk").click(function(){
        if($(this).is(":checked")){
            $(".chk").prop("checked", true);
        } else {
            $(".chk").prop("checked", false);
        }
    });
});

function chkDelete(){
	var no = [];
    $(".chk").each(function(){
        if($(this).is(":checked")){
            no.push($(this).data("no"));
        }
    });
    
    if(no.length == 0){
        alert("삭제하실 게시글을 1개이상 선택하세요.");
    }

    if(confirm("선택하신 게시글을 삭제하시겠습니까?\n삭제하시면 복구하실 수 없습니다.")){
        var nos = no.join('|');
        $.post(bv_admin_url+"/used/ajax.used.del.php", {nos:nos}, function(obj){
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
</script>
