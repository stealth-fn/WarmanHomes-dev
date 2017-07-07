<?php
$logoInfo = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/images/admin/logo-project.png');

echo '
<div 
	itemprop="image" 
	itemscope="itemscope" 
	itemtype="https://schema.org/ImageObject"
>
	<link  
		itemprop="url"
		href="' . $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/images/admin/logo-project.png"
	/>
	<meta 
		itemprop="height" content="' . $logoInfo[1] . '" 
	/>
	<meta 
		itemprop="width" content="' . $logoInfo[0] . '" 
	/>
	</div>
';
?>