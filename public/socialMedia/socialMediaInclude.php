<?php
	#create our CMS url query string
	include($_SERVER['DOCUMENT_ROOT'] . "/public/moduleFrame/requestString.php");
?>

<div class="socialMediaContainer">
	<span 
		class='st_sharethis_large' 
		displayText='ShareThis' 
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	>
	</span>
	<span 
		class='st_facebook_large' 
		displayText='Facebook'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	></span>
	<span 
		class='st_googleplus_large' 
		displayText='Google Plus'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	></span>
	<span 
		class='st_twitter_large' 
		displayText='Tweet'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	>
	</span>
	<span 
		class='st_linkedin_large' 
		displayText='LinkedIn'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	></span>
	<span 
		class='st_pinterest_large' 
		displayText='Pinterest'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	></span>
	<span 
		class='st_email_large' 
		displayText='Email'
		<?php include($_SERVER['DOCUMENT_ROOT'] . "/public/socialMedia/shareThisParams.php"); ?>
	>
	</span>
</div>

<div id="facebookLikeContainer">
	<span id="facebookLikeText">Like this on Facebook: </span>
	<iframe id="facebookLikeFrame" src="/public/socialMedia/facebookLike.php?shareURL=<?php echo $_GET["recordUrl"]; ?>"
	scrolling="no" frameborder="0" style="border:none;
	overflow:hidden;width:450px; height:35px;" allowTransparency="true"></iframe>
</div>