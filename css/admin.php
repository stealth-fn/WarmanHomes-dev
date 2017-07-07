/*****************Custom Font Support************************/
@import url('https://fonts.googleapis.com/css?family=Ubuntu');
@import url('https://fonts.googleapis.com/css?family=Lato');
/*****************Common Styles**********************/

html, body {
	height: 100%;
	min-height: 600px;
}
#body-10 {
	overflow-x: hidden !important;
}
#pc-10 #adminHeader, #pc-10 #lngContainer, #pc-10 #mfmc-adminStandardLogin {
	display: none;
}
body {
	background: #fff url('/images/admin/background-right.jpg') repeat-y right top;
	color: #323232;
	font-family: 'Lato', Arial, sans-serif;
	font-size: 16px;
}
h1, h2, h3, h4, h5 {
	color: #000;
	font-weight: normal;
	text-align: center;
}
h1 {
	font-size: 36px;
}
h2 {
	font-size: 30px;
}
h3 {
	font-size: 18px;
}
a, input[type="button"] {
	cursor: pointer;
	text-decoration: none;
}
.invalidForm {
	background-color: #FF0000 !important;
}
.pc {
	box-sizing: border-box !important;
	margin: 0 auto;
	min-height: 100%;
	overflow: auto;
	position: relative;
	right: 0;
	width: 100%;
	font-size: 12px;
}
.pcpy {
    box-sizing: border-box;
    height: auto;
    margin: 0 auto;
    max-width: 1400px;
    padding: 60px 60px 100px;
    position: relative;
}
.mobileNav ~ .pcpy {
	padding: 180px 60px 100px;
}
.pageText {
	margin: 0 auto;
	max-width: 1004px;
	position: relative;
}
.pcpy > .mfmc {
    margin: auto;
    position: relative;
    text-align: center;
}
.mobileNav ~ .pcpy::before {
    background-color: #fff;
    content: "";
    height: 100px;
    left: -1000px;
    position: fixed;
    top: 0;
    width: 2000px;
    z-index: 5000;
}
@media screen and (min-width: 1000px) {
	.pcpy > .mfmc {
		text-align: left;
	}
}
.pcpy > .mfmc > .mfmcc {
	position: relative;
}
/*module items in record lists, not for recursive/level > 2 modules*/
.pcpy > .mfmc > .mfmcc > .tempMod {
	border-bottom: 1px solid #9c9c9c;
	box-sizing: border-box;
	cursor: move;
	line-height: 40px;
	min-height: 40px;
	overflow: hidden;
	padding-bottom: 10px;
	padding-top: 10px;
	position: relative;
	text-align: right;
	vertical-align: top;
}
.pcpy > .mfmc > .mfmcc > .tempMod:hover {
	background: #eee none repeat scroll 0 0;
}
/*admin image thumbnails*/
.pcpy > .mfmc > .mfmcc > .mi .gimg {
	height: 40px;
	padding: 0 !important;
	width: auto !important;
}
/*record information, the product listing is wrapped in a form element*/
.tempMod > div, .tempMod > form > div, .tempMod > a, .tempMod > form > a, .tempMod > img, .tempMod > form > img {
	display: inline-block;
	float: left;
	line-height: 20px;
	margin-left: 20px;
	padding-top: 10px;
	text-align: left;
	width: 130px;
}
/*level 2 and 3 modules shoulds be wider*/
.pcpy > .mfmc > .mfmcc > .tempMod > .mfmc {
	padding: 0;
}
.pcpy > .mfmc > .mfmcc > .tempMod > .mfmc > .mfmcc {
}
.pcpy > .mfmc > .mfmcc > .tempMod > .mfmc > .mfmcc > .mi {
}
/*we don't want image captions or descriptions for module levels > 2*/
.tempMod .tempMod .gn {
	display: none;
}
#loadingGif {
	left: 0;
	margin: 0 auto;
	display: none;
	position: absolute;
	right: 0;
	top : 25px;
	z-index: 1000;
}
#moduleItemLang {
    display: inline-block;
    margin-left: 10px;
    width: 150px !important;
}
#moduleItemLangContainer {
    position: absolute;
    right: 0;
    text-align: right;
    top: -40px;
    width: 300px;
}
#moduleItemLangContainer label {
    display: inline-block;
    line-height: 1;
    vertical-align: middle;
}
#helpText {
	display: none;
}
.mfp {
	display: table;
	margin: 50px auto 0;
	overflow: auto;
	padding-bottom: 50px;
	padding-top: 25px;
	position: relative;
}
.mfp a {
	color: #000000;
	cursor: pointer;
	display: block;
	float: left;
	font-size: 16px;
	padding: 10px;
	text-align: center;
	text-decoration: none;
}
.pgc:hover, .pgcClicked {
	background: none repeat scroll 0 0 #018AFF !important;
	color: #FFFFFF !important;
}
.pgc {
	background: none repeat scroll 0 0 #FFFFFF;
	padding-left: 20px !important;
	padding-right: 20px !important;
}
.mfpp {
	background: none repeat scroll 0 0 #000000;
	color: #FFFFFF !important;
}
.mfprvp:before {
	 content: "\300A  Previous";
}
.mfnp:before {
	content: "Next \300B";
}
.mfpi {
	background: none repeat scroll 0 0 #000000;
	height: 16px;
	position: relative;
	width: 20px;
}
.mfpi:before {
	color: #FFFFFF;
	content: "...";
	display: block;
	left: 0;
	position: absolute;
	width: 100%;
}
#pageFooter {
	font-size: 10px;
	margin-top: 30px;
	padding: 140px 0 20px 0;
	text-align: center;
}
/*******************************Datepicker********************************/


#ui-datepicker-div {
	background-color: #EEEEEE;
	border: 1px solid #000000;
	border-radius: 8px 8px 8px 8px;
	display: none;
	padding: 10px;
}
.ui-datepicker td a {
	color: #117FFC;
	text-align: center;
	vertical-align: middle;
}
.ui-datepicker td {
	border: 1px solid #000000;
	height: 21px;
	text-align: center;
	vertical-align: middle;
	width: 30px;
}
.ui-datepicker-next, .ui-datepicker-prev {
	display: block;
}
.ui-datepicker-prev {
	float: left;
}
.ui-datepicker-next {
	float: right;
}
.ui-datepicker-title {
	clear: both;
	margin-bottom: 10px;
	text-align: center;
}
/*********************Login Page Style**********************/
#contactNumber {
	color: #7fceff;
	font-family: Ubuntu;
	font-size: 26px;
	text-shadow: #0a5b9b 2px -2px 4px;
	height: 94px;
	left: 400px;
	overflow: visible;
	position: absolute;
	text-align: center;
	top: 398px;
	width: 200px;
}
#contactNumber span {
	color: #eee !important
}
#copyright {
	font-size: 11px;
	left: 0;
	margin: 0 auto;
	padding-bottom: 30px;
	position: absolute;
	right: 0;
	text-align: center;
	top: 770px;
}
/************Landing Page Style*****************/

#welcomePara {
	margin: 100px 0 0 504px;
	text-align: right;
	width: 500px;
}
#welcomePara p {
	padding-left: 95px;
}
/**********Module Item List Style***********/

#moduleInterface, #moduleHelp {
	display: inline-block;
}
#moduleInterface {
	margin-right: 25px;
	width: 675px;
}
#moduleHelp {
	position: absolute;
	right: 0;
	top: -10px;
}
#helpHideButton {
}
#helpText {
    background-color: #eef5ed;
    box-shadow: 0 0 43px rgb(0, 0, 0);
    left: 50%;
    margin: auto;
    max-height: 90vh;
    max-width: 80vw;
    overflow: scroll;
    position: fixed;
    text-align: left;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    z-index: 900000;
}
#helpTextWrapper {
	padding: 50px;
}
#helpCloseButton {
    display: block;
    position: absolute;
    right: 50px;
    top: 19px;
}
#helpTextWrapper img {
    max-width: 100%;
}
#moduleIndex {
	border-top: 1px solid #eee;
	color: #888;
	font-size: 13px;
	margin-top: 35px;
}
.moduleIndexHeaderFooter {
	font-size: 10px;
	margin-top: 10px;
	position: absolute;
	width: 675px;
}
.moduleItem {
	border-bottom: 1px solid #eee;
	cursor: move;
	height: 73px;
	margin: 5px 0;
	padding-top: 6px;
	position: relative;
	vertical-align: middle;
}
.moduleItemDescription p {
	clear: right;
	float: left;
	margin: 0 0 5px 5px;
	padding: 4px 4px;
	width: 592px;
}
.moduleItemDescription .galImgPrev {
	float: left;
	height: 70px;
	position: relative;
}
.descriptionInner div {
	display: inline-block;
}
.moduleItem:hover {
	background-color: #eee;
	color: #323232;
}
.moduleItemEdit, .moduleItemDelete, .adminLstLnk, .moduleItemEditDraft, .moduleItemDeleteDraft {
	cursor: pointer !important;
	display: inline-block !important;
	float: none !important;
	padding: 0 !important;
	position: relative;
	text-align: right !important;
	vertical-align: middle;
	width: auto !important;
}
.moduleItemDelete::before, .moduleItemDeleteDraft::before {
	background: transparent url("/images/admin/Sprites.png") repeat scroll -690px center;
	content: "";
	display: inline-block;
	height: 20px;
	vertical-align: middle;
	width: 25px;
}
.moduleItemEdit::before, .moduleItemEditDraft::before {
	background: transparent url("/images/admin/Sprites.png") repeat scroll -640px center;
	content: "";
	display: inline-block;
	height: 20px;
	vertical-align: middle;
	width: 25px;
}
.moduleQuickEdit {
	display: none !important;
}
#moduleItemAdd1 {
	left: 0;
	position: absolute;
	top: -45px;
	z-index: 200;
}
#moduleItemAdd2 {
	bottom: -45px;
	position: absolute;
	right: 96px;
}
#moduleItemBulk1 {
	left: 80px;
	position: absolute;
	top: -45px;
	z-index: 200;
}
#moduleItemBulk2 {
	bottom: -45px;
	position: absolute;
	right: 0;
}
#moduleItemArchived1 {
	left: 177px;
	position: absolute;
	top: -45px;
	z-index: 200;
}
#moduleItemArchived2 {
	bottom: -45px;
	position: absolute;
	right: 178px;
}
.modDspQtyContainer {
	position: absolute;
	right: 0;
	top: -35px;
}
.lstQtyLbl {
	padding-right: 10px;
}
#modDspQty {
}
.moduleItemAdd, .moduleItemBulk, .moduleItemArchived {
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
	background: #1c1c1c none repeat scroll 0 0;
	color: #fff;
	line-height: 1;
	padding: 10px 16px;
}
.subModuleEdit {
}
/*******Pages specific formatting**********/

.moduleContainer #linkPageURL {
 //background:url('/images/admin/input-http.jpg') center left no-repeat;
 //padding-left:40px !important;
 //width: 406px !important;
}
/*******Polls specific formatting**********/

#pollOptionsContainer, #pollSubOptionsContainer {
	margin: 30px 0 !important;
}
.moduleContainer form[name=moduleForm] div #oneMorePollOption, .moduleContainer form[name=moduleForm] div #oneMorePollSubOption {
	background: transparent url('/images/admin/button-add-small.jpg') left 50% no-repeat;
	padding-left: 18px;
	width: auto;
}
/********Date picker formatting**********/
#jspostDate_calendar {
	background: white;
	border: 1px solid #999;
	border-radius: 5px;
	width: 205px;
}
#jspostDate_calendar div, #jspostDate_calendar td {
	text-align: centre !important;
}
#jspostDate_calendar tbody {
	display: block;
	padding: 5px;
}
#jspostDate_caldayheading td {
	display: inline-block;
	float: left;
	margin-left: 2px;
	text-align: left;
	width: 23px;
}
#jspostDate_caldayheading {
	margin-top: 3px;
}
#jspostDate_calcells {
	margin: 3px 0;
}
#jspostDate_calcells td {
	float: left;
	margin-left: 6px;
	width: 19px;
}
.wkhead {
	display: none;
}
/**validation modal display**/
.modal {
}
.modal .modalInner {
	background-color: #FFF;
	border: 1px solid #F0F0F0;
	border-radius: 1px;
	-webkit-box-shadow: 0px 0px 20px 10px #0251c5;
	-moz-box-shadow: 0px 0px 20px 10px #0251c5;
	-o-box-shadow: 0px 0px 20px 10px #0251c5;
	box-shadow: 0px 0px 20px 10px #0251c5;
	color: #000;
	overflow-x: hidden;
	padding-bottom: 8px;
	text-align: center;
}
.modal-formError .modalInner > span {
	display: block;
	color: #CCC;
	font: italic 400 13px/13px "Arial", "Helvetica", sans-serif;
	margin-bottom: 12px;
}
.modal-formError .modalInner > div {
	height: 90%;
	overflow-x: hidden;
	overflow-y: scroll;
}
.modal-formError .modalInner > span:first-child {
	color: #000;
	font-size: 22px;
	line-height: 22px;
	margin: 12px 0 2px;
}
.modal-formError ul li {
	font-style: italic;
	padding: 0px 20px 6px 20px;
	position: relative;
	text-align: left;
}
.modalInner ul {
	margin-top: 12px;
}
.modal-formError ul li > span {
	font: 600 14px/14px "Arial", "Helvetica", sans-serif;
	margin-right: 10px;
	text-align: left;
}
.modalInner li span {
	font-style: normal;
	padding-right: 13px;
}
.modalInner li {
	font-style: italic;
}
.modalErrorMsg {
	font-size: 12px;
	font-weight: 700;
}
.modalInner {
	margin-top: 5px;
	padding-top: 20px;
}

/********ui-wigit**********/

.ui-widget .selected, .ui-widget .available {
    width: 50% !important;
}
.ui-widget {
    width: 100% !important;
}
.ui-widget-content {
    font-size: 10px !important;
    max-width: 400px;
    width: 97% !important;
}
