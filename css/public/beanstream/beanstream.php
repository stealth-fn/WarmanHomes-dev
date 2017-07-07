@import url('https://fonts.googleapis.com/css?family=Lato');

#beanstreamPageOutter {
    margin: auto;
    max-width: 1400px;
	font-family: 'Lato', sans-serif;
	color: #3c4542;
}
#beanstreamForm h2 {
    padding-bottom: 35px;
    padding-top: 35px;
}
input[type="checkbox"] {
    margin-right: 10px;
}
label {
    display: block;
    font-size: 18px !important;
    margin-bottom: 10px !important;
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
.field, .form-group {
    display: inline-block;
    margin-bottom: 12px;
    padding: 1em;
    text-align: left;
    width: 100%;
}
.btn {
    background-color: #fff;
    border: 2px solid #999;
    display: block;
    font-size: 18px;
    line-height: 1;
    margin: 35px auto 0;
    padding: 10px 15px;
    text-align: center;
    width: 250px;
}
.field.select select {
    display: inline-block;
    margin: 4px;
    width: 48%;
}
select {
    -webkit-appearance:none;
	-moz-appearance:none;
	-o-appearance:none;
	appearance:none;
    background-image: url("/images/dropdown-btn.png");
    background-position: right center;
    background-repeat: no-repeat;
}
select::-ms-expand {
  display:none;
}


@media screen and (min-width: 900px) {
	.field {
		vertical-align: top;
		width: 49.8%;
	}
}