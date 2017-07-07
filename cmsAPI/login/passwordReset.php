<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	

	class passwordReset extends common{	

		public $moduleTable = "instance_password_reset";

		public $instanceTable = "instance_password_reset";

		

		public function __construct($isAjax,$pmpmID = 1){

			parent::__construct($isAjax,$pmpmID);

		}

		

		public function resetForgottenPassword($email){

			

			#get the user that this email address belongs to

			include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/publicUsers/publicUsers.php');

			$publicUsersObj = new publicUsers(false,NULL);

			$requestUser = $publicUsersObj->getConditionalRecord(

				array("email",$email,true)

			);

			

			$ru = mysqli_fetch_assoc($requestUser);

			

			#generate a new random password for the user

			$newPass = uniqid("");

			

			#update user with new password

			$paramsArray = array();

			$paramsArray["priKeyID"] = $ru["priKeyID"];

			$paramsArray["loginPassword"] = $newPass;

			$publicUsersObj->updateRecord($paramsArray);



			#compose message and email header

			$message = '

				<table>

					<tbody>

						<tr>

							<td>

								' . $ru["firstName"] . " " . $ru["lastName"] .'<br />

								Your password has been reset for : ' . $_SESSION["siteName"] . '<br />

								to: ' . $newPass .'

							</td>

						</tr>

					</tbody>

				</table>

			';

	

			$subject = "Password Reset";

			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			$headers .= "From: " . $_SESSION["siteName"];

			

			mail($ru["email"], $subject, $message, $headers);

				

			echo "1";

			

		}

	}

	

	if(isset($_REQUEST["function"])){	

		$moduleObj = new passwordReset(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}

	elseif(isset($_REQUEST["modData"])){

		$moduleObj = new passwordReset(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>