<?php
	#public side FAQ's
	if($_SESSION["domainID"] > 0){
?>
#mfmc-faqCat{
	max-width:1004px;
	margin:0px auto;
	position:relative;
}

.faqCategory{
	margin-bottom:40px;
}

#mfmc-faqCat .mi, #mfmc-faqCat .mi div{
	margin-bottom:30px;
	position:relative;
}

#mfmc-faqCat .mi .mi{
	padding-left:50px;
}

.faqAns{
	display:none;
}

.faqQuestion{
	padding-top:4px;
}

.expanded .faqAns{
	display:block;
}
<?php
}
?>