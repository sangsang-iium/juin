<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_mail ";
$sql_search = " where (1) ";
$sql_order  = " order by ma_id desc ";

if($sfl && $stx) {
    $sql_search .= " and $sfl like '%$stx%' ";
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
<a href="./member.php?code=mail_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 메일내용추가</a>
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
        <select name="sfl" id="sfl">
            <option value="ma_subject" checked>제목</option>
        </select>
        </div>
        <label for="stx" class="sound_only">검색어</label>
        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input" size="30">
        </div>
    </td>
</tr>
</tbody>
</table>
<div class="board_btns tac mart20">
    <div class="btn_wrap btn_type">
        <input type="submit" value="검색" class="btn_acc marr10">
        <input type="button" value="초기화" id="frmRest" class="btn_cen">
    </div>
</div>
</form>


<form name="fmaillist" id="fmaillist" method="post" action="./member/member_mail_list_delete.php" onsubmit="return fmaillist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30 fs18">
	총 메일수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>건
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="board_list">
	<table class="list01">
		<col class="w50">
		<col class="w100">
		<col>
		<col class="w300">
		<col class="w150">
		<col class="w150">
		<col class="w300">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">
			<label for="chkall" class="sound_only">전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form);">
		</th>
		<th scope="col">번호</th>
		<th scope="col">제목</th>
		<th scope="col">작성일시</th>
		<th scope="col">테스트</th>
		<th scope="col">보내기</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$ma_id = $row['ma_id'];
		$ma_subject = get_text($row['ma_subject']);

		$s_frm = "<a href=\"".BV_ADMIN_URL."/member.php?code=mail_select_form&ma_id=$ma_id$qstr&page=$page\" class=\"go\"><span>보내기</span></a>";
		$s_upd = "<a href=\"".BV_ADMIN_URL."/member.php?code=mail_form&w=u&ma_id=$ma_id$qstr&page=$page\" class=\"btn_fix\"><span>수정</span></a>";

		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="ma_id[<?php echo $i; ?>]" value="<?php echo $ma_id; ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $ma_subject; ?> 메일</label>
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>" id="chk_<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td class="tal"><?php echo $ma_subject; ?></td>
		<td><?php echo $row['ma_time']; ?></td>
		<td>
            <div class="btn_wrap">
                <a href="<?php echo BV_ADMIN_URL; ?>/member/member_mail_test.php?ma_id=<?php echo $ma_id; ?>" class="go">
                    <span>테스트</span>
                </a>
            </div>
        </td>
		<td>
            <div class="btn_wrap">
                <?php echo $s_frm; ?>
            </div>
        </td>
		<td>
            <div class="btn_wrap btn_type">
                <?php echo $s_upd; ?>
                <a href="<?php echo BV_ADMIN_URL; ?>/member/member_mail_preview.php?ma_id=<?php echo $ma_id; ?>" target="_blank" class="detail marl10"><span>보기</span></a>
            </div>
		</td>
	</tr>
	<?php
	}
	if($i==0)
		echo '<tbody><tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
<form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>
<div class="text_box btn_type mart50">
    <h5 class="tit">도움말</h5>
    <ul class="cnt_list step01">
        <li><b>테스트</b>는 등록된 최고관리자의 이메일로 테스트 메일을 발송합니다.</li>
        <li class="fc_red">주의) 수신자가 동의하지 않은 대량 메일 발송에는 적합하지 않습니다. 수십건 단위로 발송해 주십시오.</li>
    </ul>
</div>
<!-- <div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ<b>테스트</b>는 등록된 최고관리자의 이메일로 테스트 메일을 발송합니다.</p>
			<p class="fc_red">ㆍ주의) 수신자가 동의하지 않은 대량 메일 발송에는 적합하지 않습니다. 수십건 단위로 발송해 주십시오.</p>
		</div>
	</div>
</div> -->

<script>
function fmaillist_submit(f)
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
