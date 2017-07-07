<?php
	#admin standard items
	if($_SESSION["domainID"] < 0) {
?>
	#siteLng {
		border: 1px solid #000;
		margin-left: 6px;
		padding: 2px 6px;
	}
	
	#lngContainer {
		height: 20px;
		left: 0;
		line-height: 20px;
		margin: 0 auto;
		position: absolute;
		right: 0;
		top: 35px;
		width: 170px;
		z-index: 10;
	}
	
.mobileNav ~ #lngContainer {
    position: fixed;
    z-index: 5001;
}
	
<?php
	}
?>

<?php
	#public standard items
	if($_SESSION["domainID"] > 0) {
?>

	#lngContainer{
		height: 20px;
		left: 550px;
		line-height: 20px;
		margin: 0 auto;
		position: absolute;
		right: 0;
		top: 20px;
		width: 170px;
		z-index:500;
	}

	.lngLink{
		display:block;
		width:62px;
		height:26px;
		padding-left: 35px;
   		padding-top: 2px;
		float:left;
		padding-left:37px;
		margin-right: 15px;
		text-decoration:none;
		box-sizing: border-box;

	}
	
	.lngPg{
		background:#252525;
		border-bottom:solid 2px #636363;
		border-right:solid 2px #636363;
		border-radius:20px;
	}
	
	#lngJP{
		background:url(/images/01-A-Yutaka-HOME-navigation-language-japanese.png) 7px center no-repeat;
	}

	#lngEN{
		background:url(/images/01-A-Yutaka-HOME-navigation-language-english.png) 7px center no-repeat;
	}

<?php
	}
?>