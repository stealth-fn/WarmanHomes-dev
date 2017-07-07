<?php
#FAQ Question
if(array_key_exists("fq",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="faqQuestion-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="faqQuestion faqQuestion-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>"
 >
	<?php echo $priModObj[0]->queryResults['faqQuestion'];?>
</div>
<?php
	$priModObj[0]->domFields["fq"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#FAQ Answer
if(array_key_exists("fa",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="faqAns-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>"
	class="faqAns faqAns-<?php echo $priModObj[0]->className;?>" 
>
	<?php echo $priModObj[0]->queryResults['faqAnswer'];?>
</div>
<?php
	$priModObj[0]->domFields["fa"] =  ob_get_contents();
	ob_end_clean();
}
?>