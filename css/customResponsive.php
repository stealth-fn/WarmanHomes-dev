.backItemClass i {
	display: none;
}

.backItemClass a {
    display: inline-block !important;
    line-height: 40px;
    width: 85%;
}

.multilevelpushmenu_wrapper ul {
	position: static;
}

.multilevelpushmenu_wrapper li {
	position: static;
	min-height: 60px;
	padding:10px;
}

.multilevelpushmenu_wrapper a {
    display: inline-block;
    padding-bottom: 15px;
    padding-top: 15px;
    vertical-align: middle;
	
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

.childShow {
    background: transparent url("/images/responsive-menu.png") no-repeat scroll center center / 32px auto;
    height: 40px;
    padding-bottom: 10px !important;
    padding-top: 10px !important;
    width: 15%;
}

.multilevelpushmenu_wrapper .ntp{
	width:85%;
}

/*this is the button that we click to go a specific open level*/
.cMenu > h2 > i {
    display: block;
    height: 4000px;
    position: absolute;
    right: 0;
    top: 0;
    width: 40px;
}

#navOuter-tNav_multilevelpushmenu.multilevelpushmenu_wrapper > .ltr{
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
	box-shadow: none;
}

/*makes long navs scrollable*/
.levelHolderClass ul {
	height:calc(100vh - 85px);
	overflow-x: hidden;
	overflow-y: auto;
}

/*this pseudoelement is so we can use vertical align on the text without a children link*/
.multilevelpushmenu_wrapper li:not(.hc)::after{
    content: "";
    display: inline-block;
    height: 60px;
    vertical-align: middle;
    width: 1px;
}

.multilevelpushmenu_wrapper .backItemClass {
    min-height: 60px;
}