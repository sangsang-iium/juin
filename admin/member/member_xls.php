<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fmemberexcel" id="fmemberexcel" method="post" onsubmit="return fmemberexcel_submit(this);" enctype="MULTIPART/FORM-DATA">

<div class="board_table">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">샘플파일 다운</th>
		<td>
            <div class="btn_wrap tal">
                <a href="<?php echo BV_LIB_URL; ?>/Excel/memberexcel.xls" class="dwn">
                    <span>샘플파일 다운로드</span>
                </a>
            </div>
        </td>
	</tr>
	<tr>
		<th scope="row">파일 업로드</th>
		<td>
            <div class="file_wrap">
                <label for="excelfile" class="hide">파일선택</label>
                <input type="file" name="excelfile" class="uploadBtn">
            </div>
        </td>
	</tr>
	</tbody>
	</table>
</div>
<div class="board_btns tac mart20">
    <div class="btn_wrap">
        <input type="submit" value="회원 일괄등록" class="btn_acc">
    </div>
</div>
</form>

<div class="text_box btn_type mart50">
    <h5 class="tit">도움말</h5>
    <ul class="cnt_list step01">
        <li>엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</li>
        <li>엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong>로 저장하셔야 합니다.</li>
        <li>엑셀데이터는 4번째 라인부터 저장되므로 샘플파일 설명글과 타이틀은 지우시면 안됩니다.</li>
    </ul>
</div>
<!-- <div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</p>
			<p>ㆍ엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong>로 저장하셔야 합니다.</p>
			<p>ㆍ엑셀데이터는 4번째 라인부터 저장되므로 샘플파일 설명글과 타이틀은 지우시면 안됩니다.</p>
		</div>
	 </div>
</div> -->

<script>
function fmemberexcel_submit(f)
{
    if(!f.excelfile.value) {
        alert('(*.xls) 파일을 업로드해주십시오.');
        return false;
    }
	
	if(!f.excelfile.value.match(/\.(xls)$/i) && f.excelfile.value) {
        alert('(*.xls) 파일만 등록 가능합니다.');
        return false;
    }

	if(!confirm("회원 일괄등록을 진행하시겠습니까?"))
		return false;
	
	f.action = bv_admin_url+"/member.php?code=xls_update";
	return true;
}
</script>
