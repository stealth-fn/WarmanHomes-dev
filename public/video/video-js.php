<?php
	#get the 1st video we load from youtube for the default video
	include_once($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/video/video.php");
	$videoObj = new video(false);
	$allVids = $videoObj->getCheckQuery("SELECT * FROM videos ORDER BY priKeyID DESC LIMIT 1");
	$latestVid = mysqli_fetch_array($allVids);

	if ($latestVid["startTime"] <= 0) {
		$startSecond = '1';
	}
	else {
		$startSecond = $latestVid["startTime"];
	}

	if ($latestVid["endTime"] <= $startSecond) {
		$endSecond = $startSecond + 20;
	}
	else if ($latestVid["endTime"] <= 0) {
		$endSecond = '60';
	}
	else {
		$endSecond = $latestVid["endTime"];
	}
?>

//called when we do ajax page changes
function loadPlayer2() {

	if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
	
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		window.onYouTubePlayerAPIReady = function() {
		  onYouTubePlayer();
		};

	} else {
		onYouTubePlayer();
	}	
}

var ytPlayer;

var playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
var vid = [
			{'videoId': '<?php echo $latestVid["youtubeVidID"]; ?>', 'startSeconds': <?php echo $startSecond; ?>, 'endSeconds': <?php echo $endSecond; ?>, 'suggestedQuality': 'default'}		
		];
var currVid = 0;


function onYouTubePlayer() {
  ytPlayer = new YT.Player('tv', {
		videoId: '<?php echo $latestVid["youtubeVidID"]; ?>',
		events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			  },
		playerVars: playerDefaults
	  });
}

function onPlayerReady(event) {
	ytPlayer.loadVideoById(vid[0]);
	ytPlayer.mute();
	vidRescale();
}

var done = false;
function onPlayerStateChange(e) {

	/*-1 – unstarted
	0 – ended
	1 – playing
	2 – paused
	3 – buffering
	5 – video cued*/

	// PLAYING
	if (e.data === YT.PlayerState.PLAYING){
		$('#tv').addClass('active');
	} 
	// END
	else if (e.data === YT.PlayerState.ENDED){	
		//ytPlayer.playVideo();
		ytPlayer.loadVideoById(vid[currVid]);
	}
}

function vidRescale(){

  var w = $(window).width()+200,
    h = $(window).height()+200;

  if (w/h > 16/9){
    ytPlayer.setSize(w, w/16*9);
    $('.tv .screen').css({'left': '0px'});
  } else {
    ytPlayer.setSize(h/9*16, h);
    $('.tv .screen').css({'left': -($('.tv .screen').outerWidth()-w)/2});
  }
}

