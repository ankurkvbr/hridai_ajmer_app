$(document).ready(function () {

$('.error-text').hide();

  $("body").on('click', '#cmsfrm', function () {
        $(this).validate({
            errorContainer      : "#messagebox1",
            errorLabelContainer : "#messageBox",
            wrapper				: "div",
            errorClass			: "error1",
			ignore				: [],
            rules				: {
            
            'name'				: {
									required: {
										depends:function(){
											$(this).val($.trim($(this).val()));
											return true;
										}
									}
			},
			'description'		: {
									required: true,
									ckrequired: true
									}
			},
            messages			: {
            
            'name'				: {required: 'Please Enter Name'},
			'description'		: {required: 'Please Enter Description',
									ckrequired: "Please enter description"
								},
			},
			
			 errorPlacement: function (error, element) {
				
				if(element.attr("name") == "description"){
					error.insertAfter($('.cke_editor_description'));
				}
				else{
					error.insertAfter(element);
				}
           }
            
        });
		
		$.validator.addMethod("ckrequired", function (value, element) {
			
			value = value.replace(/&nbsp;/g,"");
			value = value.replace(/\r\n/g,"");
			value = value.replace(/\n/g,"");
			
			if(value == '<p></p>'){
				return false;
			}
			return true;
		}); 
    });
});



