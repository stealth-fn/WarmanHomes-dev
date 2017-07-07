<?php

#specific employee

if($priModObj[0]->instanceID == 2){ 

?>

#mfmc-employee{

	margin-top: 31px;

	float: left;

	width: 75%;

}



#mfh-employee{

}



#mfmcc-employee{

}



.mi-employee{

	margin-left: 213px;

}



.mi-employee.mi-odd{

}



.mi-employee.mi-even{

}



.employeeName-employee{

	color: #660226;

	font-size: 18px;

	margin-bottom: 10px;

}



.employeeTitle-employee{

	color: #919191;

	font-style:italic;

	margin-bottom: 10px;

}



.employeeBio-employee{

}



.employeeBio-employee img{

	position: absolute;

	top: 0;

	left: 0;

}



.employeeBio-employee p {

	margin-bottom: 15px;

}



#pcpy{

	overflow: auto;

}



<?php

}

if($priModObj[0]->instanceID == 2 && $_GET["pageID"] == 3){ 

?>



#mfmc-employee{

	width:100%;

}



<?php

}

if($priModObj[0]->instanceID == 1){

?>



#mfmc-employeeList{

	min-height: 441px;

	float: left;

	width: 25%;

}



.expandWrap.expanded{

    background-color:red;

}



.expandWrap{

    background-color:blue;

}



.closeBtn{

    width:25px;

    height:25px;

    background-color:yellow;

}



#mfh-employeeList{

	margin-bottom: 29px;

}



#mfmcc-employeeList{

	max-width: 182px;

}



.mi-employeeList{



}



.employeeName-employeeList{

	line-height: 25px;

}



.employeeName-employeeList a{

	color:#000;

}



#corporateTeam{

	position: absolute;

	left: 174px;

	top: 267px;

}

<?php

}

#list of employee names

if($priModObj[0]->instanceID == 1 && $_GET['pageID'] == 11){

?>

#mfmc-employeeList{

	min-height: 441px;

	float: none;

	width: 25%;

}

<?php

} 

?>