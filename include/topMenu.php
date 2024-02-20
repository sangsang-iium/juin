<div id="topMenu" class="container left">
  <nav class="cp-horizon-menu qk-menu">
    <div class="swiper-wrapper">
      <?php
			for($i=0; $i<count($gw_menu); $i++) {
				$seq = ($i+1);
				$page_url = BV_MURL.$gw_menu[$i][1];
        $page_param = parse_url($page_url, PHP_URL_QUERY);
        parse_str($page_param, $menu_id);
				if(!$default['de_pname_use_'.$seq] || !$default['de_pname_'.$seq])
					continue;

				echo '<a href="'.$page_url.'" data-id="'.$menu_id['menu'].'" class="swiper-slide btn">'.$default['de_pname_'.$seq].'</a>'.PHP_EOL;
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