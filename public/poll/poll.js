function castVote(){
	var formCompleted = qFormAPI.validate("pollForm");
		
	if(formCompleted){
		var pollAjax = ajaxObj();
		var pollVoteAjax = ajaxObj();
		var pollID = fieldEscape($("pollID").value);
		var pollOptionID = fieldEscape($s('input:radio[name='+document.pollForm.pollOptionID+']:checked').val());
		
		if(isset($("pollSubOption"))) var pollSubOptionID = fieldEscape($("pollSubOption").value);
		else var pollSubOptionID = "0";
		
		var modData = new Object();
		modData["function"] = "addRecord";
		modData["pollID"] = pollID;
		modData["pollOptionID"] = pollOptionID;
		modData["pollSubOptionID"] = pollSubOptionID;
		var requestParams = "modData=" + encodeURIComponent(Object.toJSON(modData));
		ajaxPost(pollAjax,"/cmsAPI/poll/pollVotes.php",requestParams,false,1);
				
		var requestParams = "function=setPrevPoll&pollID=" + pollID;
		
		pollVoteAjax.onreadystatechange=function(){
			if(pollVoteAjax.readyState==4) $s("pollContainer").innerHTML="Thank for you participating.";
		}
		
		pollVoteAjax.open("POST","/cmsAPI/poll/pollVotes.php",true);
		pollVoteAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		pollVoteAjax.setRequestHeader("Content-length", requestParams.length);
		pollVoteAjax.setRequestHeader("Connection", "close");
		pollVoteAjax.send(requestParams);
	}
}

function publicPollQforms(){
	if(isset($s("pollOption"))){
		pollFormObj = new qForm("pollForm");
		
		if(!isset($s("pollSubOption"))) pollFormObj.required("pollOptionID");
		else{
			pollFormObj.required("pollOptionID,pollSubOption");
			pollFormObj.pollSubOption.description = $s("pollSubOp").innerHTML;
		}
		
		pollFormObj.pollOptionID.description = $s("pollOption").innerHTML;
	}
}