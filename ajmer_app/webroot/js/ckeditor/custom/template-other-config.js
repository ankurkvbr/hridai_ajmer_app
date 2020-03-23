var ckSiteUrl = (typeof(siteurl) != "undefined") ? siteurl : window.location.protocol+"//"+window.location.hostname ;
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.siteurl = ckSiteUrl;
	config.height = '150px';
	config.format_tags = 'h1;h2;h3;h4;h5;h6;p';
	config.font_names = 'Brush Script MT;Edwardian Script ITC;Kunstler Script;Old English Text MT;Script MT;Vivaldi;' + config.font_names;
	// Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
	config.toolbar = [
			{ name: 'document', items : [ 'Maximize','-','Source'] },
			{ name: 'clipboard', items : [ 'Cut','Copy','Paste',/*'PasteText','PasteFromWord',*/'-','Undo','Redo' ] },
			{ name: 'editing', items : [ 'Find','Replace','-','SelectAll'] },
			{ name: 'insert', items : [ 'Image',/*'Flash',*/'Table','HorizontalRule','Smiley','SpecialChar','PageBreak',/*'Iframe'*/ ] },
			{ name: 'links', items : [ 'Link','Unlink'] },
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
			'/',
			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
			'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
			{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
			{ name: 'colors', items : [ 'TextColor','BGColor' ] },
			{ name: 'customTools', items: [ 'customFields' ] },
		];
	// Toolbar groups configuration.
	config.toolbarGroups = [
	];
	config.customFieldList = [
		{
			'GroupName': "Barcode Fields",
			'Fields' :[
				{'Value':'##invitee_barcode_image##','Text':'Barcode Image','Label':'Barcode Image'},
				{'Value':'##event_unique_number##','Text':'Barcode Number','Label':'Barcode Number'},
			]
		},
		{
			'GroupName': "Invitee Fields",
			'Fields' :[
				{'Value':'##inviteeName##','Text':'Invitee Name','Label':'Invitee Name'},
			]
		},
	];
	config.customFields = function(self,editor,config){
		if(config.customFieldList.length > 0){
			$.each(config.customFieldList, function(indexGroup, itemGroup) {
				if(itemGroup.GroupName != ''){
					self.startGroup(itemGroup.GroupName);
				}
				$.each(itemGroup.Fields, function(indexField, itemField) {
					//self.add('value', 'drop_text', 'drop_label');
					self.add(itemField.Value, itemField.Text, itemField.Label);
				});
			});
			self._.committed = 0; self.commit();
		}
		else{ 
			config.customFieldList = [];
			self.add("", "Fields not Found", "Fields not Found");
			self._.committed = 0; self.commit();
		}
	};
};