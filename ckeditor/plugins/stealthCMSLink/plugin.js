CKEDITOR.plugins.add( 'stealthCMSLink', {
	icons: 'stealthCMSLink',
    init: function( editor ) {
        editor.addCommand( 'stealthCMSLink', 
			new CKEDITOR.dialogCommand( 'stealthCMSLink' )
		);
		
		editor.ui.addButton( 'StealthCMSLink', {
			label: 'Stealth CMS Link',
			command: 'stealthCMSLink',
			toolbar: 'insert',
		});
		
		CKEDITOR.dialog.add( 'stealthCMSLink', this.path + 'dialogs/stealthCMSLink.php' );
		
		if ( editor.contextMenu ) {
			
			editor.addMenuGroup( 'stealthCMSLinkGroup' );
			editor.addMenuItem( 'stealthCMSLinkItem', {
				label: 'Edit Stealth CMS Link',
				icon: this.path + 'icons/stealthCMSLink.png',
				command: 'stealthCMSLink',
				group: 'stealthCMSLinkGroup'
			});
			
			editor.contextMenu.addListener( function( element ) {
				if ( element.getAscendant( 'stealthCMSLink', true ) ) {
					return { stealthCMSLinkItem: CKEDITOR.TRISTATE_OFF };
				}
			});
		} // end of if
    }
});