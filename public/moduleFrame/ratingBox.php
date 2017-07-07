<?php
	#determin and set the rating for this set
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/module/moduleRecordRating.php');
	$moduleRecordRatingObj = new moduleRecordRating(false, NULL);
	$key = $priModObj[0]->queryResults["priKeyID"];
	#If we are in the product module take out the _ that is used to build the cart.
	if ($priModObj[0]->moduleID == 53) {
		$key = 	strstr($priModObj[0]->queryResults["priKeyID"], '_', true); 
	}
	$ratingQuery = $moduleRecordRatingObj->getRating($key,$priModObj[0]->moduleID);
	$rq = mysqli_fetch_assoc($ratingQuery);
	$rating = $rq["rating"];
	
	
if($priModObj[0]->hasRatingRequireLogin) {
	if(isset($_SESSION["userID"]) && $_SESSION["isGuest"] != 1) {
		$displayRateing = true;
	}
	else {
		$displayRateing = false;
	}
}
else {
	$displayRateing = true;
}

if($displayRateing) {
?>
<div class="ratingBox" id="ratingBox_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>">
	<input <?php if($rating==1){echo 'checked="checked"';} ?> name="star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" type="radio" class="star star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" value="1"/> 
	<input <?php if($rating==2){echo 'checked="checked"';} ?> name="star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" type="radio" class="star star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" value="2"/> 
	<input <?php if($rating==3){echo 'checked="checked"';} ?> name="star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" type="radio" class="star star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" value="3"/> 
	<input <?php if($rating==4){echo 'checked="checked"';} ?> name="star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" type="radio" class="star star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" value="4"/> 
	<input <?php if($rating==5){echo 'checked="checked"';} ?> name="star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" type="radio" class="star star_<?php echo $priModObj[0]->className; ?>_<?php echo $key; ?>" value="5"/>
</div>

<?php
}
?>