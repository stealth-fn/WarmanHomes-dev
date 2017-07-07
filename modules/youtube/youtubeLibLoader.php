<?php
	/*load youtube libraries*/
	$path = $_SERVER['DOCUMENT_ROOT'].'/cmsAPI/library';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	require_once 'Zend/Loader.php'; 
	Zend_Loader::loadClass('Zend_Gdata_YouTube');
	Zend_Loader::loadClass('Zend_Gdata_AuthSub');
?>