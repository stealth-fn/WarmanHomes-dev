/**validation modal display**/

.modal{


}



.modal .modalInner{

	background-color: #FFF;

	border: 1px solid #F0F0F0;

	border-radius: 1px;

	-webkit-box-shadow:0 0 10px 5px rgb(79, 193, 240);

	-moz-box-shadow:0 0 10px 5px rgb(79, 193, 240);

	-o-box-shadow:0 0 10px 5px rgb(79, 193, 240);

	box-shadow:0 0 10px 5px rgb(79, 193, 240);

	color: #000;

	overflow-x:hidden;

	padding-bottom: 8px;

	text-align: center;

}



.modal-formError .modalInner > span{

	display: block;

	color: #CCC;

	font: italic 400 13px/13px "Arial","Helvetica",sans-serif;

	margin-bottom: 12px;

}



.modal-formError .modalInner > div{

	height: 90%;

	overflow-x: hidden;

	overflow-y: scroll;

}



.modal-formError .modalInner > span:first-child{

	color: #000;

	font-size: 22px;

	line-height: 22px;

	margin: 12px 0 2px;

}



.modal-formError ul li{

	font-style: italic;	

	padding: 0px 20px 6px 20px;

	position: relative;

	text-align: left;

}



.modalInner ul{

    margin-top: 12px;

}



.modal-formError ul li > span{

	font: 600 14px/14px "Arial","Helvetica",sans-serif;

	margin-right: 10px;

	text-align: left;

}



.modalInner li span{

    font-style: normal;

    padding-right: 13px;

}



.modalInner li{

    font-style: italic;

}



.modalErrorMsg{

    font-size: 12px;

    font-weight: 700;

}



.modalInner{

    margin-top: 5px;

    padding-top: 20px;

}



/**quick add/edit modal display**/

#quickAddEdit{

}



#quickAddEdit .modalInner{

    height: auto !important;

    left: 0 !important;

    margin: 0 auto;

    overflow: auto !important;

    position: absolute !important;

    right: 0;

    top: 10px !important;

    width: 95% !important;

}



#quickAddEdit .mi{

    height: auto !important;

    overflow: auto;

}



.modalClose{

	background:#018AFF;

	cursor:pointer;

    height: 15px;

    padding: 5px;

    position: absolute;

	right:0px;

    top: 0;

    width: 15px;

    z-index: 10;



}