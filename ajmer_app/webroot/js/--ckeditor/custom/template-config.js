var ckSiteUrl = (typeof(siteurl) != "undefined") ? siteurl : window.location.protocol+"//"+window.location.hostname ;
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.siteurl = ckSiteUrl;
	config.height = '300px';
	config.format_tags = 'h1;h2;h3;h4;h5;h6;p';
	// Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
	config.toolbar = [
			{ name: 'tools', items: [ 'Maximize','-','Preview','Sourch' ] },
			{ name: 'templateTools',items:['Bold', 'Italic', 'Underline', 'Strike','-','NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','-','Table']},			
			{ name: 'links', items: [ 'Link', 'Unlink' ] },			
			{ name: 'styles', items: [ 'Format','FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		];
	// Toolbar groups configuration.
	config.toolbarGroups = [
			{ name: 'tools' },				
			{ name: 'templateTools' },
			{ name: 'links' },
			{ name: 'styles' },
			{ name: 'colors' },			
		];
};
