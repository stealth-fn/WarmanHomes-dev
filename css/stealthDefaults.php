/*CMS Defaults**********/

/*makes sure the height is always at least the height of the window*/
html, body { 
	font-size:16px;
	height: 100%;
	line-height:1.5rem;
}

.pc { 
	min-height:100%; 
}

.sb {
	display:inline-block;
}

#li {
	opacity: 0;
	display:none;
}

.clss, .pgcHidden {
	display:none !important;
}

input, select {
    vertical-align:middle;
}

.moduleQuickEdit{
    margin: 0 !important;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 495;
	cursor:pointer;
}

/*slider buttons*/
.mcl{
	position:absolute;
	cursor:pointer;
	width:30px;
	height:65px;
	background:#000;
	margin:auto;
	top:0px;
	bottom:0px;
	z-index:100;
}

.mcl::before{
	display:block;
	width:100%;
	height:100%;
	position:absolute;
	top:0px;
	left:0px;
	line-height:65px;
}

.mcll{
	left:0px;
}

.mcll::before{
	content:"<";
}

.mclr{
	right:0px;
}

.mclr::before{
	content:">";
}

.modRecNumSep{
	display:inline-block;
}

.modRecNumSep::before{
	display:inline-block;
	content:"/";
}

/*Accordion styles**********************/
.expandBtn{
	cursor:pointer;
}

/*Module Item/Form for quick edits**********************/
#pc + .mi{
	position:absolute;
	left:0px;
	right:0px;
	margin:0px auto;
	z-index:10000;
}

/*.ec{
	display:none;
}*/

.ec.expand {
	display:block;
}<?php PHP_EOL; ?>


input[type="button"] {
    -webkit-appearance: none;
    -webkit-border-radius: 0;
}

<?php
	#only on the public side
	if($_SESSION["domainID"] > 0) {
?>
/*input defaults**********************/
input[type="text"], input[type="tel"], input[type="email"], 
input[type="number"], input[type="password"], input[type="date"], select {

}
 
input[type="radio"] {
     margin: 1px 0 4px 10px;
}
 
input[type="checkbox"]{
 
}
 
textarea{
    height: 145px;
    padding: 10px;
}

.modDspQtyContainer {
	display: none;
}

.invalidLabel {
	color: red;
}

<?php } PHP_EOL; ?>

.subAddEditFrame{
	min-width:100%;
	min-height:100%;
}

.quickEditContainer{

}

.hidden {
    display: none;
}