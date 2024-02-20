<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<?php if($board['fileurl1']) { ?>
<div class="m_bo_hd"><img src="<?php echo BV_DATA_URL; ?>/board/boardimg/<?php echo $board['fileurl1']; ?>"></div>
<?php } ?>

<div id="contents">

	<form name="searchform" method="get">
		<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
		<div class="bottom_sch">
			<div class="container">
				<select name="sfl">
				<?php
				for($i=0;$i<sizeof($gw_search_value);$i++) {
					echo "<option value='{$gw_search_value[$i]}'".get_selected($gw_search_value[$i], $sfl).">{$gw_search_text[$i]}</option>\n";
				}
				?>
				</select>
				<!-- <input type="text" name="stx" class="frm_input" value="<?php echo $stx; ?>">
				<input type="submit" value="검색" class="btn_small grey"> -->
				<div class="search">
					<input type="text" name="stx" class="w-per100 round100 keyword" value="<?php echo $stx; ?>" placeholder="검색어를 입력하세요.">
					<button type="submit" class="ui-btn submit" title="검색하기" value="검색"></button>
				</div>
			</div>
		</div>
	</form>

	<div class="txt-board-list" id="notice">
		<div class="container">

			<!-- 카테고리 사용 { -->
			<?php if($board['use_category']) { ?>
			<select name="faq_type" class="faq_sch" onchange="location=this.value;">
				<option value="<?php echo BV_MBBS_URL; ?>/board_list.php?boardid=<?php echo $boardid; ?>">전체보기</option>
				<?php
				for($i=0; $i<count($usecate); $i++) {
					$selected = "";
					if($usecate[$i]==$ca_name) {
						$selected = ' selected';
					}
				?>
				<option value="<?php echo BV_MBBS_URL; ?>/board_list.php?boardid=<?php echo $boardid; ?>&ca_name=<?php echo $usecate[$i]; ?>"<?php echo $selected; ?>><?php echo $usecate[$i]; ?></option>
				<?php } ?>
			</select>
			<?php } ?>
			<!-- } 카테고리 사용 -->

			<?php
			$li_run = 0;
			$li_str = '';

			$sql = " select * from shop_board_{$boardid} where btype = '1' {$add_search} order by fid desc ";
			$res = sql_query($sql);
			for($i=0; $row=sql_fetch_array($res); $i++) {
				$bo_href = BV_MBBS_URL.'/board_read.php?index_no='.$row['index_no'].'&boardid='.$boardid.'&page='.$page;
				$bo_subj = '<strong class="fc_eb7">[공지]</strong> '.get_text($row['subject']);
				// $bo_date = get_text($row['writer_s'])."<span class='padl10'>".date("y/m/d",$row['wdate']);
				$bo_date = date("Y.m.d",$row['wdate']);

				if((BV_SERVER_TIME - $row['wdate']) < (60*60*24)) {
					$bo_subj .= " <img src='{$bo_imgurl}/img/iconY.gif' class='marl3'>";
				}

				$li_str .= '<div class="txt-board-item">'.PHP_EOL;
				$li_str .= '	<a href="'.$bo_href.'" class="link">'.PHP_EOL;
				$li_str .= '	<p class="tRow1 tit">'.$bo_subj.'</p>'.PHP_EOL;
				$li_str .= '	<p class="date">'.$bo_date.'</p>'.PHP_EOL;
				$li_str .= '	</a>'.PHP_EOL;
				$li_str .= '</div>'.PHP_EOL;

				$li_run++;
			}

			for($i=0; $row=sql_fetch_array($result); $i++) {
				$bo_href = BV_MBBS_URL.'/board_read.php?index_no='.$row['index_no'].'&boardid='.$boardid.'&page='.$page;
				$bo_subj = '';
				$spacer = strlen($row['thread'] != 'A');
				if($spacer>$bo_reply_limit) {
					$spacer = $bo_reply_limit;
				}

				for($g=0; $g<$spacer; $g++) {
					$bo_subj = "<img src='{$bo_imgurl}/img/icon_reply.gif'> ";
				}

				if($board['use_category'] == '1'  && $row['ca_name']) {
					$bo_subj .= '<strong>['.$row['ca_name'].']</strong> ';
				}

				$bo_subj = $bo_subj .get_text($row['subject']);
				// $bo_date = get_text($row['writer_s'])."<span class='padl10'>".date("y/m/d",$row['wdate']);
				$bo_date = date("Y.m.d",$row['wdate']);

				if($row['issecret'] == 'Y') {
					$bo_subj .= " <img src='{$bo_imgurl}/img/icon_secret.gif'>";
				}

				if((BV_SERVER_TIME - $row['wdate']) < (60*60*24)) {
					$bo_subj .= " <img src='{$bo_imgurl}/img/iconY.gif'>";
				}

				$li_str .= '<div class="txt-board-item">'.PHP_EOL;
				$li_str .= '	<a href="'.$bo_href.'" class="link">'.PHP_EOL;
				$li_str .= '	<p class="tRow1 tit">'.$bo_subj.'</p>'.PHP_EOL;
				$li_str .= '	<p class="date">'.$bo_date.'</p>'.PHP_EOL;
				$li_str .= '	</a>'.PHP_EOL;
				$li_str .= '</div>'.PHP_EOL;

				$li_run++;
			}

			if($li_run > 0){
				// echo "<ul>\n{$li_str}</ul>\n";
				echo '<div class="txt-board-cnt">';
				echo '총 <span class="cnt">'.$li_run.'</span>건';
				echo '</div>';
				echo '<div class="txt-board">';
				echo $li_str;
				echo '</div>';
			}else{
				echo "<p class=\"empty_list\">게시글이 없습니다.</p>\n";
			}
			?>

			<?php if($member['grade'] <= $board['write_priv']) { ?>
			<div class="cp-btnbar__btns">
				<a href="<?php echo BV_MBBS_URL; ?>/board_write.php?boardid=<?php echo $boardid; ?>" class="ui-btn round stBlack">글쓰기</a>
			</div>
			<?php } ?>

			<?php
			echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?boardid='.$boardid.'&page=');
			?>

		</div>
	</div>

</div>