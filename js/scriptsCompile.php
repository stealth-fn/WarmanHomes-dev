<?php
	$scriptPaths = array(); #static scripts to be compressed

	array_push($scriptPaths,"/js/commonScript.js"); #custom cms scripts
	
	$pathCnt = count($scriptPaths);
	$jSource = "";
	
	#create string to run from server command line
	for($i = 0; $i<$pathCnt; $i++){
		$jSource .= file_get_contents($_SERVER['DOCUMENT_ROOT'].$scriptPaths[$i],true) . PHP_EOL;
		$closurePaths .= " --js=" . $_SERVER['DOCUMENT_ROOT'] . $scriptPaths[$i];
	}
	
	#compress our scripts 
	if($_SESSION["shrinkScripts"] == 0){
		$closureString = " /usr/bin/java -jar " . $_SERVER['DOCUMENT_ROOT'] . "/js/compiler.jar";
		$closureString .= $closurePaths;
		$closureString .= " --js_output_file=" . $_SERVER['DOCUMENT_ROOT'] . "/js/commonScriptMini.js";
		
		exec("export JAVA_HOME=/usr/bin/java",$return,$code);
		exec($closureString,$return,$code);
	}
	#use what is currently there
	elseif($_SESSION["shrinkScripts"] == 1){
		$f = fopen($_SERVER['DOCUMENT_ROOT'] . "/js/commonScriptMini.js", "w");
		fwrite($f, $jSource);
		fclose($f);
	}
?>