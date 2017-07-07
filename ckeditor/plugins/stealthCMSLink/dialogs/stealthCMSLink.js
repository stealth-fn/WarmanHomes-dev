CKEDITOR.dialog.add( 'stealthCMSLink', function( editor ) {
    return {
        title: 'Stealth CMS Link',
        minWidth: 400,
        minHeight: 200,
		
		onShow : function()
		{
			this.setValueOf( 'tab-basic', 'displayText', editor.getSelection().getSelectedText().toString() );
		},

        contents: [
            {
                id: 'tab-basic',
				label: 'Link Info',
				elements: [
					{
						type: 'text',
						id: 'displayText',
						label: 'Display Text'
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
							[ 'MP4', 'video/mp4' ],
							[ 'WebM', 'video/webm' ]
						]
					},
					{
						type: 'text',
						id: 'title',
						label: 'Parameters',
						validate: CKEDITOR.dialog.validate.notEmpty( "Parameters field cannot be empty." )
					}
				]
            }
        ]
    };
});