<?php
	$navPrefix = "";
	switch($priModObj[0]->navType){
		case 0: #top nav
			if($priModObj[0]->isSubNav){
				$navPrefix = "satpto_";
			}
			else{
				$navPrefix = "atpto_";
			}
			break;
		case 1: #side nav
			if($priModObj[0]->isSubNav){
				$navPrefix = "satpo_";
			}
			else{
				$navPrefix = "atpo_";
			}
			break;
		case 2: #bottom nav
			if($priModObj[0]->isSubNav){
				$navPrefix = "satpbo_";
			}
			else{
				$navPrefix = "atpbo_";
	
			}
		break;
	}
?>
<?php echo $navPrefix.$priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);

//backup of our initial nav
<?php echo $navPrefix.$priModObj[0]->className ?>.stealthNav = $s('navOuter-<?php echo $priModObj[0]->className ?>').outerHTML;
accordionTreeObjs.<?php echo $navPrefix.$priModObj[0]->className; ?> = <?php echo $navPrefix.$priModObj[0]->className; ?>;

<?php #we need to set some variables to pass to our ajax request to grab the pages for the nav module ?>
<?php echo $navPrefix.$priModObj[0]->className; ?>.rootPage = "<?php echo $priModObj[0]->subNavParentPageID; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.subNav = "<?php echo $priModObj[0]->isSubNav; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.className = "<?php echo $priModObj[0]->className; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.isResponsive = "<?php echo $priModObj[0]->isResponsive; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.menuHeight = "<?php echo $priModObj[0]->menuHeight; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.menuWidth = "<?php echo $priModObj[0]->menuWidth; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.collapsed = "<?php echo $priModObj[0]->collapsed; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.overlapWidth = <?php echo $priModObj[0]->overlapWidth; ?>;
<?php echo $navPrefix.$priModObj[0]->className; ?>.collapseOnClick = <?php echo $priModObj[0]->collapseOnClick; ?>;
<?php echo $navPrefix.$priModObj[0]->className; ?>.triggerPoint = <?php echo $priModObj[0]->triggerPoint; ?>;
<?php echo $navPrefix.$priModObj[0]->className; ?>.direction = "<?php echo $priModObj[0]->direction; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.hamburgerAnimation = "<?php echo $priModObj[0]->hamburgerAnimation; ?>";
<?php echo $navPrefix.$priModObj[0]->className; ?>.responsiveNavType = "<?php echo $priModObj[0]->responsiveNavType; ?>";

<?php
	#only load this script in once
	if(!isset($standardNavScript)){
		
		#don't load in the script again
		global $standardNavScript;
		$standardNavScript = true;
?>
function refreshNavigation(){
	//Loop through all of our navigation objects on the page and refresh them with the right pages for the user's priveledges
	for(var prop in accordionTreeObjs){
		accordionTreeObjs[prop].refresh();
	}
}

//set the accordion root for initial page load...
$(function(){
	accordionTree.prototype.lastExpandedRoot = pageArray[<?php echo $_GET["pageID"]; ?>];
});

//Make an ajax call to refresh the navigation
accordionTree.prototype.refresh = function(){
    var navObj = ajaxObj();
    var requestParams = "function=getPageTree"+
                        "&page="+this.rootPage+
                        "&type="+this.navType+
                        "&class="+this.className+
                        "&sub="+this.subNav+
                        "&first=true";
    
    navObj.navContainer = this.navID;
    navObj.navobj = this;
    navObj.onreadystatechange=function(){
        if(navObj.readyState===4){
            var nav = navObj.responseText;
			//remove all existing nav items in the nav module dom
            $(navObj.navContainer).find(".nc").remove(); 
            if(nav.length > 0){
            
                //restore to desktop nav
                $s('navOuter-' + navObj.navobj.className).outerHTML = navObj.navobj.stealthNav;
                
                //add new pages
                $(navObj.navContainer).find(".navHeader + ul").html(nav); //insert new nav items if we get any
                
                //backup nav html
                 navObj.navobj.stealthNav =  $s('navOuter-' + navObj.navobj.className).outerHTML;
                 
                //change to responsive if needed
                responsiveNav();
            }
        }
    }
    
    ajaxPost(navObj,"/cmsAPI/pages/pages.php",requestParams,false,1,null,false);
}

//initialize the over events and states for the nav
accordionTree.prototype.hoverInit = function(){
	//this triggers in ff android on click, so disable for all mobile - jared
	if(!isMobile){
		$(document).on("mouseenter",".nc",function(e){
			$(this).children(".ec").andSelf().addClass("hover");
		});

		$(document).on("mouseleave",".nc, .ec",{stealthNavObj:this},function(e){
			e.data.stealthNavObj.collapseNav(this);
		});

		//add fakeHover on the navOuter
		$(document).on("mouseenter",".navInner > ul > .nc.hc",{stealthNavObj:this},function(e){	
			e.data.stealthNavObj.navHover(this,true,e);
		});

		//remove fakeHover on the navOuter
		$(document).on("mouseleave",".navInner > ul > .nc.hc",{stealthNavObj:this},function(e){
			e.data.stealthNavObj.navHover(this,false,e);
		});
	}
}

<?php echo $navPrefix.$priModObj[0]->className; ?>.bodyHideNav = function(event){
	//click outside the menu to close it
	if(
		!$(event.target).is("#navOuter-<?php echo $priModObj[0]->className; ?>") && 
		!$(event.target).is("#responsiveBtn-<?php echo $priModObj[0]->className; ?>") &&
		!$(event.target).parents("#navOuter-<?php echo $priModObj[0]->className; ?>").is("#navOuter-<?php echo $priModObj[0]->className; ?>") &&
		//its currently a mobile nav
		$$s("mobileNav").length > 0
	){
		$("#navOuter-<?php echo $priModObj[0]->className; ?>").multilevelpushmenu( 'collapse' );
		$(".hamburger--<?php echo $priModObj[0]->hamburgerAnimation; ?>").removeClass("is-active");
	}
}

if(isMobile) {
	var clickEventType = 'touchend';
}
else {
	var clickEventType = 'click';
}

$(window).on(clickEventType, <?php echo $navPrefix.$priModObj[0]->className; ?>.bodyHideNav);
<?php
	}
?>
