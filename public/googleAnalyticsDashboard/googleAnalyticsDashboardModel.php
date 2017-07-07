<?php
	#setup our google API
	require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/public/googleAnalyticsDashboard/base.php');
	$client = new Google_Client();
	
	#validate our user
	$client->setAuthConfig($_SERVER['DOCUMENT_ROOT']."/vendor/creds/service-account-credentials.json");

	#connect to analytics API
	$client->setApplicationName("HelloAnalytics");
	$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
	$service = new Google_Service_Analytics($client);
	
	#get all the websites this account has access to
	$accounts = $service->management_accounts->listManagementAccounts();
	$client->refreshTokenWithAssertion();
	$temp = $client->getAccessToken();
	$_SESSION["access_token"] =$temp["access_token"];
		
	#loop through all the websites until we find the one for our current analytics code	
	if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
	
		$x = 0;
		while(gettype($items[$x]) === "object"){

			$properties = $service->management_webproperties
			->listManagementWebproperties($items[$x]->getId());
	
			$y=0;
	
			while(is_numeric($properties[$y]["accountId"])){
		
				if($properties[$y]["id"] == $_SESSION["googleAnalyticsCode"]) {
					$_SESSION["googleAccountID"] = $properties[$y]["accountId"];
					break;
				}
				$y++;
			}
			
			$x++;
		}
		
		#load the HTML
		require_once($_SERVER['DOCUMENT_ROOT'] . '/public/googleAnalyticsDashboard/googleAnalyticsDashboardView.php');
	}
	else{
		$_SESSION["googleAccountID"] = "";
		echo "Profile User Not Found";
	}
?>