<div id="topMenu" class="container left">
  <nav class="cp-horizon-menu qk-menu">
    <div class="swiper-wrapper">
      <?php
				foreach ($gw_menu as $menu_item) {
					$menu_name  = $menu_item[0];
					$page_url   = BV_MURL . $menu_item[1];
					$page_param = parse_url($page_url, PHP_URL_QUERY);
					$menu_id    = '';
					if ($page_param) {
						parse_str($page_param, $query_params);
						$menu_id = isset($query_params['menu']) ? $query_params['menu'] : '';
					}

					echo '<a href="' . htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8') . '" data-id="' . htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8') . '" class="swiper-slide btn">' . htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8') . '</a>' . PHP_EOL;
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