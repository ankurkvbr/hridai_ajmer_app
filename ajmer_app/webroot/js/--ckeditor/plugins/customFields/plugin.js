CKEDITOR.plugins.add( 'customFields',{   
	requires : ['richcombo'],
	init : function( editor ){
		var config = editor.config,
		lang = editor.lang.format;
		var isHandlingData;
		
		var customFields = config.customFields;

		if (!customFields || typeof (customFields) != 'function')
                	throw "You must provide a function to retrieve the list data.";
		
		var builListRunOnce = 0;
		var buildList = function () {
			if (builListRunOnce) {
				// Remove the old unordered list from the dom.
				// This is just to cleanup the old list within the iframe
				// Note that this removes all uls... if there are more than one editor on page, we have to be more specific on what to remove. In my production ready code, I target one of the lis, and find its ul parent and remove that instead of shotgunning all uls like in this example
				$(this._.panel._.iframe.$).contents().find("h1").remove();				
				$(this._.panel._.iframe.$).contents().find("ul").remove();
				// reset list
				this._.items = {};
				this._.list._.items = {};
			}
			//Check defined object
			if(typeof (this._.list) == 'undefined'){return false;}
			
			//Gets the list of tags from the settings.
			var self = this;
			customFields(self,editor,config);
			
			builListRunOnce = 1;
		};
		
		// Create style objects for all defined styles.
		editor.ui.addRichCombo( 'customFields',{
		    label : "Insert Fields",
		    title :"Insert Fields",
		    voiceLabel : "Insert Fields",
		    className : 'cke_format_customfields customfields_menu',
		    multiSelect : true,
		    panel :{
				css : [ config.contentsCss, CKEDITOR.getUrl( CKEDITOR.skin.getPath('editor') ) ],
				voiceLabel : lang.panelVoiceLabel,
		    },
		    init: function () {
				var rebuildList = CKEDITOR.tools.bind(buildList, this); // bind the buildList function with this scope
		        rebuildList(); // call once to do first build of list
		        $(editor).bind('rebuildList', rebuildList); // bind with jquery so we can call it later
		    },
		    onClick : function( value ){
				editor.focus();
				editor.fire( 'saveSnapshot' );
				editor.insertHtml(value);
				editor.fire( 'saveSnapshot' );
				/*if (editor.config.customAddAfter || typeof (editor.config.customAddAfter) == 'function')
					editor.config.customAddAfter(editor);*/
		    },
		    onRender: function() {
			    /*editor.on( 'selectionChange', function( ev ) {
						var rebuildList = CKEDITOR.tools.bind(buildList, this); // bind the buildList function with this scope
						rebuildList(); // call once to do first build of list				
						$(editor).bind('rebuildList', rebuildList);
		        }, this );*/
		    }
		});		
		//Editor instanceReady
		editor.on( 'instanceReady', function(e){
			//customFilterFields(editor,editor.config);
		});
	}
});
