<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<h2 class="pop_title">
	<?php echo $tb['title']; ?> <span class="fc_red">(<?php echo number_format($total_count); ?>)</span>
	<!-- <a href="javascript:cl_list();" class="btn_small bx-white">전체상품보기</a> -->
	<a class="btn_small bx-white rv-all-close">전체상품보기</a>
</h2>

<div id="sit_review">
	<table class="tbl_review">
	<colgroup>
		<col width="80px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<td class="image"><?php echo get_it_image($gs_id, $gs['simg1'], 80, 80); ?></td>
		<td class="gname">
			<?php echo get_text($gs['gname']); ?>
			<p class="bold mart5"><?php echo mobile_price($gs_id); ?></p>
		</td>
	</tr>
	</tbody>
	</table>

	<?php
	echo "<ul>\n";
	for($i=0; $row=sql_fetch_array($result); $i++)
	{
		$wr_star = $gw_star[$row['score']];
		$wr_id   = substr($row['mb_id'],0,3).str_repeat("*",strlen($row['mb_id']) - 3);
		$wr_time = substr($row['reg_time'],0,10);

		$hash = md5($row['index_no'].$row['reg_time'].$row['mb_id']);

		//상단 {
    echo "<div class='rv-item'>";
    echo "<div class='rv-top'>";
    echo "<div class='left'>";
    echo "<div class='point'>";
    echo "<img src='/src/img/icon-point".$row['score'].".svg' alt=''>";
    echo "</div>";
    echo "<p class='name'>$wr_id</p>";
    echo "</div>";
    echo "<div class='right'>";
    echo "<p class='date'>$wr_time</p>";
    echo "</div>";
    echo "</div>";
    // } 상단

    // 옵션이 있다면 {
    echo "<div class='rv-option-wr'>";
    echo "<div class='rv-option-item'>";
    echo "<p class='tit'>옵션</p>";
    echo "<p class='cont'>옵션내용 표시</p>";
    echo "</div>";
    echo "<div class='rv-option-item'>";
    echo "<p class='tit'>옵션2</p>";
    echo "<p class='cont'>옵션내용2 표시</p>";
    echo "</div>";
    echo "</div>";
    // } 옵션이 있다면

    //내용 {
    echo "<div class='rv-content-wr'>";

    //이미지가 있다면 {
    echo "<div class='rv-img-list'>";
    echo "<div class='rv-img-item'>";
    echo "<div class='rv-img'>";
    echo "<img src='/src/img/pd-rv-img01.png' alt=''>";
    echo "</div>";
    echo "</div>";
    echo "<div class='rv-img-item'>";
    echo "<div class='rv-img'>";
    echo "<img src='/src/img/pd-rv-img02.png' alt=''>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    // } 이미지가 있다면

    echo "<div class='content'>$row[memo]</div>";
    echo "<button type='button' class='cont-more-btn'>더보기+</button>";
    echo "</div>";

    if(is_admin() || ($member['id'] == $row['mb_id'])) { // 수정, 삭제 버튼
      echo "<div class='mngArea'>";
      echo "<a href=\"javascript:window.open('".BV_MSHOP_URL."/orderreview.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=u');\" class='ui-btn st3'>수정</a>";
      echo "<a href=\"".BV_MSHOP_URL."/orderreview_update.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=d&hash=$hash&p=1\" class='ui-btn st3 itemqa_delete'>삭제</a>";
      echo "</div>";
    }
    // } 내용

    // 수정 팝업 변환
    echo '<div class="popup type01" id="">';
    echo '<div class="pop-inner">';
    echo '<div class="pop-top">';
    echo '<p class="tit">팝업 제목</p>';
    echo '</div>';
    echo '<div class="pop-content">';
    include_once(BV_MSHOP_URL."/orderreview.php");
    echo '</div>';
    echo '<div class="pop-btm">';
    echo '<button type="button" class="btn">취소</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo "</div>\n";
	}

	if($i == 0) {
		echo "<div class='empty_box'>자료가 없습니다</div>\n";
	}

	echo "</ul>\n";

	echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
	?>
	<div class="btn_confirm">
		<a href="javascript:window.open('<?php echo BV_MSHOP_URL; ?>/orderreview.php?gs_id=<?php echo $gs_id; ?>');" class="btn_medium">구매후기쓰기</a>
		<a href="javascript:window.close();" class="btn_medium bx-white rv-all-close">창닫기</a>
	</div>
</div>

<script>
  function cl_list(){
    opener.location.href = bv_mobile_shop_url+'/list.php?ca_id=<?php echo $gs[ca_id]; ?>';
    window.close();
  }

  // 삭제
  $(function(){
      $(".itemqa_delete").click(function(){
          return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
      });
  });
</script>
