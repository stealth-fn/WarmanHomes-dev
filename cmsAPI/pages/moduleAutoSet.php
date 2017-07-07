<?php
	/*set timer for fade\clickslide
	standard modules don't go into the object, since we don't clear them*/
	if($priModObj[0]->pageID < 0) {
		$timerObj = "standardInterTime";
	}
	else $timerObj = "pageInterTime";

	if($priModObj[0]->autoChange == 1){
		#fade rotate
		if($priModObj[0]->instanceDisplayType == 0||
		$priModObj[0]->instanceDisplayType == 4){
			$_GET["moduleRunScripts"].= 
			$timerObj . '.' . $priModObj[0]->className . '=
				setInterval(
							\'' . $priModObj[0]->className . '.fadeRotate(' . $priModObj[0]->autoChangeDirection . ')\',
							' . $priModObj[0]->autoChangeDuration . '
				);' . PHP_EOL;
		}
		#click slide
		else if($priModObj[0]->instanceDisplayType == 3){
			$_GET["moduleRunScripts"].= 
			$timerObj . '.' . $priModObj[0]->className . '=
				setInterval(
							\'' . $priModObj[0]->className . '.clickSlide(' . $priModObj[0]->autoChangeDirection . ')\',
							' . $priModObj[0]->autoChangeDuration . '
				);' . PHP_EOL;
		}
	}
?>