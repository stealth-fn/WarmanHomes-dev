<div class="getDispInfoContainer">
	<form 
		onsubmit="<?php echo $priModObj[0]->className; ?>.sendInfo(this);return false"
	>
		<input type="text" value="" placeholder="<?php echo $priModObj[0]->inputPlaceHolder; ?>" name="userInfo" autocomplete="off"> 
		<input 
			type="button"
			value="<?php echo $priModObj[0]->submitButtonText; ?>" 
			name="infoSub" 
			onclick="<?php echo $priModObj[0]->className; ?>.sendInfo(this.form)"
		>
	</form>
</div>