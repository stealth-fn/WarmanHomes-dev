<?php
#File Description
if(array_key_exists("flcd",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="flcd-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="flcd-<?php echo $priModObj[0]->className; ?>"
	 >
		<?php echo $priModObj[0]->queryResults['fileCatDesc'];?>
	</div>
<?php
	$priModObj[0]->domFields["fileCatDesc"] =  ob_get_contents();
	ob_end_clean();
}
?>