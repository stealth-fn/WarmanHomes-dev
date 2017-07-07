<?php
	#admin standard items
	if($_SESSION["domainID"] < 0) {
?>

#adminHeader {
    height: 91px;
    left: 28px;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1;
}
.mobileNav ~ #adminHeader {
    z-index: 0;
}
#adminClientLogo {
    bottom: 0;
    left: 28px;
    margin: auto;
    max-height: 60px;
    max-width: 174px;
    position: absolute;
    top: 0;
}

#adminFooterOutter {
    background: #1c1c1c none repeat scroll 0 0;
    bottom: 0;
    line-height: 1;
    padding: 15px 60px;
    position: absolute;
    width: 100%;
    z-index: 550;
}
#adminFooterInner {
    height: 100%;
    margin: 0 auto;
}
#adminStealthLogo {
    text-align: left;
    vertical-align: middle;
}
#adminCopyright {
    color: #ffffff;
    font-size: 13px;
    line-height: 1;
    text-align: right;
}
#adminFooterInner div {
    display: inline-block;
    vertical-align: middle;
    width: 49.8%;
}

@media screen and (max-width: 1000px) {
	#adminFooterInner div {
		text-align: center;
		width: 100%;
	}
	#adminCopyright {
		padding-top: 10px;
	}
	#adminFooterOutter {
		padding: 25px 60px;
	}
}
<?php
	}
?>

<?php
	#public side standard items
	if($_SESSION["domainID"] > 0) {
?> 
#footer, #footerBottom {
    background: #333 none repeat scroll 0 0;
    position: relative;
    width: 100%;
	z-index:10;
}
 
#footerInner {
    color: #fff;
    margin: 0 auto;
    padding-left: 5vw;
    padding-right: 5vw;
    text-align: center;
}
 
#footerInner div {
    display: inline-block;
    vertical-align: top;
    line-height: 70px;
	width: 33%;
}
 
#bottomCopyright {
    text-align: left;
}
 
#privacyFiles {
}
 
#stealthLogoLink {
    text-align: right;
}
 
@media screen and (max-width: 850px) {    
    #footerInner div {
    	text-align: center;
    	width: 100%;
   		line-height: 45px;
    }
}
<?php
	}
?>
