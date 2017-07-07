<?php
	#standard ecommerce search
	if($priModObj[0]->instanceID == 1){ 
?>
#lessonSearch {

}
#lessonSearch label {
    display: block;
    font-size: 20px;
    line-height: 1.5;
    padding-bottom: 10px;
}
#lessonSearch input[type="text"], #lessonSearch select {
	width: 100%;
}
#lessonSearch #lessonSearchBtn {
    background-color: #2cabda;
    border: medium none;
    color: #fff;
    font-size: 16px;
    line-height: 1;
    padding: 1em 4em;
    text-align: center;
    text-transform: uppercase;
	transition: background-color 0.5s ease;
	-webkit-transition: background-color 0.5s ease;
	-moz-transition: background-color 0.5s ease;
}
#lessonSearch #lessonSearchBtn:hover {
	background-color: #20befa;
}
.center {
 	text-align: center;
}
@media screen and (min-width: 1024px) {
	#lessonSearch .field {
		display: inline-block;
		min-width: 200px !important;
		padding: 1em;
		width: 49%;
	}
	#lessonSearch .fieldLong {
		display: block;
		padding: 1em;
		width: 98%;
	}
}


<?php 

	}

?>