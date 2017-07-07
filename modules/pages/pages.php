//ckEditor object
pagesAddEditObj.prototype.ckEditorFieldName = "pageCode";

pagesAddEditObj.prototype.parentPageChoose = function(frmBtn){
	var thisForm = frmBtn.form;
	
	var parentIDField = $(thisForm).find("input[name='parentPageID']");
	var pagelevelField = $(thisForm).find("input[name='pageLevel']");
	var selectValue = $(thisForm).find("select[name='parentPageSelect']").val().split(",");

	parentIDField.val(selectValue[0]);
	pagelevelField.val(parseInt(selectValue[1]) + 1);
};