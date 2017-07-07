#mfp-prodDesc {
    display: none;
}
.ratingBox {
    bottom: 0;
    left: 0;
    position: absolute;
}

<?php
	#Product Cart
	if($priModObj[0]->priKeyID == -42){ 
?>
.po-cart {
    display: inline-block;
    padding: 1em;
}
.galImg-cart {
    float: left;
    margin-right: 15%;
    width: 32%;
}
.galImg-cart img {
	width: 100%;
}
.mfmcc-cart {
	background-color: #e88112;
}
.mi-cart {
    background-color: #fff;
    border-bottom: 1px solid #000;
    font-family: lato;
    height: 100%;
    overflow: hidden;
    padding: 3em;
}
.mi-cart:last-child {
	border-bottom: none;
}
.hpn-cart {
	font-size: 20px;
	padding-bottom: 10px;
	text-transform: uppercase;
}
.hpp-cart {
	font-size: 18px;
	font-weight: bold;
}
.pql-cart {
	display: block;
	font-size: 14px;
}
.pqf-cart {
	display: block;
	padding: 10px;
	text-align: center;
	width: 30px;
}
#pc2463 {
	background-repeat: no-repeat;
}
.scq-cart, .rfc-cart {
	background: transparent none repeat scroll 0 0;
	border: 1px solid #e88112;
	color: #e88112;
	cursor: pointer;
	display: block;
	font-size: 12px;
	font-weight: 700;
	height: 60px;
	margin: 1rem auto;
	text-transform: uppercase;
	width: 200px;
}
.mem-cart {
	background-color: #fff;
	padding: 50px;
}
.scq-cart, .rfc-cart:hover {
	background-color: #e88112;
	color: #fff;
}
.scq-cart:hover {
	background-color: transparent;
	color: #e88112;
}
#mfmc-cart .modDspQtyContainer {
	display: none;
}

<?php } ?>


.ccd{
	background: linear-gradient(to bottom, #FDC52D 0%, #E88311 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	border-radius: 0 0 8px;
	font-size: 23px;
	left: 0;
	margin: 0 auto;
	padding: 20px 10px;
	position: fixed;
	text-align: center;
	top: 0;
	z-index: 500;
}

.pqf, .qtypo {
    border: 1px solid #000 !important;
    display: block;
    font-size: 18px !important;
    padding: 5px !important;
    text-align: center;
    width: 50px;
}
<?php
	#admin product list
	if($priModObj[0]->instanceID == -1){ 
?>

<?php
	}
?>
<?php
	#Product List
	if($priModObj[0]->priKeyID == 352){ 
?>
#mfh-prod {
	font-size: 65px;
	text-align: center;
	text-transform: uppercase;
}
#mfmcc-prod {
	text-align: center;
}
.mi-prod {
	display: inline-block;
	font-family: lato;
	margin: 0 1.3% 65px;
	overflow: hidden;
	text-align: left;
	vertical-align: top;
	width: 350px;
}
.mfmc-prodGal-prod {
	float: right;
	width: 600px;
	text-align: center;
}
.mfmc-prodGal-prod .mi {
	width: 100%;
}
.mfmc-prodGal-prod .gimg {
	max-width: 100%;
}
.mfmc-prodGalImgThumb-prodGal-prod {
	overflow: hidden;
}
.mfmc-prodGalImgThumb-prodGal-prod .mi {
	display: inline-block;
	width: 150px;
	cursor: pointer;
	vertical-align: top;
}
.mfmc-prodGalImgThumb-prodGal-prod .mi img {
	max-width: 100%;
}
.mi-prod:hover .galImg-prod::after {
	background-color: rgba(0, 0, 0, 0.5);
	content: "";
	height: 100%;
	left: 0;
	position: absolute;
	top: 0;
	width: 100%;
	z-index: 1;
}
.galImg-prod img {
	display: block;
	width: 100%;
}
.hpn-prod {
	font-size: 20px;
	padding: 10px;
	text-transform: uppercase;
}
.mi-prod:hover .hpn-prod {
	background-color: #fff;
}
.vpb-prod {
	background-position: 223px 165px;
	background-repeat: no-repeat;
	color: transparent;
	font-size: 14px;
	font-weight: 700;
	height: 100%;
	line-height: 350px;
	position: absolute;
	text-align: center;
	text-transform: uppercase;
	top: 0;
	width: 100%;
	z-index: 2;
}
.mi-prod:hover .vpb-prod {
	color: #fff;
}


<?php } ?>

<?php
	#Product Details
	if($priModObj[0]->priKeyID == 376){ 
?>
.po-prodDesc {
    display: inline-block;
    padding: 1em;
}
#mfmcc-prodDesc {
	color: #000;
	margin: 0 auto;
	max-width: 1210px;
	width: 95%;
}
.hpn-prodDesc {
	font-size: 65px;
	font-weight: 200;
	line-height: 1;
	padding: 30px 0 65px;
	font-family: lato;
	text-transform: uppercase;
}
.hpoc-prodDesc {
    padding: 25px 0;
}
.hpoc-prodDesc h3 {
	padding-top: 25px;
}
.mfmc-prodGal-prodDesc {
	float: left;
}
.mfmc-prodGal-prodDesc {
	margin-right: 3vw;
	max-width: 580px;
}
.mi_prodDesc {
    font-family: lato;
}
.mi_prodGalImg img {
	max-width: 100%;
}
.mfmc-prodGalImgThumb-prodGal-prodDesc .mfmcc {
	font-size: 0;
	line-height: 1;
	overflow: hidden;
	padding: 35px;
}
.mfmc-prodGalImgThumb-prodGal-prodDesc .mfmcc .mclr::before, .mfmc-prodGalImgThumb-prodGal-prodDesc .mfmcc .mcll::before {
	display: none;
}
.mi_prodGalImgThumb {
	cursor: pointer;
	display: inline-block;
	margin: 3px;
	width: 120px;
}
.mi_prodGalImgThumb img {
	width: 100%;
}
.prdc-prodDesc {
	box-sizing: border-box;
	line-height: 2;
	min-height: 400px;
	padding-left: 52%;
	position: relative;
	z-index: -1;
}
.prdc-prodDesc ul {
	list-style-type: none;
}
.prdc-prodDesc li {
	background-position: left 6px;
	background-repeat: no-repeat;
	padding-left: 30px;
}
.hpp-prodDesc {
	font-size: 20px;
	font-weight: 700;
}
.pqf-prodDesc {
	display: block;
	font-size: 18px;
	margin: 15px 0;
	padding: 14px;
	text-align: center;
	width: 40px;
}
.scq-prodDesc {
	background: transparent none repeat scroll 0 0;
	border: 1px solid #e88112;F
	color: #e88112;
	cursor: pointer;
	display: block;
	font-size: 12px;
	font-weight: 700;
	height: 60px;
	margin: 1rem auto;
	text-transform: uppercase;
	width: 200px;
}
.scq-prodDesc:hover {
	background-color: #e88112;
	color: #fff;
}
.vid-prodDesc {
	display: block;
}
.mfmc-prodGal-prodDesc .mcl {
	display: none;
}
.mfmc-prodGalImgThumb-prodGal-prodDesc .mcl {
	display: inline-block;
}
.modDspQtyContainer {
	display: none;
}


<?php } ?>