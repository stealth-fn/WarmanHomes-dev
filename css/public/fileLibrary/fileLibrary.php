<?php
# Listing pages
if($priModObj[0]->priKeyID == "407"){
?>
.modDspQtyContainer {
	display: none;
}
.mi_lessonPlan {
    border-bottom: 1px solid #999999;
    padding: 16px 2em;
}
.mi_lessonPlan::before {
    bottom: 0;
    content: "❯";
    height: 27px;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 30px;
}
.mi_lessonPlan:hover {
	
}
.fileDesc-lessonPlan {
	color: #9ac238;
	 text-transform: uppercase;
}
.arrowLk {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}

.mi_lessonPlan .subject:first-of-type::before {
    color: #999999;
    content: "Subject:";
    padding-left: 35px;
    padding-right: 5px;
}
.mi_lessonPlan .subject:last-of-type::after {
    content: "";
}
.mi_lessonPlan .subject::after {
    content: ",";
}

.mi_lessonPlan .gradeWrapper {

}
.mi_lessonPlan .grade:first-of-type::before {
    color: #999999;
    content: "Grade:";
    padding-left: 35px;
    padding-right: 5px;
}
.mi_lessonPlan .grade:last-of-type::after {
    content: "";
}
.mi_lessonPlan .grade::after {
    content: ",";
}

.mi_lessonPlan .ageWrapper {

}
.mi_lessonPlan .age:first-of-type::before {
    color: #999999;
    content: "Age:";
    padding-left: 35px;
    padding-right: 5px;
}
.mi_lessonPlan .age:last-of-type::after {
    content: "";
}
.mi_lessonPlan .age::after {
    content: ",";
}

.mi_lessonPlan .description:first-of-type::before {
    color: #999999;
    content: "Description:";
    padding-left: 35px;
    padding-right: 5px;
}

<?php
}
?>
