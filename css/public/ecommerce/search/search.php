<?php
	#standard ecommerce search
	if($priModObj[0]->instanceID == 1){ 
?>
	#ecommSearchContainer_stndEcomSrch{
		background-color: #3A3A3A;
		border: 1px solid #2E2E2D;
		border-radius: 5px 5px 5px 5px;
		height: 34px;
		left: 0;
		margin: 0 auto;
		position: absolute;
		right: 300px;
		top: 13px;
		width: 285px;
		z-index: 10;
	}
	
	#ecommSearchContainer_stndEcomSrch input{
		background-color:transparent;
		float:left;
		height:34px;
		border:none;
		line-height:34px;
	}
	
	#eSearchTerm_stndEcomSrch{
		width:240px;
		padding-left:10px;
	}
	
	#ecommSearchBtn_stndEcomSrch{
		background: url("/images/01-A-Yutaka-HOME-navigation-search.png") center center no-repeat;
		width:34px;
		cursor:pointer;
	}
<?php 
	}
?>