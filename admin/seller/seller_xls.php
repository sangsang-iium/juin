<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fsellerexcel" id="fsellerexcel" method="post" onsubmit="return fsellerexcel_submit(this);" enctype="MULTIPART/FORM-DATA">

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">샘플파일 다운</th>
		<td>
            <div class="btn_wrap tal">
                <a href="<?php echo BV_LIB_URL; ?>/Excel/sellerexcel.xls" class="fbtn xls">
                    <span>샘플파일 다운로드</span>
                </a>
            </div>
        </td>
	</tr>
	<tr>
		<th scope="row">파일 업로드</th>
		<td>
            <div class="file_wrap">
                <input type="file" name="excelfile" class="uploadBtn">
            </div>
        </td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="공급사 일괄등록" class="btn_large">
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

<script>
function fsellerexcel_submit(f)
{
    if(!f.excelfile.value) {
        alert('(*.xls) 파일을 업로드해주십시오.');
        return false;
    }
	
	if(!f.excelfile.value.match(/\.(xls)$/i) && f.excelfile.value) {
        alert('(*.xls) 파일만 등록 가능합니다.');
        return false;
    }

	if(!confirm("공급사 일괄등록을 진행하시겠습니까?"))
		return false;
	
	f.action = bv_admin_url+"/seller.php?code=xls_update";
	return true;
}
</script>