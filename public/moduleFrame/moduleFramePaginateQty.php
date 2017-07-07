<label 
	for="modDspQty-<?php echo $priModObj[0]->className;?>" 
	class="lstQtyLbl"
>Results Per Page</label>
<select
	class="modDspQty"
	id="modDspQty-<?php echo $priModObj[0]->className;?>"
	name="modDspQty" 
	<?php #$requestString is set in moduleFrameItems.php ?>
	onchange='<?php echo $priModObj[0]->className; ?>.disQtyChange(this,&#39;<?php echo $requestString; ?>&#39;)'
>
	<option <?php if($priModObj[0]->displayQty == 10) echo 'selected="selected"'; ?>>10</option>
	<option <?php if($priModObj[0]->displayQty == 20) echo 'selected="selected"'; ?>>20</option>
	<option <?php if($priModObj[0]->displayQty == 30) echo 'selected="selected"'; ?>>30</option>
	<option <?php if($priModObj[0]->displayQty == 50) echo 'selected="selected"'; ?>>50</option>
	<option <?php if($priModObj[0]->displayQty == 100) echo 'selected="selected"'; ?>>100</option>
	<option <?php if($priModObj[0]->displayQty == 200) echo 'selected="selected"'; ?>>200</option>
	<option <?php if($priModObj[0]->displayQty == 400) echo 'selected="selected"'; ?>>400</option>
	<option <?php if($priModObj[0]->displayQty == 500) echo 'selected="selected"'; ?>>500</option>
</select>
