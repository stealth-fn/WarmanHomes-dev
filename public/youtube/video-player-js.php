<?php
	#get the 1st video we load from youtube for the default video
	include_once($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/youtube/youtubeThumbsTemp.php");
	$youtubeThumbsTempObj = new youtubeThumbsTemp(false);
	$allVids = $youtubeThumbsTempObj->getCheckQuery("SELECT * FROM videos where isActive=1 ORDER BY priKeyID DESC LIMIT 1");
	$latestVid = mysqli_fetch_array($allVids);
?>

//load in API
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

//called when we do ajax page changes
function loadPlayer() {
	onYouTubePlayerReady();		 
}

var player;
var ytPlayer;
var playerDefaults = {
						autoplay: 1, 
						autohide: 1, 
						modestbranding: 0, 
						rel: 0, 
						showinfo: 0, 
						controls: 0, 
						disablekb: 1, 
						enablejsapi: 0, 
						iv_load_policy: 3,
						loop: 1
					};


//function called once iframe player API is loaded
function onYouTubePlayerReady() {
    ytPlayer = new YT.Player('ytapiplayer', {
    videoId: '<?php echo $latestVid["youtubeVidID"]; ?>',
	events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange            
          },
	playerVars: playerDefaults
  });
}

function onPlayerReady(event) {

	ytPlayer.mute();
	vidRescale();
	
	//put click event on each thumb img
	$('.vidImg').bind("click",function(event){
	
			//get video id from our image alt tag
			var myvideo = event.target.alt;

			//manually change src of the iframe
			//$("#ytapiplayer").get(0).src="https://www.youtube.com/embed/" + myvideo + "?autoplay=1&amp;autohide=1&amp;modestbranding=0&amp;rel=0&amp;showinfo=0&amp;controls=0&amp;disablekb=1&amp;enablejsapi=1&amp;iv_load_policy=3&amp;origin=http%3A%2F%2Faspectvr-landingpage.stealthinteractive.net&amp;widgetid=1";
			ytPlayer.loadVideoById(myvideo);

			//prevent click propagation 
			return false;
	});
}

var done = false;
function onPlayerStateChange(event) {

	/*-1 :unstarted
	0: ended
	1: playing
	2: paused
	3: buffering
	5: video cued*/
	
	if (event.data == YT.PlayerState.PLAYING && !done) {
		done = true;
	}
	
	// playing
	if (event.data === 1){
		$('#ytapiplayer').addClass('active');
	} 
	// ended
	else if (event.data === 0){
		$('#ytapiplayer').removeClass('active');
		ytPlayer.playVideo();
	}
}

function vidRescale(){

  var w = $(window).width()+200,
    h = $(window).height()+200;

  if (w/h > 16/9){
    ytPlayer.setSize(w, w/16*9);
    $('#ytapiplayer').css({'left': '0px'});
  } else {
    ytPlayer.setSize(h/9*16, h);
    $('#ytapiplayer').css({'left': -($('#ytapiplayer').outerWidth()-w)/2});
  }
}


