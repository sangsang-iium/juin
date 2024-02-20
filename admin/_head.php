<?php
if(!defined('_BLUEVATION_')) exit;

// 회원 CRM 탭메뉴
function mb_pg_anchor($mb_id) {
?>
<ul class="anchor">
	<li><a href="./pop_memberform.php?mb_id=<?php echo $mb_id; ?>">회원정보수정</a></li>
	<?php if(is_seller($mb_id)) { ?>
	<li><a href="./pop_sellerform.php?mb_id=<?php echo $mb_id; ?>">공급사정보수정</a></li>
	<li><a href="./pop_sellerorder.php?mb_id=<?php echo $mb_id; ?>">공급사판매내역</a></li>
	<?php } ?>
	<li><a href="./pop_memberorder.php?mb_id=<?php echo $mb_id; ?>">주문내역</a></li>
	<li><a href="./pop_memberpoint.php?mb_id=<?php echo $mb_id; ?>">포인트</a></li>
</ul>
<?php
}
?>