<?php
							
if(!isset($_REQUEST["pmpm"])) {
	$lessonName = "";
	$subjectName = "";
	$lessonGrade = "";
	$lessonAge = "";
}
else {	
	$tempJson = json_decode($_REQUEST["pmpm"],true);
	if(!isset($tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Keyword"])) {
		$lessonName = "";	
	}
	else {
		$lessonName = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Keyword"];
	}
	
	if(!isset($tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Subject"])) {
		$subjectName = "";
	}
	else {
		$subjectName = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Subject"];
	}
	
	if(!isset($tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Grade"])) {
		$lessonGrade = "";
	}
	else {
		$lessonGrade = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Grade"];
	}
	
	if(!isset($tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Age"])) {
		$lessonAge = "";
	}
	else {
		$lessonAge = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Age"];
	}
	
}
?>

<div 
	class="lessonSearchContainer" 
	id="lessonSearch">
<form
		name="lessonSearch"  
		onsubmit="lessonSearch_<?php echo $priModObj[0]->className; ?>.lessonSearch(this); return false"
	>
	<div class="field">
		<label>Lesson Name:</label>
		<input 
				id="Keyword" 
				maxlength="100"
				name="Keyword"  
				type="text"
				<?php
					echo 'value = "'. $lessonName .'"';
				?>
			/>
	</div>
	<div class="field col2">
		<div class="cityDropdown">
			<label>Subject:</label>
			<div>
				<select id="Subject">
					<option value="0">All Subjects</option>
					<?php 
							include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCategory.php");
							$lessonSubjectObj = new fileLibraryCategory(false,NULL);
							$subjectList = $lessonSubjectObj->getAllRecords();
														
							while($x = mysqli_fetch_array($subjectList)){
								
								if ($subjectName == $x["priKeyID"]) {
									echo '<option selected value="'. $x["priKeyID"] .'">'. $x["fileCatDesc"].'</option>';
								}
								else {
									echo '<option value="'. $x["priKeyID"] .'">'. $x["fileCatDesc"].'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
	</div>
	<div class="field ">
		<div class="cityDropdown">
			<label>Grade:</label>
			<div>
				<select id="Grade">
					<option value="0">All Grades</option>
					<?php 
							include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryGrade/fileLibraryGrade.php");
							$lessonGradeObj = new fileLibraryGrade(false,NULL);
							$gradeList = $lessonGradeObj->getAllRecords();
														
							while($x = mysqli_fetch_array($gradeList)){
								
								if ($lessonGrade == $x["priKeyID"]) {
									echo '<option selected value="'. $x["priKeyID"] .'">'. $x["grade"].'</option>';
								}
								else {
									echo '<option value="'. $x["priKeyID"] .'">'. $x["grade"].'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="field ">
		<div class="cityDropdown">
			<label>Age:</label>
			<div>
				<select id="Age">
					<option value="0">All Age</option>
					<?php 
							include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryAge/fileLibraryAge.php");
							$lessonAgeObj = new fileLibraryAge(false,NULL);
							$ageList = $lessonAgeObj->getAllRecords();
														
							while($x = mysqli_fetch_array($ageList)){
								
								if ($lessonAge == $x["priKeyID"]) {
									echo '<option selected value="'. $x["priKeyID"] .'">'. $x["age"].'</option>';
								}
								else {
									echo '<option value="'. $x["priKeyID"] .'">'. $x["age"].'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="fieldLong" >

		<div class="btn center">
			<input 
			id="lessonSearchBtn"
			name="ecommSearchBtn" 			
			onclick="lessonSearch_<?php echo $priModObj[0]->className; ?>.lessonSearch(this.form); $('#lessonSearch').slideToggle()"
			type="button"
			value="Search" 
		/>
			<input type="submit" style="display:none"/>
		</div>
	</div>
</form>
</div>
<div id="map_canvas"></div>
