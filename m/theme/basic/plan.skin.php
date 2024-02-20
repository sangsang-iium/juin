<?php
if(!defined('_BLUEVATION_')) exit;
?>

<div id="contents" class="sub-contents exhibList">
  <div class="container exhib-dp">
    <div class="exhib-dp-wrap">
      <div class="exhib-dp-ct">
        <?php
        $sql = "select * from shop_goods_plan where mb_id IN('admin','$pt_id') and pl_use = '1' ";
        $res = sql_query($sql);
        for($i=0; $row=sql_fetch_array($res); $i++) {
          $href = BV_MSHOP_URL.'/planlist.php?pl_no='.$row['pl_no'];
          $bimg = BV_DATA_PATH.'/plan/'.$row['pl_limg'];
          if(is_file($bimg) && $row['pl_limg']) {
            $pl_limgurl = rpc($bimg, BV_PATH, BV_URL);
          } else {
            $pl_limgurl = BV_IMG_URL.'/plan_noimg.gif';
          }
        ?>
        <a href="<?php echo $href; ?>" class="exhib-item">
          <div href="<?php echo $href; ?>" class="cp-banner__round thumb">
            <img src="<?php echo $pl_limgurl; ?>" alt="" class="fitCover">
          </div>
          <div class="exhib-info">
            <p class="tRow2 subj"><?php echo $row['pl_name']; ?></p>
            <p class="ex">
              <span class="tag on">진행</span>
              <span class="period">2024.01.01~2024.12.31</span>
            </p>
          </div>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>