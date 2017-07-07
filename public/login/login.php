<?php 
	#SHOW HIDE BUTTON
	if(array_key_exists("showhide",$priModObj[0]->domFields)){

		$showHideClass = "hideLg";
		
		#display the user name when the user logs in
		if($priModObj[0]->showHideBtnText == "{loginName}"){

			if(isset($_SESSION['loginName'])){
				$priModObj[0]->showHideBtnText = $_SESSION['loginName'];
			}
			else{
				$priModObj[0]->showHideBtnText = "";
			}
		}

		$priModObj[0]->domFields["showhide"] = 
		'<div 
			class="lb lb-'.$priModObj[0]->className.'"
			id="lb-'.$priModObj[0]->className.$priModObj[0]->queryResults["priKeyID"].'" 
			onclick="$(\'#lc-'.$priModObj[0]->className.$priModObj[0]->queryResults["priKeyID"].'\').slideToggle();"
		 >
			'.$priModObj[0]->showHideBtnText.'
		</div>';
	}
	else{
		$showHideClass = "";
	}

	#LOGIN BOX
	if(array_key_exists("loginbox",$priModObj[0]->domFields)){
		$urlParams = (isset($urlParams)) ?  $urlParams : "";
		$priModObj[0]->domFields["loginbox"] = 
			'<div 
				 class="lc lc-'.$priModObj[0]->className.' ' . $showHideClass . '" 
				 style="'.((array_key_exists("showhide",$priModObj[0]->domFields) && $priModObj[0]->defaultHidden)?"display:none":"").'"
				 id="lc-'.$priModObj[0]->className.$priModObj[0]->queryResults["priKeyID"].'">' .
					((isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0) ? 
							$priModObj[0]->createSignOutForm()
					:
						$priModObj[0]->createLoginForm($urlParams) 
					) . '
			</div>';
	}

?>