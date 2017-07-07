<?php
#tesimonial copy
if(array_key_exists("tc",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="testimonial-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="testimonial-<?php echo $priModObj[0]->className; ?>"
	 >
		<?php echo $priModObj[0]->queryResults['testimonial'];?>
	</div>
<?php
	$priModObj[0]->domFields["tc"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#tesimonial name
if(array_key_exists("tn",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="testimonialName-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="testimonialName-<?php echo $priModObj[0]->className;?>" 
>
	<?php echo $priModObj[0]->queryResults['testimonialName'];?>
</div>
<?php
	$priModObj[0]->domFields["tn"] =  ob_get_contents();
	ob_end_clean();
}
?>

