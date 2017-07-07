<?php
#admin standard login
if($priModObj[0]->instanceID == -1){ 
?>

#pc-10 #mfmc-adminStandardLogin, #mfh-adminStandardLogin{
	display:none;
}

#mfmc-adminStandardLogin {
    height: 91px;
    position: absolute;
    right: 0;
    top: 0;
	z-index:2;
}

#mfmcc-adminStandardLogin {
    padding: 0 30px;
}
@media screen and (min-width: 900px) {
	#mfmcc-adminStandardLogin {
		padding: 0 60px;
	}
}

.mi-adminStandardLogin {
    float: right;
    position: relative;
    text-align: right;
    width: 200px;
}

.lb-adminStandardLogin, #lw-adminStandardLogin1 {
    color: #009ada;
    cursor: pointer;
    font-size: 20px;
    padding-bottom: 10px;
    text-transform: uppercase;
}

.lb-adminStandardLogin:hover {

}

lb-adminStandardLogin:active {
	position:relative;
	top:1px;
}

.lc-adminStandardLogin {
    float: none !important;
    margin-left: 0 !important;
    padding: 0 !important;
    text-align: right !important;
    top: 20px;
}

#lbp-adminStandardLogin {
    background: url("/images/admin/menu-buttons/silver-logout.png") no-repeat scroll right -14px #000000;
    border: medium none;
    color: #ffffff;
    float: right;
    font-size: 23px;
    height: 32px;
    line-height: 30px;
    padding-right: 60px;
    position: relative;
}

#lbp-adminStandardLogin:hover{
	    background: url("/images/admin/menu-buttons/silver-logout.png") no-repeat scroll right -147px #000000;
}

#lw-adminStandardLogin{
	display:none;
}

.lbp {
    background-color: #000;
    border: 1px solid #000;
    color: #fff;
    padding: 3px 12px;
}

.mobileNav ~ #mfmc-adminStandardLogin {
    left: 0;
    position: fixed;
    right: auto;
    text-align: left;
    top: 2px;
    z-index: 5001;
}
.mobileNav ~ #mfmc-adminStandardLogin .mi-adminStandardLogin {
	width: auto;
}
.mobileNav ~ #mfmc-adminStandardLogin .lc-adminStandardLogin {
    text-align: left !important;
}
<?php

	}

?>



<?php

#admin log in screen
if($priModObj[0]->instanceID == -2){ 

?>
#mfmc-adminLogin{
    margin-left: 10px;
    margin-right: 10px;
    max-width: none;
    position: relative;
}

#mfmc-adminLogin:before{
    background: url("/images/admin/logo-project.png") no-repeat scroll 0 50% / 100% auto rgba(0, 0, 0, 0);
    content: "";
    display: block;
    height: 270px;
    margin: auto;
    max-width: 420px;
    position: relative;
	max-height: 260px;
}

#mfmcc-adminLogin{
    margin: 0 auto;
    position: relative;
    max-width: 420px;
	height:auto;
}

.mi-adminLogin {
    border-bottom: medium none !important;
    cursor: default !important;
    max-width: 420px !important;
    overflow: visible !important;
    padding: 0 !important;
    width: 100% !important;
	height:auto !important;
}

#lc-adminLogin1{
    margin-left: 0;
    width: 100%;
	overflow: visible !important;
	height:auto;
	float: none;
}

.mi-adminLogin:hover {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
}

#lc-adminLogin1 input[type="text"], 
#lc-adminLogin1 input[type="password"]{
	width:100%;
	height:60px;
	margin-bottom:30px;
	/*line-height:60px;*/
	text-align:center;
	font-size:24px;
	color:#000;	
	box-sizing:border-box;
	border-radius:0px;
	border: 1px solid;
}

#lc-adminLogin1 input[type="password"]::-webkit-input-placeholder{
	color:#000;
	opacity:100;
	text-align:center;
}
 
#lc-adminLogin1 input[type="password"]:-moz-placeholder{
	color:#000;
	opacity:100;
	text-align:center;
}
 
#lc-adminLogin1 input[type="password"]::-moz-placeholder{
	color:#000;
	opacity:100;
	text-align:center;
}
 
#lc-adminLogin1 input[type="password"]:-ms-input-placeholder{
	color:#000;
	opacity:100;
	text-align:center;
}

#lbp-adminLogin1{
    background: none repeat scroll 0 0 #1C1C1C;
    border: medium none;
    color: #FFFFFF;
    font-size: 24px;
    height: 60px;
    left: 0;
    padding-left: 44px;
    padding-right: 44px;
	width:100%;
}

.noLog-adminLogin{
	margin-top:25px;
	text-align:center;
}

#nl-adminLogin {
    background: none repeat scroll 0 0 #E42529;;
    border: medium none;
    color: #FFFFFF;
    font-size: 18px;
    height: 60px;
    line-height: 60px;
    padding-left: 40px;
    padding-right: 40px;
	pointer-events: none;
    cursor: default;
	
	transition: all 0.5s;
}

<?php

}

?>

<?php
	#cart login page
	if($priModObj[0]->priKeyID == -43){ 
?>
#mfmc-cartLogin {
    background: #eeeeee none repeat scroll 0 0;
    border: 1px solid #cccccc;
    display: inline-block;
    margin: 16px;
    max-width: 500px;
    vertical-align: middle;
    width: 100%;
}
#mfh-cartLogin {
    border-bottom: 1px solid #cccccc;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 16px;
    padding-top: 15px;
    width: 100%;
}
#lif-cartLogin1 {
    padding: 16px;
}
#mfmc-cartLogin textarea, #mfmc-cartLogin input[type="text"], #mfmc-cartLogin input[type="password"] {
    border: 1px solid #cccccc;
    display: block;
    margin: 5px 0;
    padding: 5px;
    width: 100%;
}
#lbp-cartLogin1 {
    background-color: #fff;
    border: 1px solid #ccc;
    cursor: pointer;
    display: block;
    padding: 15px;
    width: 100%;
}
#lbp-cartLogin1:hover {
    background-color: rgba(255, 255, 255, 0.5);
    font-weight: bold;
}
.passRsContainer {
    background-color: #fff;
    padding: 16px;
}
.passRsContainer h2 {
    font-size: 16px;
    font-weight: 600;
}
.passRsContent {
    margin-bottom: 15px;
    text-align: center;
}
.passRsContainer label {
    width: auto;
}
.passRsContainer label, .passRsContainer input {
    display: inline-block !important;
	width: auto !important;
}

	
<?php
	}
?>

<?php

	#standard login

	if($priModObj[0]->instanceID == 1){ 

?>



#mfmc-standardLogin{

    left: 832px;

    margin: 0 auto;

    overflow: visible;

    position: absolute;

    right: 0;

    top: 13px;

    width: 78px;

	z-index:500;

}



#mfmcc-standardLogin{



}



#mfh-standardLogin{display:none;}





.mi-standardLogin{



}



.lb-standardLogin {

    cursor: pointer;

    position: absolute;

    top: 0;

    width: 80px;

}



.lb-standardLogin:hover {



}



#lbp-standardLogin1{

	margin-top:10px;

	padding: 5px 8px;

}



.lc-standardLogin{

    background: none repeat scroll 0 0 #3A3A3A;

    height: 150px;

    padding: 10px;

    position: absolute;

    right: 0;

    top: 40px !important;

    width: 260px;

	border-radius:8px;

}



#lb-standardLogin1{

    height: 34px;

    line-height: 33px;

    position: absolute;

    text-align: right;

    width: 78px;

	padding-right:10px;

	cursor:pointer;

	

	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */

	-moz-box-sizing: border-box;    /* Firefox, other Gecko */

	box-sizing: border-box;         /* Opera/IE 8+ */

}



#lb-standardLogin1:before{
    content: "";
    display: block;
    height: 34px;
    left: 8px;
    position: absolute;
    top: 8px;
    width: 18px;	
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

#lw-standardLogin{
	display:none;
}

<?php

	}

?>



<?php

	#cart login page

	if($priModObj[0]->priKeyID == 238){ 

?>

	#mfmc-cartLogin{

		background: none repeat scroll 0 0 #EEEEEE;

		border: 1px solid #CCCCCC;

		bottom: 474px;

		left: -540px;

		margin: 0 auto;

		padding-bottom: 20px;

		padding-left: 20px;

		padding-right: 20px;

		position: absolute;

		right: 0;

		width: 454px;

		overflow: visible;

		

		-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */

		-moz-box-sizing: border-box;    /* Firefox, other Gecko */

		box-sizing: border-box;         /* Opera/IE 8+ */

	}

	

	#mfh-cartLogin{

		border-bottom: 1px solid #CCCCCC;

		font-size: 16px;

		font-weight: 600;

		margin-bottom: 20px;

		padding-bottom: 16px;

		padding-top: 15px;

		width: 100%;

	}

	

	.lif-cartLogin > div{

		margin-bottom:5px;

	}

	

	.lc-cartLogin{

		width:454px;

	}

	

	#mfh-cartLogin:before,

	#mfh-cartLogin:after,

	.passRsContainer h2:before,

	.passRsContainer h2:after{

		content: "";

    	width: 0;

	}

	

	#mfmc-cartLogin textarea, #mfmc-cartLogin input[type="text"], 

	#mfmc-cartLogin input[type="password"] {

    	border: 1px solid #CCCCCC;

		display:block;

		margin:0px auto;

	}

	

	#lbp-cartLogin1{

		background: url("/images/01-A-Yutaka-HOME-navigation-cart.png") no-repeat scroll 10px center, linear-gradient(to bottom, #FDC42C 0%, #E88211 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);

		border: medium none;

		border-radius: 5px;

		display: block;

		height: 46px;

		line-height: 46px;

		margin: 0 auto;

		margin-top:20px;

		padding-left: 30px;

		position: relative;

		text-align: center;

		text-decoration: none;

		width: 130px;

		cursor:pointer;

	}

	

	/*LEVEL 2 MODULES DON'T LOAD THEIR OWN STYLE SHEETS*/

	.passRsContainer{

		background: none repeat scroll 0 0 #FFFFFF;

		border: 1px solid #CCCCCC;

		bottom: -160px;

		height: 141px;

		left: -21px;

		position: absolute;

		text-align: center;

		width: 452px;

	}

	

	.passRstEmail{

	}

	

	.passRstBtn{

		background: linear-gradient(to bottom, #FDC42C 0%, #E88211 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);

		border: medium none;

		border-radius: 5px;

		padding:8px;

	}

	

	.passRsContainer h2{

		font-size: 16px;

		font-weight: 600;

		left: 0;

		padding-bottom: 16px;

		padding-top: 15px;

		width: 414px;

	}

	

	.passRsContent{

		margin-bottom:15px;

		text-align:center;

	}

	

	.passRsContainer label,

	.passRsContainer input{

		display:inline-block !important;

	}

	

	.passRsContainer label{

		width:auto;

	}

	

<?php

	}

?>

