<div 
	class="ecommSearchContainer" 
	id="ecommSearchContainer_<?php echo $priModObj[0]->className; ?>"
>
	<form 
		id="ecommSearchForm_<?php echo $priModObj[0]->className; ?>" 
		name="ecommSearchForm"  
		onsubmit="eSearch_<?php echo $priModObj[0]->className; ?>.eSearch(this); return false"
	>
		<input 
			id="eSearchTerm_<?php echo $priModObj[0]->className; ?>" 
			maxlength="100"
			name="eSearchTerm"  
			onblur="backToDefault(this)"
			onfocus="clearField(this)"
			type="text"
			value="<?php echo $priModObj[0]->defaultSearchFieldText; ?>"
		/>
		<input 
			id="ecommSearchBtn_<?php echo $priModObj[0]->className; ?>" 
			name="ecommSearchBtn" 			
			onclick="eSearch_<?php echo $priModObj[0]->className; ?>.eSearch(this.form)"
			type="button"
			value="<?php echo $priModObj[0]->buttonText; ?>" 
		/>
		<input type="submit" style="display:none" />
	</form>
</div>