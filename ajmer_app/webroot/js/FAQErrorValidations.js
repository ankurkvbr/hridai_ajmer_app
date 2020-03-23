$(document).ready(function () {

	$("body").on('click', '#FaqBtn', function () {
        $(this).validate({
			errorContainer 		: "#messagebox1",
            errorLabelContainer	: "#messageBox",
            wrapper				: "div",
            errorClass			: "error1",
			ignore				: [],
            
            rules				: {
			'faq_title'			:{required: true},
			'faq_description'	:{required: true},
			},
            messages			:{
			'faq_title'			:{required: 'Please Enter Question'},
			'faq_description'	:{required: 'Please Enter Answer'},
            
			},
			errorPlacement		: 
				function (error, element) {
					if(element.attr("name") == "faq_description"){
					error.insertAfter($('.cke_editor_faq-description'));
					}else{
					error.insertAfter(element);
				}       	
			}
		});		
	});
});