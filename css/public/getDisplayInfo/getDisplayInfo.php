.displayUserInfoOutter .dspUserInfo::before,
.displayUserInfoOutter .dspUserInfo::after{
	display:inline-block;
}

.displayUserInfoOutter .dspUserInfo::before{
	content:"Welcome! ";
}

.displayUserInfoOutter .dspUserInfo::after{
	content:" How are you?";
}

.getDispInfoContainer{
	font-size:0px;
	padding-top: 30px;
}

.getDispInfoContainer form{
	max-width: 600px !important;
}

input[name="userInfo"] {
    border-radius: 9px 0 0 9px !important;
    display: inline-block !important;
    max-width: 500px !important;
}

input[name="infoSub"] {
    border-radius: 0 9px 9px 0 !important;
    display: inline-block !important;
    max-width: 50px !important;
	cursor:pointer;
	background:#238db2;
	color:#FFF;
}


@media screen and (max-width: 640px) {
	#mainHeader{
		font-size:30px;
	}
	
	#mainHeader ~ h3{
		font-size:20px !important;
	}
	
	input[name="userInfo"] {
		max-width: 250px !important;
	}
}