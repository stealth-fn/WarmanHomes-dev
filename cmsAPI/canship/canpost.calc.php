<?
	require_once("./include.php");
	$debug = submit("debug")==1 ? true : false ;
	$isShowLogo = true ; // show Canada Post Logo or not
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>A Free Canada Post Shipping Calculator</title>
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="main.css">
	<meta name="keywords" content="Shipping Calculator, Rate Calculator, Calculation, eParcel, Canada Post, PHP, Shipping Module, eBay, Merchant Tools, e-Commerce, Online Shopping, Online Transaction, Real time, Shipping Quote, XML, Web Service, Free Shipping, Shipping Quoter, Open Source, osCommerce, Shopping Cart, Vancouver, British Columbia, Shopping Basket, Package, Free Packaging, Width, Height, Weight, Length, International, Domestic,USA, Fedex, UPS,Expedited, Xpresspost,Priority Courier,Air Parcel, Surface, Sell Online, API, French, Shipping Rate ">
	<meta name="description" content="
	Canada Post Shipping Rate Calculator - A free PHP shipping calculator for all shipping purpose, including eBay merchants, ecommerce sites.
	This tool is developed by using API of Sell Online(tm) Shipping Module from Canada Post. Once you get a retail account from Canada Post,
	you can setup your shipping profile throught their backend.
	">
</head>

<body>
<br>
<div align="center">
<?
	require_once( "./calculator.php" );
	print COPYRIGHT ;
?>

</div>
</body>
</html>