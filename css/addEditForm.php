/********Contact Us*******/
.borderWrapper {
    border: 2px solid #02a3dd;
    text-align: center;
}
.borderWrapper .radioGroupBlock {
    display: inline-block;
    text-align: center;
    width: 100%;
}
.borderWrapper .radioGroupBlock label {
    font-weight: bold;
    text-align: center !important;
}

@media screen and (min-width: 700px) {
	.borderWrapper .radioGroupBlock {
		width: 49%;
	}
}
/************Module Item Form Style***************/
#moduleContainer {
	display: inline-block;
	margin-right: 25px;
	width: 675px;
}
.moduleContainer form[name="moduleForm"] {
	position: relative;
}
.mi:not(.moduleContainerBlk) form[name="moduleForm"] > div {
	margin-bottom: 10px;
	min-height: 30px;
	position: relative;
}
.mi:not(.moduleContainerBlk) .ckEditContainer {
	width: 100% !important;
}
.addSubModBtn {
	height: 35px !important;
}
.moduleContainer form[name="moduleForm"] div > label {
    display: block;
    font-size: 14px;
    margin: 0 auto;
    padding: 10px 0;
    text-align: left;
}
.moduleContainer form[name="moduleForm"] div > input[type="text"], .moduleContainer form[name="moduleForm"] div > input[type="tel"], .moduleContainer form[name="moduleForm"] div > input[type="email"], .moduleContainer form[name="moduleForm"] div > input[type="number"], .moduleContainer form[name="moduleForm"] div > input[type="password"], .moduleContainer form[name="moduleForm"] div > input[type="date"], .moduleContainer form[name="moduleForm"] div > select {
    background-color: #fff;
    border: 1px solid #adadad;
    box-sizing: border-box;
    color: #000;
    font-size: 16px;
    margin: 0 auto 13px;
    padding: 5px 10px;
    width: 100% !important;
}
.moduleContainer form[name="moduleForm"] select {
    -webkit-appearance:none;
	-moz-appearance:none;
	-o-appearance:none;
	appearance:none;
    background-image: url("/images/dropdown-btn.png");
    background-position: right center;
    background-repeat: no-repeat;
	padding: 5px 60px 5px 10px !important;
}
.moduleContainer form[name="moduleForm"] select::-ms-expand {
  display:none;
}

#formpage_3 h2 {
	font-size: 30px;
    line-height: 1.5;
    padding: 25px 0;
    text-align: left;
}

.mapRow {
    margin-bottom: 10px;
    min-width: 30px;
}

@media screen and (min-width: 1000px) {
	.mi:not(.moduleContainerBlk) form[name="moduleForm"] > div, .mapRow {
		display: inline-block;
		padding: 0 0 0 1em;
		vertical-align: top;
		width: 49.8%;
	}
}
.moduleContainer form[name="moduleForm"] div >input[type="button"] {
	border: none;
	height: 30px;
	width: 30px;
}
.moduleContainer form[name="moduleForm"] div > textarea {
	border: 1px solid #888;
	border-radius: 0px;
	font-size: 13px;
	min-height: 130px;
	position: relative;
	vertical-align: middle;
	width: 100%;
	margin: 13px auto;
}
.moduleContainer form[name="moduleForm"] div > select {
}
.moduleFormStyledSelect select {
}
.moduleFormStyledSelect {
}
.moduleFormStyledSelect:hover {
}
.mi:not(.moduleContainerBlk) > form > .radioGroupBlock, .mi:not(.moduleContainerBlk) > form > .optionsParent {
    display: inline-block !important;
    min-width: 150px !important;
    text-align: left;
    width: 49% !important;
}

@media screen and (min-width: 1000px) {
	.mi:not(.moduleContainerBlk) > form > .radioGroupBlock, .mi:not(.moduleContainerBlk) > form > .optionsParent {
		width: 24% !important;
	}
}
.toggleOptions {
	display: none;
}
.toggleOptions > div {
	box-sizing: border-box;
	padding-left: 10px;
}
.optionsParent:hover .toggleOptions {
	max-height: 150px;
	overflow-y: scroll;
	position: absolute;
	z-index: 20;
	display: block !important;
	background: #FFF;
	border: solid #CCC 1px !important;
	border-top: 0px;
	top: 100%;
	font-size: 11px;
	width: 300px !important;
}
.optionsParent:after {
	content: "";
	display: block;
	position: absolute;
	width: 0px;
	height: 0px;
	bottom: 0px;
	right: 0px;
	border-bottom: 8px solid #0F0;
	border-left: 8px solid transparent;
}
.moduleContainer form[name="moduleForm"] .radioGroupBlock span, .moduleContainer form[name="moduleForm"] .subModuleElement .radioGroupBlock span {
	display: inline-block;
	font-size: 11px;
	margin-bottom: 10px;
	margin-top: 10px;
	vertical-align: baseline;
	width: auto !important;
}
.moduleContainer form[name="moduleForm"] .radioGroupBlock span input, .moduleContainer form[name="moduleForm"] .subModuleElement .radioGroupBlock span input {
	display: inline !important;
	vertical-align: middle;
	width: auto !important;
	margin-top: 0;
}
.moduleContainer form[name="moduleForm"] div input.buttonAddSmall, .moduleContainer form[name="moduleForm"] div input.buttonTimeSmall, .moduleContainer form[name="moduleForm"] div input.buttonDeleteSmall, .moduleContainer form[name="moduleForm"] div input.buttonEditSmall {
	background: url("/images/admin/button-add-small.jpg") no-repeat scroll left center rgba(0, 0, 0, 0);
	height: 30px;
	line-height: 30px;
	margin: 0;
	overflow: visible;
	padding-left: 30px;
	text-align: left;
	text-indent: 0;
	width: 150px;
}
.moduleContainer form[name="moduleForm"] div input.buttonAddSmall {
	display: none;
}
.moduleContainer form[name="moduleForm"] div input.buttonTimeSmall {
	background: transparent url('/images/admin/button-clock-small.jpg') center 50% no-repeat;
}
.moduleContainer form[name="moduleForm"] div input.buttonDeleteSmall {
	background: transparent url('/images/admin/button-delete-small.jpg') center 50% no-repeat;
}
.moduleContainer form[name="moduleForm"] div input.buttonEditSmall {
	background: transparent url('/images/admin/button-edit-small.jpg') left 50% no-repeat;
	padding-left: 18px;
	width: auto;
}
.moduleContainer form[name="moduleForm"] .adminShowHideParent {
	margin-bottom: 13px;
	cursor: pointer;
}
.moduleContainer form[name="moduleForm"] .adminShowHideParent span {
	font-size: 10px !important;
	position: relative;
	margin-left: 3px !important;
	vertical-align: middle;
	width: 200px !important;
}
.moduleContainer form[name="moduleForm"] .moduleSubElement {
	margin: 10px 0;
}
.moduleContainer form[name="moduleForm"] .moduleSubElement > div, .moduleContainer form[name="moduleForm"] .adminShowHideChild > div {
    margin-bottom: 10px;
    margin-left: 50px;
    min-height: 30px;
    position: relative;
    text-align: left;
}
.moduleContainer form[name="moduleForm"] .moduleSubElement span, .moduleContainer form[name="moduleForm"] .moduleSubElement label {
	width: 125px;
}
.moduleContainer form[name="moduleForm"] .moduleSubElement span {
	display: inline-block;
	font-size: 13px;
	vertical-align: baseline;
	width: 400px;
}
.adminShowHideChild {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #000;
    display: none;
    height: auto;
    max-height: 150px;
    overflow: auto;
    position: absolute !important;
    width: 84%;
    z-index: 10;
}
.adminShowHideChild div {
    display: inline-block !important;
    margin: 0 !important;
    padding: 5px 15px !important;
    text-align: left;
    width: 100%;
}
@media screen and (min-width: 1000px) {
	.adminShowHideChild div {
		width: 49%;
	}
}
.adminShowHideChild div > div {
    width: 100%;
}
.adminShowHideChild div span {
	width: auto !important;
}
.moduleContainer form[name="moduleForm"] input[name="moduleAddEditBtn"], input[name="moduleAddEditLiveBtn"], input[name="moduleAddEditDraftBtn"], .moduleIndexButton, .bulkAll, .moduleOneMoreBtn, input[name="uploadFile"] {
    background: #1c1c1c none repeat scroll 0 0 !important;
    border: medium none;
    box-sizing: border-box;
    color: #fff;
    display: inline-block;
    line-height: 1;
    margin: 16px;
    min-width: 150px;
    padding: 25px 16px;
    text-align: center;
    width: 25%;
}
.moduleAddEditBtn, .moduleAddEditLiveBtn {
	
}
.moduleAddEditDraftBtn {
	
}
.moduleOneMoreBtn {
	
}
.moduleIndexButton {
	position: relative;
}
.moduleContainer form[name="moduleForm"] input[name=moduleAddEditBtn]:hover, .moduleAddEditDraftBtn:hover, .moduleOneMoreBtn:hover, .moduleContainer form[name="moduleForm"] input[name=uploadFile]:hover {
	background: #0C9BD7;
}
.moduleContainer form[name="moduleForm"] .modSubElRem {
	background: transparent url('/images/admin/button-delete-small.jpg') top left no-repeat;
	height: 16px;
	margin-top: 5px;
	position: absolute;
	right: 0;
	width: 16px;
}
/********ckEditor formatting tweaks*******/
.moduleContainer form[name="moduleForm"] .cke_skin_kama {
	border: none;
	padding: none;
}
.moduleContainer form[name="moduleForm"] .cke {
	margin-bottom: 13px;
}
 <?php  if(isset($priModObj[0]->defaultGalleryID) && is_numeric($priModObj[0]->defaultGalleryID)) {
?> .addEditGalSelect {
 display:none !important;
}
<?php
}
?>
