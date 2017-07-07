/*reset css**********/
html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre,
abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp,
small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li,
fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, 
section, summary, time, mark, audio, video, select, input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
    margin:0;
    padding:0;
    border:0;
    font-size:100%;
    vertical-align:baseline;
	background: transparent;
	position:relative;
	
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

main{
	display:block;
}

form{
	position:static;
}

:focus{
    outline:0;
}

article,aside,details,figcaption,figure,
footer,header,hgroup,nav,section { 
    display:block;
}

nav ul {
    list-style:none;
}

ul{
	list-style-position: inside;
}

blockquote, q {
    quotes:none;
}

blockquote::before, blockquote::after,
q::before, q::after {
    content:'';
}

a {
    margin:0;
    padding:0;
    font-size:100%;
    vertical-align:baseline;
    background:transparent;
}

del {
    text-decoration: line-through;
}

abbr[title], dfn[title] {
    border-bottom:1px dotted;
    cursor:help;
}

table {
    border-collapse:collapse;
    border-spacing:0;
}

sub, sup {
	font-size: 75%;
	line-height: 0;
	vertical-align: baseline;
}
 
sup {
	top: -0.5em;
}
 
sub {
	bottom: -0.25em;
}

<?php
	if($_GET["msie"]){
?>
/*remove filters from IE9+*/
:root body *{
	filter:none !important;
}
<?php
	}
?>