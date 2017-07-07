<?php
	#View Order Mini Details
	if($priModObj[0]->instanceID == 1){ 
?>	
#mfmc-myOrders {
	background: #eeeeee none repeat scroll 0 0;
	border: 1px solid #cccccc;
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
	display: inline-block;
	margin: 36px 35px 0;
	overflow: hidden;
	padding-bottom: 20px;
	padding-left: 20px;
	padding-right: 20px;
	vertical-align: top;
	width: 500px;
}
#mfh-myOrders {
	border-bottom: 1px solid #CCCCCC;
	font-size: 16px;
	font-weight: 600;
	margin-bottom: 20px;
	padding-bottom: 16px;
	padding-top: 15px;
	width: 100%;
}
#mfh-myOrders:before {
	content: "";
	width: 0;
}
#moduleHelp, #helpText, .moduleOneMoreBtn, #moduleItemLangContainer,  .modDspQtyContainer {
	display: none;
}
.mi-myOrders {
	height: auto;
	overflow: auto;
	margin-bottom: 10px;
}
.mi-myOrders div {
	float: left;
	margin-right: 10px;
}
<?php } ?>

<?php
	#View Order Details - INVOICE
	if($priModObj[0]->priKeyID == "385" ){
?>
.invoice-box {
	max-width: 800px;
	margin: auto;
	padding: 30px;
	border: 1px solid #eee;
	box-shadow: 0 0 10px rgba(0, 0, 0, .15);
	font-size: 16px;
	line-height: 24px;
	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	color: #555;
}
.invoice-box table {
	width: 100%;
	line-height: inherit;
	text-align: left;
}
.invoice-box table td {
	padding: 5px;
	vertical-align: top;
}
.invoice-box table tr td:nth-child(3), .invoice-box table tr td:nth-child(2) {
	text-align: right;
}
.invoice-box table tr.top table td {
	padding-bottom: 20px;
}
.invoice-box table tr.top table td.title {
	font-size: 45px;
	line-height: 45px;
	color: #333;
}
.invoice-box table tr.information table td {
	padding-bottom: 40px;
}
.invoice-box table tr.heading td {
	background: #eee;
	border-bottom: 1px solid #ddd;
	font-weight: bold;
}
.invoice-box table tr.option td {
	background: #f8fafa none repeat scroll 0 0;
}
.invoice-box table tr.option > td:first-of-type {
    text-indent: 16px;
}
.invoice-box table tr.details td {
	padding-bottom: 20px;
}
.invoice-box table tr.item > td {
	border-bottom: 1px solid #eee;
}
.invoice-box table tr.item.last td {
	border-bottom: none;
}
.invoice-box table tr.total td:nth-child(3), .invoice-box table tr.total td:nth-child(2) {
	border-top: 2px solid #eee;
	font-weight: bold;
}

@media only screen and (max-width: 600px) {
	.invoice-box table tr.top table td {
		width: 100%;
		display: block;
		text-align: center;
	}
	.invoice-box table tr.information table td {
		width: 100%;
		display: block;
		text-align: center;
	}
}

<?php } ?>