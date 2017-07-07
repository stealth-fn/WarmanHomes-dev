var apiPath = "/cmsAPI/calendar/calendarEvents.php";
var moduleAlert = "Calendar Event";

timeFieldArray["event_time"] = "event_time";
dateFieldArray["event_date"] = "event_date";

function setQforms(){
	moduleFormObj = new qForm("moduleForm");
	moduleFormObj.required("event_title,event_desc,event_time,event_date");
	moduleFormObj.event_title.description = "Event Title";
	moduleFormObj.event_desc.description = "Event Description";
	moduleFormObj.event_time.description = "Event Time";
	moduleFormObj.event_date.description = "Event Date";
	
	moduleFormObj.event_date.validateDate();
	moduleFormObj.event_time.validateTime();
}

function setCalendar(){
	var declarevent_date = new Epoch("jsevent_date","popup",document.getElementById("event_date"));
}