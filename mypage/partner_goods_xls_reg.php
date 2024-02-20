<?php
if(!defined('_BLUEVATION_')) exit;

if(!$pf_auth_good)
	alert('개별 상품판매 권한이 있어야만 이용 가능합니다.');

$pg_title = "상품 엑셀일괄등록";
include_once("./admin_head.sub.php");
?>

<form name="fitemexcel" id="fitemexcel" method="post" onsubmit="return fitemexcel_submit(this);" enctype="MULTIPART/FORM-DATA">

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
			<a href="<?php echo BV_LIB_URL; ?>/Excel/itemexcel2.xls" class="btn_small bx-blue"><i class="fa fa-download"></i> 샘플파일 다운로드</a>
			<a href="<?php echo BV_ADMIN_URL; ?>/category/category_excel.php" class="btn_small bx-white"><i class="fa fa-file-excel-o"></i> 카테고리 엑셀다운로드</a>
		</td>
	</tr>
	<tr>
		<th scope="row">파일 업로드</th>
		<td><input type="file" name="excelfile"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="상품 일괄등록" class="btn_large">
</div>
</form>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</p>
			<p>ㆍ엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong>로 저장하셔야 합니다.</p>
			<p>ㆍ엑셀데이터는 4번째 라인부터 저장되므로 샘플파일 설명글과 타이틀은 지우시면 안됩니다.</p>
		</div>
	 </div>
</div>

<script>
function fitemexcel_submit(f)
{
    if(!f.excelfile.value) {
        alert('(*.xls) 파일을 업로드해주십시오.');
        return false;
    }

	if(!f.excelfile.value.match(/\.(xls)$/i) && f.excelfile.value) {
        alert('(*.xls) 파일만 등록 가능합니다.');
        return false;
    }

	if(!confirm("상품 일괄등록을 진행하시겠습니까?"))
		return false;

	f.action = "./page.php?code=partner_goods_xls_reg_update";
	return true;
}
</script>

<?php
include_once("./admin_tail.sub.php");
?>