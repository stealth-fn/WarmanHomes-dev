CKEDITOR.dialog.add( 'stealthCMSLink', function( editor ) {
    return {
        title: 'Stealth CMS Link',
        minWidth: 400,
        minHeight: 200,

        contents: [
            {
                id: 'tab-basic',
				label: 'Link Info',
				elements: [
					{
						type: 'text',
						id: 'displayText',
						label: 'Display Text',
						required: !0,
						validate: CKEDITOR.dialog.validate.notEmpty("The Displayed Text field cannot be empty."),
						setup: function(element) {
							this.setValue(element.getText());
						},
						commit: function(element) {
							element.setText(this.getValue());
						}
					},
					{
						type : 'select',
						'default' : 'None',
						id: 'page',
						label: 'Choose Page',
						required: !0,
						validate: CKEDITOR.dialog.validate.notEmpty( "Please select a page." ),
						items :
						[
							<?php 
								include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
								$pagesObj = new pages(false);
								$allPages = $pagesObj->getConditionalRecord(
									array("priKeyID","1","greatEqual","pageName","ASC")
								);

								$i = 1;

						  while($x = mysqli_fetch_assoc($allPages)) {
							  if (1==$i) {
								  echo "['$x[pageName]','$x[priKeyID]']";
								  $i = null;
							  }
							  else 
								echo ",['$x[pageName]','$x[priKeyID]']";
						  }
						   ?>
						],
						setup: function (element) {
                           
                           	if (element.hasAttribute('onclick')) {
                           		var upcFunc = element.getAttributes()['onclick'].split(';')[0];
                           	}
                           	else {
                           		var upcFunc = element.getAttributes()['data-cke-pa-onclick'].split(';')[0];
                           	}
                            
							
							var contentInParanthesis = upcFunc.substring(upcFunc.indexOf("(")+1,upcFunc.indexOf(","));
							var pagePart = contentInParanthesis.replace(/\'/g, "");
                           
                            this.setValue(pagePart);
                           
                        },
                        commit: function(element) { 
                        
                        	var input =	this.getInputElement().$;
                        	
                        	element.$.removeAttribute('data-cke-saved-href'); 
                        	element.$.removeAttribute('data-cke-pa-onclick'); 
                       		
                       		var paramsFieldValue = 	this.getDialog().getContentElement('tab-basic','params').getValue();
                       		
                       		if (paramsFieldValue) {
                       			
                       			var hrefParam = paramsFieldValue.toString();
                       			hrefParam = hrefParam.substring(2, hrefParam.length-2);
                       			
                       			element.setAttribute( 'href', '/' + encodeURIComponent(input.options[input.selectedIndex].text) + '?' + hrefParam);
                     			
                      			element.setAttribute("data-cke-pa-onclick","atpto_tNav.toggleBlind('" + this.getValue()  + "',0,'upc(" + this.getValue() + ',' + paramsFieldValue + ")',this,event);return false");
                       		}
                       		else {
                       			element.setAttribute( 'href', '/' + encodeURIComponent(input.options[input.selectedIndex].text) );
							
                      			element.setAttribute("data-cke-pa-onclick","atpto_tNav.toggleBlind('" + this.getValue()  + "',0,'upc(" + this.getValue() + ")',this,event);return false");
                       		}
						}						
					},
					{
						type: 'text',
						id: 'params',
						label: 'Parameters',
						setup: function( element ) {
						
							if (element.hasAttribute('onclick')) {
                           		var outterFunc = ((element.getAttributes()['onclick']).split(';'))[0];
                           	}
                           	else {
                           		var outterFunc = ((element.getAttributes()['data-cke-pa-onclick']).split(';'))[0];
                           	}
							
							var innerFunc = outterFunc.substring(outterFunc.indexOf("(")+1,outterFunc.lastIndexOf(")"));
							
							var upcFunc = innerFunc.substring(innerFunc.indexOf("(")+1,innerFunc.lastIndexOf(")"));
							
							var str = upcFunc.split(',');
							
							if ( str[1] == undefined) {
								this.setValue('');
							}
							else {
								this.setValue(str[1]);
							}
							
						},
						commit: function( element ) {console.log("commit ", this.getValue());
							//element.setText( this.getValue() );
						}
					}
				]
            }
        ],
        onShow: function() {
			var selection = editor.getSelection();
			var element = selection.getStartElement();
			
			if ( element ) {
				element = element.getAscendant( 'a', true );
			}
			
			// it's new 
			if ( !element || element.getName() != 'a' ) {
				element = editor.document.createElement( 'a' );
				
				element.addClass('cmsLink');
				
				// if there is a selected text display it in the field
				this.setValueOf( 'tab-basic', 'displayText', editor.getSelection().getSelectedText().toString() );
				
				this.insertMode = true;
			}
			// it's editing mode
			else
				this.insertMode = false;
			
			this.element = element;
            if ( !this.insertMode ) {
                this.setupContent( this.element );
            }
		},
        onOk: function() {
            var dialog = this,
				stealthCMSLink = dialog.element;

			dialog.commitContent( stealthCMSLink );

			if ( dialog.insertMode ) { 
				editor.insertElement( stealthCMSLink );
       		}
        }
    };
});  