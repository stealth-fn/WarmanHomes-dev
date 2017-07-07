<?php
#Full Height Banner Images
if($priModObj[0]->priKeyID==1){
?>
#mfmc-fhBanImg {
    height: 100vh;
    left: 0;
    position: fixed;
    text-align: center;
    top: 100px;
    width: 100%;
}

#mfmcc-fhBanImg{
	height:100%;
}

.icp-fhBanImg{
	padding-top:30vh;
}

.gimg-fhBanImg{
    position: fixed;           /*Make it full screen (fixed)*/
    right: 0;
    bottom: 0;
    z-index: -1;               /*Put on background*/

    min-width: 100%;           /*Expand video*/
    min-height: 100%;
    width: 100%;
    height: auto;

    top: 50%;                  /*Vertical center offset*/
    left: 50%;                 /*Horizontal center offset*/

    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);         /*Cover effect: compensate the offset*/
}

@media screen and (max-aspect-ratio: 16/9) {
	.gimg-fhBanImg{
		width: auto !important;    /*Keep aspect ratio - important for mobile*/
		/*top:30%;*/
	}
}

@media screen and (max-width: 1117px) {
	.gimg-fhBanImg{
		width: auto !important;    /*Keep aspect ratio - important for mobile*/
		/*top:30%;*/
	}
}
<?php
}
?>

<?php
#Full Height Banner Images Thumbs
if($priModObj[0]->priKeyID==3){
?>
	#mfmc-fhBanThumbImg{
		position:fixed;
		bottom:10vh;
		display:inline-block;
		margin:0px auto;
	}
	
	.mi_fhBanThumbImg{
		display:inline-block;
	}
<?php
}
?>

<?php
#Gallery Images
if($priModObj[0]->priKeyID==348){
?>
#mfmcc-galImg{
	text-align:center;
}

.mi-galImg{
	width:100%;
}
<?php
}
?>

<?php
#Gallery Image Thumbs
if($priModObj[0]->priKeyID==349){
?>

#mfmcc-galImgThmb{
	position:relative;
	text-align:center;
}

.mi-galImgThmb {
    display: inline-block;
    text-align: center;
    width: 250px;
	cursor:pointer;
}

.clicked{
	background:#CCC;
}
<?php
}
?>
