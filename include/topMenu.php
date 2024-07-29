<div id="topMenu" class="container left">
  <nav class="cp-horizon-menu qk-menu">
    <div class="swiper-wrapper">
      <?php // 카테고리 DB동기화 _20240612_SY
            // 날려도 될 것 같기도 _SY
          // $de_name_sql = "SELECT column_name
          //                  FROM information_schema.columns
          //                 WHERE TABLE_NAME = 'shop_default'
          //                   AND column_name REGEXP '^de_pname_[0-9]+$'";
          // $de_name_res = sql_query($de_name_sql);

          // $de_name_columns = [];
          // while ($row = sql_fetch_array($de_name_res)) {
          //   $de_name_columns[] = $row['column_name'];
          // }

          // foreach ($gw_menu as $k) {
          //   $value = $k[0];
          //   $found_column = null;

          //   foreach ($de_name_columns as $column) {
          //     $column_value_sql = "SELECT `$column` FROM shop_default WHERE `$column` = '$value'";
          //     $column_value_result = sql_query($column_value_sql);

          //     if (sql_num_rows($column_value_result) > 0) {
          //         $found_column = $column;
          //         break;
          //     }
          //   }

          //   if ($found_column) {
          //     $use_column = str_replace('de_pname_', 'de_pname_use_', $found_column);
          //     $val_column = str_replace('de_pname_use_', 'de_pname_', $found_column);
          //     $use_column_value_sql = "SELECT `$use_column`, `$val_column` FROM shop_default WHERE `$use_column` = '1'";
          //     $use_column_value_result = sql_query($use_column_value_sql);

          //     while ($row = sql_fetch_array($use_column_value_result)) {
          //       $found_menu = null;
          //       foreach ($gw_menu as $menu_item) {
          //         if ($menu_item[0] == $row[$val_column]) {
          //           $found_menu = $menu_item;
          //           break;
          //         }
          //       }

          //       if ($found_menu) {
          //         $menu_name = $found_menu[0];
          //         $page_url = BV_MURL . $found_menu[1];
          //         $page_param = parse_url($page_url, PHP_URL_QUERY);
          //         $menu_id = '';
          //         if ($page_param) {
          //           parse_str($page_param, $query_params);
          //           $menu_id = isset($query_params['menu']) ? $query_params['menu'] : '';
          //         }

          //         echo '<a href="' . htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') . '" data-id="' . htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8') . '" class="swiper-slide btn">' . htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8') . '</a>' . PHP_EOL;
          //       }
          //     }
          //   }
          // }

				// foreach ($gw_menu as $menu_item) {
				// 	$menu_name  = $menu_item[0];
				// 	$page_url   = BV_MURL . $menu_item[1];
				// 	$page_param = parse_url($page_url, PHP_URL_QUERY);
				// 	$menu_id    = '';
				// 	if ($page_param) {
				// 		parse_str($page_param, $query_params);
				// 		$menu_id = isset($query_params['menu']) ? $query_params['menu'] : '';
				// 	}

				// 	echo '<a href="' . htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') . '" data-id="' . htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8') . '" class="swiper-slide btn">' . htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8') . '</a>' . PHP_EOL;
				// }


        /* ------------------------------------------------------------------------------------- _20240713_SY
          * 기획전 링크 추가
        /* ------------------------------------------------------------------------------------- */
        // echo '<a href="/shop/plan.php?menu=exhibition" data-id="" class="swiper-slide btn">상품기획전</a>' . PHP_EOL;

        $sql_menu = "SELECT * FROM shop_menu WHERE m_yn = 'Y' ORDER BY m_seq DESC";
        $res_menu = sql_query($sql_menu);

        for ($i = 0; $mRow = sql_fetch_array($res_menu); $i++) {
          echo "<a href='{$mRow['m_url']}' data-id='' class='swiper-slide btn'>{$mRow['m_name']}</a>" . PHP_EOL;
        }
			?>
    </div>
  </nav>
</div>

<script type="module">
import * as f from '/src/js/function.js';

//Top Menu
let quickMenuActive = '<?php echo $_GET['menu']?>';
const quickMenuTarget = '#topMenu .qk-menu';
const quickMenu = f.hrizonMenu(quickMenuTarget, quickMenuActive);
</script>