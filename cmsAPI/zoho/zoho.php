<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class zoho extends common{
	
		/*function getUserTimeline($screenName){
			$ch = curl_init(); #create curl resource
			#set url
			curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/1/statuses/user_timeline.xml?screen_name=".$screenName);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); #return the transfer as a string
			$output = curl_exec($ch); #$output contains the output string
			curl_close($ch);  #close curl resource to free up system resources
			
			if($this->ajax) echo $output;
			else return $output;
		}*/
		
		function sendZohoLead($postData){
			# create curl resource
			$ch = curl_init();
			
			$zohoFields = array("Lead_Owner","Company","First_Name","Last_Name",
			"Designation","Email","Phone","Fax","Mobile","Website","Lead_Source",
			"Lead_Status","Industry","No_of_Employees","Annual_Revenue","Email_Opt_Out",
			"Skype ID","Salutation","Street","City","State","Zip Code","Country",
			"Description");
			
			if(!isset($postData["Description"])){
				$postData["Description"] = "";
			}
			
			#Last_Name is required, but sometimes we just one one name field
			if(!isset($postData["Last_Name"])){
				$tempNameArray = explode(" ",$postData["First_Name"]);
				
				#prase the last name out of the name field
				if(count($tempNameArray) > 1){
					$postData["First_Name"] = $tempNameArray[0];
					$postData["Last_Name"] = $tempNameArray[1];
				}
				else{
					$postData["Last_Name"] = "Last Name Unavailable";
				}
			}
			
			/*loop through our posts. if there are fields that aren't in the zoho fields
			append them to the description*/
			foreach ($postData as $paramName => $paramValue){
			
				#no need to send this parameter to the user
				if(!in_array($paramName,$zohoFields)){
					$postData["Description"] .= " -- " . $paramName . ":" . $paramValue;
				}
				
			}
			
			/*we can't have any break lines or carriage returns or it doesn't work. 
			tried to remove them manually so we could keep nice formatting here
			and it didn't seem to work - jared*/
			$paramString = 'xmlData=' .
				'<?xml version="1.0" encoding="UTF-8"?>' .
					'<Leads>' .
						'<row no="1">' . 
					 		'<FL val="Lead Owner">' . $_SESSION["zohoLeadOwner"] . '</FL>' .
							'<FL val="Company">' . $postData["Company"] . '</FL>' . 
							'<FL val="First Name">' . $postData["First_Name"] .'</FL>' .
							'<FL val="Last Name">' . $postData["Last_Name"] .'</FL> ' . 
							'<FL val="Designation">' . $postData["Designation"] .'</FL>' .
							'<FL val="Email">' . $postData["Email"] .'</FL>' .
							'<FL val="Phone">' . $postData["Phone"] .'</FL>' .
							'<FL val="Fax">' . $postData["Fax"] .'</FL>' . 
							'<FL val="Mobile">' . $postData["Mobile"] .'</FL>' .
							'<FL val="Website">' . $postData["Website"] .'</FL>' . 
							'<FL val="Lead Source">' . $postData["Lead_Source"] .'</FL>' . 
							'<FL val="Lead Status">' . $postData["Lead_Status"] .'</FL>' .
							'<FL val="Industry">' . $postData["Industry"] .'</FL>' . 
							'<FL val="No of Employees">' . $postData["No_of_Employees"] . '</FL>' .
							'<FL val="Annual Revenue">' . preg_replace("/[^0-9,.]/", "",$postData["Annual_Revenue"]) .'</FL>' .
							'<FL val="Email Opt Out">' . $postData["Email_Opt_Out"] .'</FL>' .
							'<FL val="Skype ID">' . $postData["Skype_ID"] .'</FL>' .
							'<FL val="Salutation">' . $postData["Salutation"] .'</FL>' .
							'<FL val="Street">' . $postData["Street"] .'</FL>' .
							'<FL val="City">' . $postData["City"] .'</FL>' .
							'<FL val="State">' . $postData["State"] .'</FL>' .
							'<FL val="Zip Code">' . $postData["Zip_Code"] .'</FL>' .
							'<FL val="Country">' . $postData["Country"] .'</FL>' .
							'<FL val="Description">' . str_replace(array("\n", "\t"),"",rawurlencode(htmlspecialchars($postData["Description"],ENT_QUOTES))) .'</FL>' .
						'</row>' .
					'</Leads>' . 
					'&authtoken=' . rawurlencode($_SESSION["zohoAuth"]) . '&scope=crmapi&newFormat=1';

			curl_setopt($ch, CURLOPT_URL, "https://crm.zoho.com/crm/private/xml/Leads/insertRecords");
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $paramString);

			#Execute cUrl session
			$response = curl_exec($ch);
			curl_close($ch);
			
			#parse response
			$xml = simplexml_load_string($response);
			echo $paramString;

			if(isset($xml->error)){
				$to = $_SESSION["adminEmail"];
				$subject = "Invalid_Zoho_Lead";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= "From: " . $_SESSION["siteName"] . "\r\n";
				$headers .= "Reply-To: " . $replyEmail;
				
				$message = "A Zoho lead with malformed data was rejected containing the data " . $paramString;
				$message .= "Please contact the website administrator";
				
				#mail to the admins of the CMS
				mail($to, $subject, htmlspecialchars($message), $headers);
			}
			
			
			return true;
		}
	}
	
?>