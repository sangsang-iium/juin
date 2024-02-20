<?php
if(!defined('_BLUEVATION_')) exit;

	if(!defined('NO_CONTAINER')) {
		echo '</div>'.PHP_EOL;
	}
	?>
</div>
<div id="ft">
	<p>Copyright &copy; <?php echo $config['company_name']; ?>. All rights reserved.</p>
</div>

<?php
include_once(BV_ADMIN_PATH.'/admin_tail.sub.php');
?>