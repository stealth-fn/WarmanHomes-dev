function updateTweets(){
	var tweetAjax = ajaxObj();
	
	tweetAjax.onreadystatechange=function(){
		if(tweetAjax.readyState===4){
			//returns an array of objects
			var tweetArray = eval(tweetAjax.responseText);		
			
			for (var i = 0 ; i < 1 ; i++){
				var text = tweetArray[i].text;
				var time = tweetArray[i].created_at;
				var profileImage = tweetArray[i].profile_image_url;
									
				$s("tweetInfo" + i).innerHTML = "<a target='_blank' href='http://twitter.com/StealthDesigns'>" + text + "</a>";
				$s("tweetTime" + i).innerHTML = getTwitterTime(time);
				//document.getElementById("tweetImg" + i).innerHTML = "<img src='" + profileImage + "' width='48' height='48' alt='Twitter Profile Pic'/>";
			}
		}
	}
	
	ajaxPost(
		tweetAjax,
		"/cmsAPI/twitter/twitter.php","function=getUserTimeline&screenName=StealthDesigns",
		true,0,null,false
	);	
}

function getTwitterTime(dateTime){
	var dateTime = dateTime.split(" ");
	var tweetYear = dateTime[5];
	var tweetMonth = getMonthDigit(dateTime[1]);
	var tweetDate = dateTime[2];
	var tweetTime = dateTime[3].split(":");
	var tweetHour = tweetTime[0];
	var tweetMinute = tweetTime[1];
	var tweetSeconds = tweetTime[2];
	var tweetTimeOff = dateTime[4];
	var twitterDate = tweetMonth + "/" + tweetDate + "/" + tweetYear;
	var tweetDateTime = new Date();
	tweetDateTime.setUTCFullYear(tweetYear);
	tweetDateTime.setUTCMonth(tweetMonth-1);
	tweetDateTime.setUTCDate(tweetDate);
	tweetDateTime.setUTCHours(tweetHour);
	tweetDateTime.setUTCMinutes(tweetMinute);
	tweetDateTime.setUTCSeconds(tweetSeconds);
	
	var currentDateTime = new Date();
	var milliDiff = currentDateTime.getTime() - tweetDateTime.getTime();
	var aboutString = "";
	
	if(Math.floor(milliDiff / (1000 * 60 * 60 * 24 * 365)) > 1){
		aboutString = "over " + Math.floor(milliDiff / (1000 * 60 * 60 * 24 * 365)) + " years ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60 * 60 * 24 * 365)) == 1){
		aboutString = "over " + Math.floor(milliDiff / (1000 * 60 * 60 * 24 * 365)) + " year ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60 * 60 * 24)) > 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60 * 60 * 24)) + " days ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60 * 60 * 24)) == 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60 * 60 * 24)) + " day ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60 * 60)) > 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60 * 60)) + " hours ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60 * 60)) == 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60 * 60)) + " hour ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60)) > 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60)) + " minutes ago";
	}
	else if(Math.floor(milliDiff / (1000 * 60)) == 1){
		aboutString = "about " + Math.floor(milliDiff / (1000 * 60)) + " minutes ago";
	}
	else{
		aboutString = "about " + Math.floor(milliDiff / (1000)) + " seconds ago";
	}
	
	return aboutString;
}

function getMonthDigit(monthStr){
	var digiMonth = 0;
	
	if(monthStr=="Jan") digiMonth = 01;
	else if(monthStr=="Feb") digiMonth = 02;
	else if(monthStr=="Mar") digiMonth = 03;
	else if(monthStr=="Apr") digiMonth = 04;
	else if(monthStr=="May") digiMonth = 05;
	else if(monthStr=="Jun") digiMonth = 06;
	else if(monthStr=="Jul") digiMonth = 07;
	else if(monthStr=="Aug") digiMonth = 08;
	else if(monthStr=="Sep") digiMonth = 09;
	else if(monthStr=="Oct") digiMonth = 10;
	else if(monthStr=="Nov") digiMonth = 11;
	else if(monthStr=="Dec") digiMonth = 12;
	
	return digiMonth;
}