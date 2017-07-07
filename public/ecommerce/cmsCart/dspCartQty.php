<?php
	if(!isset($_SESSION))session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/products/products.php');
	$productsObj = new products(false);
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
	$cmsCartObj = new cmsCart(false);
?>

<div id="dspCartItemQty">
	<a
		href="/index.php?pageID=<?php echo $productsObj->cartPageID; ?>"
		id="topViewCart"
		onclick="atpto_tNav.toggleBlind('<?php echo $productsObj->cartPageID; ?>',true,0,'upc(<?php echo $productsObj->cartPageID; ?>,&#34;&#34;);','ntid_tNav<?php echo $productsObj->cartPageID; ?>',event);return false"
	>VIEW CART</a>
	<div id="cartQty">
	<?php echo $productsObj->dspCartPrefix; ?>
	<span id="innertCartQty">
		<?php echo $cmsCartObj->getCartItemQty(); ?>
	</span>
	<?php echo $productsObj->dspCartSuffix; ?>
	</div>
	<div id="cartSubtotal">
		<?php echo $productsObj->currencySymbol; ?><span id="innertCartSubTotal"><?php echo $cmsCartObj->getCartProductTotal(); ?></span>
	</div>
</div>