function setBlogComment(){
	blogCommentAddEditObj = new stealthInputCommon();
	blogCommentAddEditObj.apiPath = "/cmsAPI/blog/blogComment.php";
	blogCommentAddEditObj.moduleAlert = "Blog Post";
	blogCommentAddEditObj.setQforms = function(){
        moduleFormObj = new qForm("moduleForm");	
        <?php
            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 2){
        ?>
                moduleFormObj.required("postCopy,postDate,postTime,publicUserID,validatedComment");
                moduleFormObj.postDate.description = "Post Date";
                moduleFormObj.postTime.description = "Post Time";
                moduleFormObj.validatedComment.description = "Validated";
                moduleFormObj.publicUserID.description = "Public User";
                moduleFormObj.postDate.validateDate();
                    
                    //safari bug
                    //moduleFormObj.postTime.validateTime();
        <?php
            }
            else{
                echo 'moduleFormObj.required("postCopy,anonymousName,commenterEmail");';
            }
        ?>
		moduleFormObj.anonymousName.description = "Name";
        moduleFormObj.commenterEmail.description = "Email";
		moduleFormObj.commenterEmail.validateEmail();
        moduleFormObj.postCopy.description = "Comment Post";
    }
    
    blogCommentAddEditObj.nextFunction = function(){
    	
		if(isset(window.opener)){
			var commentAjax = ajaxObj();
			var blogID = $("blogID").value;
            var pageID = $("blogPageID").value;
            var blogInstanceID = $("blogParentInstanceID").value;
            var validate = $("validateComments").value;
			var blogName = $("blogParentTitle").value;
			var userName = $("anonymousName").value;
			var comment = $("postCopy").value;
			var commentID = $("priKeyID").value;
			var commenterEmail = $("commenterEmail").value;
			
			ajaxPost(
						commentAjax,
						"/public/blog/blogComments.php",
						"parentPriKeyID=" + blogID +
                        	"&pageID=" + pageID +
                        	"&parentInstanceID=" + blogInstanceID,
						false,
						1,
						null,
						0
					 );
			window.opener.$("blogCommentContainer-"+blogID).innerHTML = commentAjax.responseText;
			
			var requestItemParams = "function=emailReply&blogID=" + blogID + 
													   "&pageID=" + pageID + 
													   "&userName=" + userName + 
													   "&comment=" + comment + 
													   "&blogName=" + blogName +
													   "&commenterEmail=" + commenterEmail;
			ajaxPost(
						commentAjax,
						"/cmsAPI/blog/blogComment.php",
						requestItemParams,
						null,
						null,
						null,
						0
					);
					
			
			if(validate == 1){
				alert("Your comment is pending review from the site administrator.");
            }
		}
    }

    <?php
	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 2){
	?>
		blogCommentAddEditObj.setCalendar = function(){
			var declarevent_date = new Epoch("jspostDate","popup",$("postDate"));
		}
        blogCommentAddEditObj.setCalendar();
    <?php
	}
	?>
    blogCommentAddEditObj.setQforms();
}

