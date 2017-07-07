<?php
#standardContent Content
if(array_key_exists("Content",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="stContent-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="stContent-<?php echo $priModObj[0]->className; ?>"
	 >
		<?php echo $priModObj[0]->queryResults['standardContentContent'];?>
	</div>
<?php
	$priModObj[0]->domFields["Content"] =  ob_get_contents();
	ob_end_clean();
}

#standardContent Title
if(array_key_exists("Title",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="stTitle-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="stTitle-<?php echo $priModObj[0]->className; ?>"
	 >
		<?php echo $priModObj[0]->queryResults['standardContentName'];?>
	</div>
<?php
	$priModObj[0]->domFields["standardContentName"] =  ob_get_contents();
	ob_end_clean();
}
?>