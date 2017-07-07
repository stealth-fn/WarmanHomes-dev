<?php
	#time picker
	echo ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.core.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.scroller.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.datetime.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.select.js") . ";" .PHP_EOL;
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/mobiscroll/mobiscroll.scroller.jqm.js") . ";" .PHP_EOL;
?>

//ckEditor object
blogAddEditObj.prototype.ckEditorFieldName = "blogCopy";

//time picker
blogAddEditObj.prototype.timeFields = "postTime";

//create jquery date picker
$(".postDate").datepicker({ dateFormat: 'yy-mm-dd'}); 