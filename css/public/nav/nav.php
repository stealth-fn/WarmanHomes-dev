/*HIDE CHILDREN NAV BY DEFAULT*/ 
.navOuter:not(.mobileNav) .ec{ 
	display:none;
	opacity:0;
}

/*SHOW ON HOVER*/ 
.navOuter:not(.mobileNav) .ec.hover{ 
	display:inline-block;
	opacity:1;
}

.responsiveBtn{
	display:none;
}

.mNav .responsiveBtn,
.mNavExp  .responsiveBtn
{
    background: #037695;
    cursor: pointer;
    display: block !important;
    height: 100px;
    position: fixed;
    right: 0;
    top: 0;
    width: 100px;
    z-index: 50000;
	border:none;
}
<?php
#sub-top nav
if($priModObj[0]->instanceID == -1){
?>
#navOuter-sNavTop{
    height: 40px;
    left: -790px;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 50px;
    width: 200px;
}

#pageText2260 ~ #navOuter-sNavTop {
	display: none;
}

.sntl1 {
	color: #F2A41F;
    margin-bottom: 15px;
}

.sntl1:before {
	background: url("/images/07-A-Yutaka-Products-CategoryLandingPage-arrow.png") no-repeat scroll 0 0 transparent;
    content: "";
    display: block;
    float: left;
    height: 12px;
    margin-right: 5px;
    position: relative;
    top: 2px;
    width: 10px;
}

.sntl2, .sntl2.fakeHover{
    float: left;
    margin-left: 15px;
    margin-top: 10px;
    position: relative;
}

.nc.fakeHover > a{
	color:#A66600;
}

.stpc1,.stpc2{
	display:none;
}

.stpc1{
	position:absolute;
	left:10px;
	background-color:#FFB640;
	padding:10px;
	border-radius:5px 5px 5px 5px;
	width:150%;
}

.stpc2{
	position:absolute;
	left:40%;
    background-color: #4A11AE;
  	padding:10px;
	border-radius:5px 5px 5px 5px;
}

#navHeader-sNavTop{
	text-decoration:none;
	left:-60px;
}

.sntp{
	color:#FFC973;
	text-decoration:none;
}

#sntid_sNavTop2148{
	display:none;
}
<?php
}
?>

<?php
//DO NOT REMOVE THE ADMIN NAV CSS BELOW;
if($priModObj[0]->priKeyID == -100){
?>

#navOuter-adminTopNav:not(.mNav) {
    background-color: #232027;
    margin: 91px auto 0;
    overflow: visible;
    position: relative;
    width: 100%;
    z-index: 500;
}

#navInner-adminTopNav{
    height: 100%;
    margin: 0 auto;
    position: relative;
    z-index: 1;
	text-align:center;
	line-height:100%;
}

#navHeader-adminTopNav, #pc-10 #navOuter-adminTopNav{
	display:none;
}

#navOuter-adminTopNav:not(.mNav) .ntl1, #navOuter-adminTopNav:not(.mNav) .ntl1.fakeHover {
    background: #535152 none repeat scroll 0 0;
    box-sizing: border-box;
    display: inline-block;
    height: 63px;
    margin-right: 10px;
    margin-top: 17px;
    position: relative;
    text-align: center;
    width: 105px;
}

.ntl1.fakeHover, .ntl1:hover{ /*NAV LEVEL 1 ACTIVE STATE*/
	background-color: #0c9bd7;
}

.ntp{
	
}

#navOuter-adminTopNav:not(.mNav) .ntl1 > .ntp {
	display:block;
	width:100%;
	height:100%;
	padding-top: 42px;
    
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

.ntp{
	color: #FFFFFF;
	display:block;
}

/*CHILD PAGES CONTAINER STYLE (LEVEL 1)*/
.tpc1{ 
	background-color: #2c2b2b;
	left:0px;
	position: absolute;
	top:100%;
	width: 100%;
	z-index:10;
}

.ntl2{
	width:100%;
	padding-left: 4px;
    padding-right: 4px
}

.ntl2 > .ntp{
	padding-top:15px;
	padding-bottom:15px;
	line-height:1.5;
}

.ntl2 > .ntp:hover, .ntl2.fakeHover > .ntp{
	background:#009ada;
}

#navOuter-adminTopNav:not(.mNav) .ntl1 > .ntp::before {
	content: "";
	background: url('/images/admin/Sprites.png') no-repeat -349px -6px;
	width: 35px;
	height: 21px;
	position: absolute;
	left: 0;
	right: 0;
	margin: 0 auto;
	top: 10px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-11 > a:before {
	background-position: -910px -6px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-100 > a:before {
	background-position: -1390px -4px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-101 > a:before {
	background-position: -945px -4px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-159 > a::before {
	background-position: -980px -4px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-181 > a::before {
	background-position: -1421px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-269 > a::before {
	background-position: -1014px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-150 > a:before {
	background-position: -1048px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-179 > a::before {
    background-position: -1085px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-175 > a::before {
    background-position: -1119px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-174 > a::before {
    background-position: -1153px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-173 > a::before {
    background-position: -1188px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-171 > a::before {
    background-position: -1223px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-170 > a::before {
    background-position: -1261px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-167 > a::before {
    background-position: -1295px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-25 > a::before {
    background-position: -1328px -5px;
}

#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-102 > a::before {
     background-position: -1362px -5px;
}
#navOuter-adminTopNav:not(.mNav) #ntid_adminTopNav-182 > a::before {
     background-position: -426px -5px;
}

/*Mobile Specific*/
#navOuter-adminTopNav.mNav {
    left: 0;
    min-height: 100%;
    overflow: visible;
    position: fixed;
    top: 0;
    z-index: 5002;
}
#navOuter-adminTopNav.mNav::after {
    background-color: #009ada;
    content: "";
    height: 3px;
    left: 0;
    position: absolute;
    top: 99px;
    width: 100vw;
    z-index: -1;
}


.mNav .responsiveBtn,
.mNavExp .responsiveBtn
{
    background-color: #009ada !important;
}	
#navOuter-adminTopNav .multilevelpushmenu_wrapper .levelHolderClass {
    background: #1c1c1c none repeat scroll 0 0;
}
#navOuter-adminTopNav .multilevelpushmenu_wrapper li:hover {
    background-color: #009ada;
}
#navOuter-adminTopNav .multilevelpushmenu_wrapper .backItemClass {
    background: #009ada none repeat scroll 0 0;
}
<?php
	}

	#public top nav
	elseif($priModObj[0]->priKeyID == -200){
?>

#navOuter-tNav:not(.mNav){
    background:#FFF;
    left: 0;
    margin: 0 auto;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 50;
    
    -webkit-box-shadow: 0px -4px 10px 0px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:    0px -4px 10px 0px rgba(50, 50, 50, 0.75);
	box-shadow:         0px -4px 10px 0px rgba(50, 50, 50, 0.75);
}

#navOuter-tNav:not(.mNav) ul.hover{
	display:inline-block;
}

#navOuter-tNav:not(.mNav) li{
	padding-top:0px;
	padding-bottom:0px;
}

#navOuter-tNav:not(.mNav) #navInner-tNav{
    height: 100%;
    margin: 0 auto;
    text-align: right;
}

.navHeader:not(#navHeader-tNav){
	display: none !important;
}

#navOuter-tNav #navHeader-tNav {
    background-image: url("/images/admin/logo-project.png");
    background-repeat: no-repeat;
    background-size: contain;
    font-size: 0;
    height: 35px;
    width: 150px;
}

#navOuter-tNav:not(.mNav) #navHeader-tNav {
    float: left;
    margin-top: 4vh;
    position: relative;
    z-index: 1;
}

#navOuter-tNav.mNav #navHeader-tNav {
    left: 7px;
    position: fixed;
    top: 35px;
}

#navOuter-tNav:not(.mNav) .ntl1 {
    display: inline-block;
    margin-left: 30px;
    position: relative;
}

#ntid_tNav1 {
	margin-left: 0 !important;
}

#navOuter-tNav:not(.mNav) .ntl1 > .ntp {
    border-top: 2px solid rgba(0, 0, 0, 0);
    display: block;
    padding-bottom: 4vh;
    padding-top: 4vh;
    text-transform: uppercase;
}

#navOuter-tNav:not(.mNav) .ntl1 > .ntp:after {
}

#navOuter-tNav:not(.mNav) .fakeHover > a,
#navOuter-tNav:not(.mNav) .ntl1 > .ntp:hover {
	border-color: rgb(55, 138, 90) !important;
    color: rgb(55, 138, 90) !important;
}

#navOuter-tNav:not(.mNav) .fakeHover > .ntp:before, #navOuter-tNav:not(.mNav) .ntl1 > .ntp:hover:before {
}

#navOuter-tNav:not(.mNav) .ntl2.fakeHover > .ntp:before, #navOuter-tNav:not(.mNav) .ntl1 > .ntl2.ntp:hover:before {
	border-bottom: none;
}

#navOuter-tNav:not(.mobileNav) .tpc1 {
    display: none;
    left: 0;
    position: absolute;
    text-align: left;
}

#navOuter-tNav:not(.mNav) .tpc1 {
	width: 176px;
}

#navOuter-tNav:not(.mobileNav) .hover{
	display:inline-block;
}

#navOuter-tNav:not(.mNav) .tpc1 .ntp{
	background-color: rgb(55, 138, 90);
    color: rgb(255, 255, 255);
    display: block;
    height: 50px;
    line-height: 50px;
    padding: 0 20px;
}

#navOuter-tNav:not(.mNav) .tpc1 .ntp:hover, #navOuter-tNav:not(.mNav) .tpc1 .fakeHover > a {
	background-color: #414141;
    color: rgb(255, 255, 255) !important;
}

#navOuter-tNav:not(.mNav) .fakeHover{
}

#navOuter-tNav.mNav {
    left: 0;
    min-height: 100%;
    overflow: visible;
    position: fixed;
    top: 0;
    z-index: 5000;
}
<?php
	}

	#public bottom nav
	elseif($priModObj[0]->priKeyID == -300){
?>

<?php
	}
	#public side nav
	elseif($priModObj[0]->priKeyID == -80){
?>

#navOuter-sNavSide{
    display: block;
    left: -800px;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 480px;
    width: 190px;
}

#navOuter-sNavSide ul {
	display: none;
}

#pageText2252 ~ #navOuter-sNavSide, #pageText2259 ~ #navOuter-sNavSide {
	display: none;
}

#navInner-sNavSide ul {
	margin-left: 0;	
}

#navHeader-sNavSide{
	color: rgb(51, 51, 51);
    display: block !important;
    text-transform: uppercase;
}

#navInner-sNavSide {
    overflow: hidden;
}

.snl2{
	display: block;
    float: left;
    height: 53px;
    text-align: center;
    width: 200px;
}

.snl2 > a {
	border: 1px solid rgb(2, 81, 197);
    color: rgb(2, 81, 197);
    display: block;
    height: 100%;
    line-height: 53px;
    position: relative;
    width: 100%;
    
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

.snl2 > a:hover, #navInner-sNavSide .fakeHover > a {
	background-color: #0251c5;
    color: #fff;
}

#snid_sNavSide2259 {
	margin: 0 182px;
}

#navHeader-sNavSide + .snl2{
	border:none;
}
<?php 
	}
?>