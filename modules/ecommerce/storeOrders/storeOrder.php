<?php
	#time picker
	echo ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.core.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.scroller.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.datetime.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.select.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.scroller.jqm.js") . ";" .PHP_EOL;
?>
//time picker
storeOrdersAddEditObj.prototype.timeFields = "orderTime";

//create jquery date picker
$(".orderDate").datepicker({ dateFormat: 'yy-mm-dd'}); 
