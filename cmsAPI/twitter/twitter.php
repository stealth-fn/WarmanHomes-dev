<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class twitter extends common{
	
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
		
		function getUserTimeline($screenName){
			if(!isset($_SESSION)) session_start();
			require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/twitter/twitteroauth/twitteroauth/twitteroauth.php'); //Path to twitteroauth library
			 
			$twitteruser = $screenName;
			$notweets = 1;
			$consumerkey = "hyk6NXOgrLDcgmzRyBvFQ";
			$consumersecret = "tENO6PjqxXfmKrgRgAS1oZQOP1SyEHRnkk9lZiIHVg";
			$accesstoken = "61053598-7KOEV4fYqoXb2rM0epEnr2lqh5aY7XfWPcfxGjVyE";
			$accesstokensecret = "by9hq0Pr9jhOHogsAtpYkHEkKD1s4MS0kuuCXxNNU";
			 
			function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
			  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			  return $connection;
			}
			 
			$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
			 
			$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
			 
			echo json_encode($tweets);
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new twitter(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>