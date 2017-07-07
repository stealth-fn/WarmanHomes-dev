<?php
	#regular blog list and article
	if($priModObj[0]->priKeyID > 0 ){
?>
 #contactPageOutter {
    margin: auto;
    max-width: 1400px;
	color: #3c4542;
}
#contactPageInner {
    text-align: center;
}
#contactPageInner label {
    display: block;
    font-size: 18px !important;
    margin-bottom: 10px !important;
}
input[type="checkbox"] {
    margin-right: 10px;
}
.radio label {
    font-size: 28px;
    padding: 0;
}
.radio {
    display: inline-block;
    padding: 1em 2em;
}
input[type="text"], input[type="tel"], input[type="email"], input[type="number"], input[type="password"], input[type="date"], select, textarea {
    border: 1px solid #999 !important;
    box-sizing: border-box !important;
    display: block;
    font-size: 18px !important;
    line-height: 1.5 !important;
    padding: 10px 15px !important;
    vertical-align: middle;
    width: 100%;
}
textarea {
    font-size: 30px;
    height: 250px;
}
.field, .textContainer {
    display: inline-block;
    margin-bottom: 12px;
    padding: 1em;
    text-align: left;
    width: 100%;
}

@media screen and (min-width: 900px) {
	.field {
		vertical-align: top;
		width: 49.8%;
	}
}

<?php
	}
?>