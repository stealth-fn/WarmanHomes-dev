.mi-yt {
	height: 100vh;
}

.cover {
	background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    
    opacity: 1;
}  

.bannerTxt {
	left: 50%;
    position: absolute;
    text-align: center;
    top: 50%;
    color: #fff;
    
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.bannerTxt p {
	font-size: 4.5vw !important;
    font-weight: 300;
    line-height: 1;
    padding-bottom: 20px !important;
}

.bannerTxt h1 {
	font-size: 20px;
    letter-spacing: 6px;
    text-transform: uppercase;
    padding-bottom: 15px;
}

.bannerTxt .btn {
	background-color: transparent;
    border: 2px solid #fff;
    height: 60px;
    line-height: 60px;
    width: 255px;
}

.bannerTxt .btn:hover {
	background-color: #fff;
    color: #444;
}

.tv {
	position: fixed;
	top: 0;
	left: 0;
	z-index: 0;
	
	width: 100%;
	height: 100%;
	
	overflow: hidden;
	background-color: transparent;
	
	-moz-transition: opacity 2s ease 0s,;
	-webkit-transition: opacity 2s ease 0s;
	transition: opacity 2s ease 0s;

	transition-timing-function: easeInOutCubic;
	
	opacity: 1;
}

.screen {
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1;
	
	margin: auto;
	
	opacity: 0;
	transition: opacity .5s;
}
.active {
	opacity: 1;
}

.bnImg-vidLst {
}

.bnImg-vidLst img, .vidImg, .headset-yt img, .vidImg-yt img {
	bottom: 0;
    height: auto;
    left: 50%;
    min-height: 100%;
    min-width: 100%;
    position: fixed;
    right: 0;
    top: 50%;
    width: 100%;
    z-index: -1;
    
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.overlay {
	background: #000;
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    
    -moz-transition: opacity 4s ease 0s,;
	-webkit-transition: opacity 4s ease 0s;
	transition: opacity 4s ease 0s;

	transition-timing-function: easeInOutCubic;
	
	opacity: 1;
}

.overlay.fadeOut, .tv.fadeOut {
	opacity: 0;
}

.headset-yt {
	height: 100vh;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
}

.cover {
	-moz-transition: opacity 2s;
	-webkit-transition: opacity 2s;
	transition: opacity 2s;

	transition-timing-function: easeInOutExpo;
}

.headset-yt, .vidImg-yt {
	-moz-transition: opacity 3s ease 0s, transform 2s ease 0s;
	-webkit-transition: opacity 3s ease 0s, transform 2s ease 0s;
	transition: opacity 3s ease 0s, transform 2s ease 0s;

	transition-timing-function: easeInOutCubic;
	
	opacity: 0;
}

.headset-yt.fadeIn, .vidImg-yt.fadeIn, .cover.fadeIn{
	opacity: 1;
}

.headset-yt.fullscreen {	
	-webkit-transform: scale(5);
    -moz-transform: scale(5);
    -o-transform: scale(5);
    -ms-transform: scale(5);
    transform: scale(5);
	
	transform-origin: center center;
	
	-moz-transition: opacity 2s ease 1s, transform 2s ease 1s;
	-webkit-transition: opacity 2s ease 1s, transform 2s ease 1s;
	transition: opacity 2s ease 1s, transform 2s ease 1s;

	transition-timing-function: easeInOutCubic;
	
	opacity: 0;
}

.headset-yt.hideIt {
	opacity: 0;
	
	-webkit-transform: scale(5);
    -moz-transform: scale(5);
    -o-transform: scale(5);
    -ms-transform: scale(5);
    transform: scale(5);
}

#tv.fullscreen {  
  	-webkit-transform: scale(2);
    -moz-transform: scale(2);
    -o-transform: scale(2);
    -ms-transform: scale(2);
    transform: scale(2);
}

.showIt {
	opacity: 1;
	
}

#tv .ytp-button {
	display: none;
}

@media screen and (max-aspect-ratio: 16/9) {
	.bnImg-vidLst img, .vidImg, .headset-yt img, .vidImg-yt img {
		width: auto !important;    /*Keep aspect ratio - important for mobile*/
	}
}

@media screen and (max-width: 1117px) {
	.bnImg-vidLst img, .vidImg, .headset-yt img, .vidImg-yt img {
		width: auto !important;    /*Keep aspect ratio - important for mobile*/
	}
}