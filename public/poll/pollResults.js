function togglePollResult(pollID){
	
	var pollDiv = document.getElementById("pollQuestionResultsContainer" + pollID);

	if(pollDiv.style.display != "none" && pollDiv.style.display.length != 0){
		pollDiv.style.display = "none";
	}
	else{
		pollDiv.style.display = "block";
	}
}