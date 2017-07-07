<?php
	#admin standard items - DO NOT TOUCH
	if($_SESSION["domainID"] < 0) {
?>
<div id="adminHeader"> 
	<img
		alt="Stealth CMS"
		id="adminClientLogo"
		src="/images/admin/logo-project.png"
	/>
</div>
<div id="adminFooterOutter">
	<div id="adminFooterInner"> 
	<diV>
		<img
			alt="Stealth Interactive Media"
			height="30"
			id="adminStealthLogo"
			src="/images/admin/adminLogo.png"
			width="174"
		/>
		</div>
    	<div id="adminCopyright"> 
			Copyright &copy; <?php date("Y"); ?>
      		Stealth Interactive Inc.  All Rights Reserved 
		</div>
  	</div>
</div>
<?php
	}
	#public side standard
	else {
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/standardContent/standardContentNew.php");
		$footerObj = new standardContentPublic(false);
		$footer = $footerObj->getRecordByID(1);
		if(mysqli_num_rows($footer) > 0){
			$x = mysqli_fetch_assoc($footer);
			if (strlen($x["footerContent"]) > 0) {
				echo '<div id="footerBottom">'.$x["footerContent"].'</div>';
			}
		}
?>
<div id="footer">
	<div id="footerInner">	
		<div id="bottomCopyright">
			Copyright &copy; <?php echo date('Y'); ?> Client Company Name
		</div>
		<div id="privacyFiles"> 
			<a 
				target="_blank" 
                href="/images/Privacy_Policy_NSC%20Minerals.pdf"
            >Privacy Policy</a>&nbsp;| 
            <a 
                target="_blank" 
                href="/images/Terms%20of%20Use%20NSC%20Minerals.pdf"
            >Terms of Use</a> &nbsp;| 
            <a target="_blank" href="/sitemap.php">Site Map</a>
        </div>
        
        <div id="stealthLogoLink">
            <a 
                title="Edmonton Web Design" 
                target="_blank" 
                href="http://stealthmedia.com/web-design/Edmonton-Web-Design"
            > 
                <img 
                    width="81" 
                    height="14" 
                    src="/images/Stealth-Retina-white.png" 
                    id="stealthLogo"
                    alt="Stealth Media Logo"
                /> 
            </a>
        </div> 
    </div>
</div>

<?php
	}
?>
