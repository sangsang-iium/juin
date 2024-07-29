<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents">
	<div class="container">

		<div class="txt-board-view" id="notice">
			<div class="tb-view-title">
				<p class="tit">
          <?php
          if($write['btype'] != '1') {
            echo $bo_subject;
          } else {
            echo '<strong class="fc_eb7">[공지]</strong> '.$bo_subject;
          }
          ?>
        </p>
				<p class="date"><?php echo $bo_wdate; ?></p>
			</div>
			<div class="tb-view-cont">
				<p>
					<?php
					$file1 = BV_DATA_PATH."/board/{$boardid}/{$write['fileurl1']}";
					if(is_file($file1) && preg_match("/\.(gif|jpg|png)$/i", $write['fileurl1'])) {
						$file1 = rpc($file1, BV_PATH, BV_URL);
					?>
					<img src="<?php echo $file1; ?>" class="img_fix">
					<?php } ?>
					<?php
					$file2 = BV_DATA_PATH."/board/{$boardid}/{$write['fileurl2']}";
					if(is_file($file2) && preg_match("/\.(gif|jpg|png)$/i", $write['fileurl2'])) {
						$file2 = rpc($file2, BV_PATH, BV_URL);
					?>
					<img src="<?php echo $file2; ?>" class="img_fix">
					<?php } ?>
					<?php echo conv_content($write['memo'], 2); ?>
				</p>
			</div>
			<!-- 이전글 / 다음글 개발 필요 { -->
			<div class="tb-nb">
      <?php
        $sql = "SELECT * FROM shop_board_{$boardid} WHERE wdate > '{$write['wdate']}' {$sql_search2}";
        if($sfl && $stx)
          $sql .= " and $sfl like '%$stx%'";
        $sql .= " order by wdate asc limit 0,1";
        $res = sql_query($sql);
        if(sql_num_rows($res)) {
          $row = sql_fetch_array($res);
          $prev_no = $row['index_no'];
          $prev_subject = $row['subject'];
          $prev_tailcount = $row['tailcount'];
          $prev_href = "./board_read.php?index_no=$prev_no&boardid=$boardid$qstr&page=$page";
        ?>
				<div class="tb-nb-item tb-nb-prv">
					<p class="nb-tit">이전글</p>
					<a href="<?php echo $prev_href ?>" class="tRow1 link">
						<?php echo $prev_subject; ?>
					</a>
				</div>
      <?php }
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
          $next_href = "./board_read.php?index_no=$next_no&boardid=$boardid$qstr&page=$page";
      ?>
				<div class="tb-nb-item tb-nb-nxt">
					<p class="nb-tit">다음글</p>
					<a href="<?php echo $next_href ?>" class="tRow1 link">
            <?php echo $next_subject; ?>
					</a>
				</div>
      <?php } ?>
			</div>
			<!-- } 이전글 / 다음글 개발 필요 -->

			<div class="cp-btnbar__btns">
				<a href="<?php echo BV_MBBS_URL; ?>/board_list.php?<?php echo $qstr1; ?>" class="ui-btn round stBlack">목록</a>
				<?php if($member['grade']<=$board['reply_priv'] && $board['usereply']=='Y') { ?>
				<div class="s-btn-box">
					<a href="<?php echo BV_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=r" class="ui-btn round stWhite">답변</a>
					<?php } if(($mb_no == $write['writer']) || is_admin()) { ?>
					<a href="<?php echo BV_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=u" class="ui-btn round stWhite">수정</a>
					<a href="<?php echo BV_MBBS_URL; ?>/board_delete.php?<?php echo $qstr2; ?>" class="ui-btn round stWhite">삭제</a>
				</div>
				<?php } ?>
			</div>
		</div>

		<!-- <div class="m_bo_bg mart10">
			<div class="title"><?php echo $bo_subject; ?></div>
			<div class="wr_name"><?php echo $write['writer_s']; ?><span class="wr_day"><?php echo $bo_wdate; ?></span></div>
			<div class="wr_txt">
				<?php
				$file1 = BV_DATA_PATH."/board/{$boardid}/{$write['fileurl1']}";
				if(is_file($file1) && preg_match("/\.(gif|jpg|png)$/i", $write['fileurl1'])) {
					$file1 = rpc($file1, BV_PATH, BV_URL);
				?>
				<img src="<?php echo $file1; ?>" class="img_fix">
				<?php } ?>
				<?php
				$file2 = BV_DATA_PATH."/board/{$boardid}/{$write['fileurl2']}";
				if(is_file($file2) && preg_match("/\.(gif|jpg|png)$/i", $write['fileurl2'])) {
					$file2 = rpc($file2, BV_PATH, BV_URL);
				?>
				<img src="<?php echo $file2; ?>" class="img_fix">
				<?php } ?>

				<div class="img_fix2">
					<?php echo conv_content($write['memo'], 1); ?>
				</div>
			</div>
		</div>

		<div class="btn_confirm">
			<a href="<?php echo BV_MBBS_URL; ?>/board_list.php?<?php echo $qstr1; ?>" class="btn_medium bx-white">목록</a>
			<?php if($member['grade']<=$board['reply_priv'] && $board['usereply']=='Y') { ?>
			<a href="<?php echo BV_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=r" class="btn_medium bx-white">답변</a>
			<?php } if(($mb_no == $write['writer']) || is_admin()) { ?>
			<a href="<?php echo BV_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=u" class="btn_medium bx-white">수정</a>
			<a href="<?php echo BV_MBBS_URL; ?>/board_delete.php?<?php echo $qstr2; ?>" class="btn_medium bx-white">삭제</a>
			<?php } ?>
		</div> -->

	</div>
</div>