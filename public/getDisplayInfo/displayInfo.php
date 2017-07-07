<?php 
	#include spans for extra styling
	if($priModObj[0]->htmlMarkup == 1){
		
		#a class to determine if its displaying information provided by the user
		if(strlen($_SESSION["userDisplayInfo"]) > 0){
			$displayUserInfoClass = " dspUserInfo";
		}
		else{
			$displayUserInfoClass = "";
		}
		
		echo '
		<span class="displayUserInfoOutter' . $displayUserInfoClass . '">
			<span class="displayUserInfoInner' . $displayUserInfoClass . '">' . $_SESSION["userDisplayInfo"] . 
			'</span>
		</span>';
	}
	#only output text. can be used as default values on forms
	else{
		echo $_SESSION["userDisplayInfo"];
	}
?>