<?php
/*
 * Copyright 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/googleAnalyticsDashboard/base.php');
/************************************************
  Make an API request authenticated with a service
  account.
 ************************************************/

$client = new Google_Client();

/************************************************
  ATTENTION: Fill in these values, or make sure you
  have set the GOOGLE_APPLICATION_CREDENTIALS
  environment variable. You can get these credentials
  by creating a new Service Account in the
  API console. Be sure to store the key file
  somewhere you can get to it - though in real
  operations you'd want to make sure it wasn't
  accessible from the webserver!
  Make sure the Books API is enabled on this
  account as well, or the call will fail.
 ************************************************/


$client->setAuthConfig($_SERVER['DOCUMENT_ROOT']."/vendor/creds/service-account-credentials.json");

$client->setApplicationName("HelloAnalytics");
$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
$service = new Google_Service_Analytics($client);

$accounts = $service->management_accounts->listManagementAccounts();
$client->refreshTokenWithAssertion();

$_SESSION["googleAnalyticsCode"] = "UA-25352071-59";

// Get the list of accounts for the authorized user.
function getFirstprofileId(&$analytics) {
  // Get the user's first view (profile) ID.

  // Get the list of accounts for the authorized user.
  $accounts = $analytics->management_accounts->listManagementAccounts();

  if (count($accounts->getItems()) > 0) {
    $items = $accounts->getItems();
	
	$x = 0;
	while(gettype($items[$x]) === "object"){

		$properties = $analytics->management_webproperties
        ->listManagementWebproperties($items[$x]->getId());

		$y=0;
		
		while(is_numeric($properties[$y]["accountId"])){
			
			if($properties[$y]["id"] == $_SESSION["googleAnalyticsCode"]) {
				$_SESSION["googleAccountID"] = $properties[$y]["accountId"];
			}
			$y++;
		}
		$x++;
	}
	
    $firstAccountId = $items[0]->getId();

    // Get the list of properties for the authorized user.
    $properties = $analytics->management_webproperties
        ->listManagementWebproperties($firstAccountId);

    if (count($properties->getItems()) > 0) {
      $items = $properties->getItems();
      $firstPropertyId = $items[0]->getId();

      // Get the list of views (profiles) for the authorized user.
      $profiles = $analytics->management_profiles
          ->listManagementProfiles($firstAccountId, $firstPropertyId);

      if (count($profiles->getItems()) > 0) {
        $items = $profiles->getItems();

        // Return the first view (profile) ID.
        return $items[0]->getId();

      } else {
        throw new Exception('No views (profiles) found for this user.');
      }
    } else {
      throw new Exception('No properties found for this user.');
    }
  } else {
    throw new Exception('No accounts found for this user.');
  }
}

function getResults(&$analytics, $profileId) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:' . $profileId,
       '7daysAgo',
       'today',
       'ga:sessions');
}

function printResults(&$results) {
  // Parses the response from the Core Reporting API and prints
  // the profile name and total sessions.
  if (count($results->getRows()) > 0) {

    // Get the profile name.
    $profileName = $results->getProfileInfo()->getProfileName();

    // Get the entry for the first entry in the first row.
    $rows = $results->getRows();
    $sessions = $rows[0][0];

    // Print the results.
    print "First view (profile) found: $profileName\n";
    print "Total sessions: $sessions\n";
  } else {
    print "No results found.\n";
  }
}

$profile = getFirstProfileId($service);
$results = getResults($service, $profile);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Stealth Interactive Media CMS - Google Analtyics Dashboard</title>

<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>

<body>
<?php
	echo pageHeader("Service Account Access");
	printResults($results);
	$temp = $client->getAccessToken();
?>
<div id="chart-1-container"></div>

<script>

gapi.analytics.ready(function() {

  /**
   * Authorize the user with an access token obtained server side.
   */
  gapi.analytics.auth.authorize({
    'serverAuth': {
      'access_token': '<?php echo $temp["access_token"]; ?>'
    }
  });
  
	function listViews() {
		var request = gapi.client.analytics.management.profiles.list({
			'accountId': '<?php echo $_SESSION["googleAccountID"]; ?>',
			'webPropertyId': '<?php echo $_SESSION["googleAnalyticsCode"]; ?>'
		});
		request.execute(printViews);
	}
	
	/*
	* Example 2:
	* The results of the list method are passed as the results object.
	* The following code shows how to iterate through them.
	*/
	function printViews(results) {
		if (results && !results.error) {
			var profiles = results.items;
			console.log(profiles);
			for (var i = 0, profile; profile = profiles[i]; i++) {
				console.log('Account Id: ' + profile.accountId);
				console.log('Property Id: ' + profile.webPropertyId);
				console.log('Internal Property Id: ' + profile.internalWebPropertyId);
				console.log('View (Profile) Id: ' + profile.id);
				console.log('View (Profile) Name: ' + profile.name);
				
				console.log('Default Page: ' + profile.defaultPage);
				console.log('Exclude Query Parameters: '
				  + profile.excludeQueryParameters);
				console.log('Site Search Category Parameters'
				  + profile.siteSearchCategoryParameters);
				console.log('Site Search Query Parameters: '
				  + profile.siteSearchQueryParameters);
				
				console.log('Currency: ' + profile.currency);
				console.log('Timezone: ' + profile.timezone);
				console.log('Created: ' + profile.created);
				console.log('Updated: ' + profile.updated);
				
			/**
			   * Creates a new DataChart instance showing sessions over the past 30 days.
			   * It will be rendered inside an element with the id "chart-1-container".
			   */
  			var dataChart1 = new gapi.analytics.googleCharts.DataChart({
			query: {
			  'ids': 'ga:' + profile.id, // The Demos & Tools website view.
			  'start-date': '30daysAgo',
			  'end-date': 'yesterday',
			  'metrics': 'ga:sessions,ga:users',
			  'dimensions': 'ga:date'
			},
			chart: {
			  'container': 'chart-1-container',
			  'type': 'LINE',
			  'options': {
				'width': '100%'
			  }
			}
		  });
		 	 dataChart1.execute();
			 
			 
			 var report = new gapi.analytics.report.Data({
				  query: {
			  		'ids': 'ga:' + profile.id, 
					metrics: 'ga:sessions,ga:users,ga:pageviews,ga:pageViewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:percentNewSessions',
					'start-date': '30daysAgo',
			  		'end-date': 'yesterday',
				  }
				});
				
				report.on('success', function(response) {
				  $("#stat0").append(response.rows[0][0]);
				  $("#stat1").append(response.rows[0][1]);
				  $("#stat2").append(response.rows[0][2]);
				  $("#stat3").append(response.rows[0][3]);
				  $("#stat4").append(response.rows[0][4]);
				  $("#stat5").append(response.rows[0][5]);
				  $("#stat6").append(response.rows[0][6]);
				});
				
				report.execute();
				
			 var report2 = new gapi.analytics.report.Data({
				  query: {
			  		'ids': 'ga:' + profile.id, 
					metrics: 'ga:totalEvents',
					dimensions: 'ga:eventCategory',
					'start-date': '30daysAgo',
			  		'end-date': 'yesterday',
				  }
				});
				
				report2.on('success', function(response) {
					for (var i = 0, gEvent; gEvent = response["rows"][i]; i++) {
					 $("#googleStatsContainer").append(
					 	'<div>' + gEvent[0] + ":" + gEvent[1] +'</div>'
					 );
					}
				});
				
				report2.execute();

			}
		}
	}

	listViews();

});

//https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A110807806&start-date=30daysAgo&end-date=yesterday&metrics=ga%3Ausers%2Cga%3ApercentNewSessions%2Cga%3Asessions%2Cga%3AbounceRate%2Cga%3AavgSessionDuration%2Cga%3Apageviews%2Cga%3ApageviewsPerSession
</script>

<div id="googleStatsContainer">
	<div id="stat0">Sessions:</div>
	<div id="stat1">Users:</div>
	<div id="stat2">Pageviews:</div>
	<div id="stat3">Pages / Session:</div>
	<div id="stat4">Avg. Session Duration:</div>
	<div id="stat5">Bounce Rate:</div>
	<div id="stat6">New Sessions %:</div>
</div>

</body>
</html>