<div class="passRsContainer">
	<h2><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['passHeader']; ?></h2>
	<div class="passRsContent">
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['passCopy']; ?>
	</div>
	<form 
		id="passwdResetForm_<?php echo $priModObj[0]->className; ?>"
		name="passwdResetForm_<?php echo $priModObj[0]->className; ?>"
	>
		<label 
			for="passRstEmail"
		>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['passEmail']; ?>
		</label>
		<input 
			type="text" 
			class="passRstEmail passRstEmail_<?php echo $priModObj[0]->className; ?>"
			name="passRstEmail"
			value=""
		/>
		<input 
			class="passRstBtn passRstEmail_<?php echo $priModObj[0]->className; ?>"
			type="button" 
			value="<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['passBtn']; ?>"
			onclick="<?php echo $priModObj[0]->className; ?>.resetPassRequest()"
		/>
	</form>
</div>