<?
	require_once("./include.php");
	$debug = true  ;
	common_header( $debug ? "Developer Demo" : "eBay Demo" );
	$isShowLogo = false ; // show Canada Post Logo or not
	require_once( "./calculator.php" );
	common_footer();
?>