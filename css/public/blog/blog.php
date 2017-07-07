<?php
	#regular blog list and article
	if($priModObj[0]->priKeyID == "357" ){
?>

#mfh-blog {
}

#mfmc-blog {
    display: inline-block;
    max-width: calc(100% - 300px);
    padding-left: 50px;
    padding-right: 50px;
    position: relative;
    vertical-align: top;
    width: 100%;
}

.mi-blog{
	padding-bottom:50px;
}

.mi-blog > div, .mi-blog > .blogMoreLink{
	padding-bottom:15px;
}

.galImg-blog img{
	max-width:100%;
}

.bdate-blog, .btime-blog, .bauthor-blog{
	display:inline-block;
} 

/*RECOMMENDED BLOGS*/
div[class*="mi-recBlogs"] {
    display: inline-block;
    vertical-align: top;
    width: 200px;
}

div[class*="galImg-recBlogs"] img{
    max-width:100%;
}

<?php
	}
?>

<?php
	#regular blog list and article
	if($priModObj[0]->priKeyID == "253"){
?>

#mfh-article {
}

#mfmc-article {
	margin: 0 auto;
    min-height: 500px;
    position: relative;
    width: 925px;
}

.mi-article{
	padding-bottom: 200px;
    position: relative;
}

.blogBody-article{
	font-size: 18px;
}

.bn-article {
	font-family: librebaskerville;
    font-size: 20px;
    font-weight: bold;
    padding-bottom: 10px;
}

.bd-article {
	color: rgb(2, 81, 197);
    display: inline-block;
    font-size: 18px;
    line-height: 132px;
    margin-left: 60px;
}

.galImg-article {
	left: 0;
    position: absolute;
    top: 220px;
}

.galImg-article img {
}

<?php
	}
?>

<?php
	#news list
	if(
		$priModObj[0]->priKeyID == "297" 
	){
?>

#mfh-news {
	color: rgb(255, 255, 255);
    line-height: 128px;
    padding-bottom: 0;
}

#mfmc-news {
	margin: 0 auto;
    position: relative;
    width: 980px;
}

#mfmc-news:before {
	background: url("/images/Image-Banner.jpg") no-repeat scroll 0 0 transparent;
    content: "";
    display: block;
    height: 128px;
    left: -312px;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 1600px;
    z-index: -1;
}

#mfmcc-news {
	padding-bottom: 100px;
    position: relative;
    width: 755px;
}

#mfmcc-news:before {
	background: url("/images/Logo-Watermark.png") no-repeat scroll 0 0 transparent;
	content: "";
    display: block;
    height: 312px;
    position: absolute;
    right: -220px;
    top: 85px;
    width: 216px;
}

.mi-news {
    border-top: 2px solid rgb(2, 81, 197);
    padding-bottom: 70px;
    padding-top: 75px;
    position: relative;
}

.mi-news:first-child {
	border-top: none;
}

.bdate-news {
}

.blogMoreLink-news{
	height: 100%;
    position: absolute;
    top: 0;
    width: 100%;
}

.blogMoreLink-news:hover:after, .blogMoreLink-news:hover:before {
	display: block;
}

.blogMoreLink-news:after {
    background-color: rgba(2, 81, 197, 0.4);
    content: "";
    display: none;
    height: 392px;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 5px;
    width: 263px;
}

.blogMoreLink-news:before {
	bottom: 0;
    color: rgb(255, 255, 255);
    content: "LEARN MORE >";
    display: none;
    font-weight: bold;
    height: 50px;
    margin: auto;
    position: absolute;
    text-align: center;
    top: 0;
    width: 100%;
    z-index: 1;
}

.bn-news{
	font-size: 20px;
    padding: 0 0 20px;
}

.bdate-news {
	color: rgb(2, 81, 197);
    padding-bottom: 45px;
}


<?php
	}
?>

<?php
	#news list home page 
	if(
		$priModObj[0]->priKeyID == "298" 
	){
?>

#mfh-homeNews {
	font-size: 20px;
    font-weight: normal;
    padding-top: 85px;
}

#mfmc-homeNews {
	border-left: 1px solid rgb(219, 219, 219);
    height: 310px;
    left: 590px;
    margin: 0 auto;
    padding-left: 50px;
    position: absolute;
    right: 0;
    top: 595px;
    width: 350px;
}

#mfmcc-homeNews {
}

.mi-homeNews {
}

.blogMoreLink-homeNews{
	height: 100%;
    position: absolute;
    top: 0;
    width: 100%;
}

.blogBody-homeNews {
	font-size: 15px;
    padding-bottom: 15px;
}

.readMore-homeNews {
	font-size: 12px;
    text-align: right;
}

<?php
	}
?>