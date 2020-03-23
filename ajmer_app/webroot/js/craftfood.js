$(document).ready(function () {

    $('.deleteimage').click(function () {
//        alert($(this).parent().parent().remove());
        var img = $(this).attr('id');
        if (img != '') {
            $.ajax({
                url: deleteimage,
                data: {'img_id': img},
                method: "POST",
                datatype: 'json',
                success: function (data) {
                    var json = $.parseJSON(data);
                    if (json.status == "success") {

                        //window.location.reload(true);
                        $("#parent_" + img).remove();
                        if ($("#event-image-area .craftfoods_images").length < 0) {
                            $("#event-image-area").append('<div class="form-group" id="field-0">\n\
                                                                <div class="form-group file required" aria-required="true">\n\
                                                                <label>Crafts & Foods Image</label><input name="craftfoods_images[0][image]" class="image_field form-control" required="required" id="craftfoods-images-0-image" aria-required="true" type="file"></div>\n\
                                                                <div class="form-group remove-area" style="display:none;">\n\
                                                                <button type="button" class="btn btn-warning removeimage btn-success" data-removeid="0">Remove</button></div></div>');
                        }
                    }
                }
            });
        }
    });
	
	for (instance in CKEDITOR.instances) {

		CKEDITOR.instances[instance].on("instanceReady", function () {

			//set keyup event
			this.document.on("keyup", function () { CKEDITOR.instances[instance].updateElement(); });
			//and paste event
			this.document.on("paste", function () { CKEDITOR.instances[instance].updateElement(); });

		});
	}	
	
	$.validator.addMethod("ckrequired", function (value, element) {
		/*var re = new RegExp("/&nbsp;/$");*/
		value = value.replace(/&nbsp;/g,"");
		value = value.replace(/\r\n/g,"");
		value = value.replace(/\n/g,"");
		
		if(value == '<p></p>'){
			return false;
		}
		return true;
    });  
	
	$.validator.addMethod("validateImageTypes", function (value, element) {
		var extensionToCheck = "jpg|png|jpeg|gif|bmp";
		 var fileName = value;
		 var arrayValues = fileName.split('.');
		 var stringCount = arrayValues.length;
		 var ext = arrayValues[stringCount-1];
		 var extensionSplit = extensionToCheck.split('|');
		 
		 if($.inArray(ext, extensionSplit) !== -1){
			 return true;
		 }
		return false;
    });
	
	$('#craftfood').validate({
        errorContainer: "#messagebox1",
        errorLabelContainer: "#messageBox",
        wrapper: "div",
        errorClass: "error1",
        ignore: [],
        rules: {
           // "craftfood_category": {required: true},
            "title": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},
            "description": {
				required: true,
				ckrequired: true
			},
            "short_description": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},
            "address": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},
        },
        messages: {
           // "craftfood_category": {required: "Please select category"},
            "title": {required: "Please enter title"},
            "description": {required: "Please enter description",
				ckrequired: "Please enter description"
			},
            "short_description": {required: "Please enter short description"},
            "address": {required: "Please enter address"},
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
	
    var addImageValidation = function () {
        $(".image_field").each(function () {
            $(this).rules('add', {
                required: true,
				validateImageTypes : true,
				messages: {
                    required: "Please upload image",
					validateImageTypes : "Invalid type. Please upload jpg png jpeg gif bmp images"
                }
            });
        });
    };
    addImageValidation();

    function findNumberAddOne(attributeString) {
        /*Finds the number in the given string
         ** and returns a string with that number increased by one
         */
        var re = new RegExp("(.*)([0-9])(.*)");
        var nPlusOne = attributeString.replace(re, "$2") + "+1";
        var newstr = attributeString.replace(re, "$1") + eval(nPlusOne) + attributeString.replace(re, "$3");
        return newstr;
    }


    $('#addmoreimage').click(function () {
        $('#event-image-area > .form-group:last').clone().insertAfter('#event-image-area > .form-group:last');
        //$('#event-image-area > .form-group:last label').text(findNumberAddOne($('#event-image-area > .form-group:last label').text()));
        $('#event-image-area > .form-group:last label.error').remove();
        $('#event-image-area > .form-group:last div.error-text').remove();
        $('#event-image-area > .form-group:last').attr('id', findNumberAddOne($('#event-image-area > .form-group:last').attr('id')));
        $('#event-image-area > .form-group:last > .form-group input').attr('id', findNumberAddOne($('#event-image-area > .form-group:last > .form-group input').attr('id')));
        $('#event-image-area > .form-group:last > .form-group input').val(''); /*Blank out the actual value*/
        $('#event-image-area > .form-group:last > .form-group input').attr('name', findNumberAddOne($('#event-image-area > .form-group:last > .form-group input').attr('name')));
        $('#event-image-area > .form-group:last > .form-group input').addClass('image_field');
        $('#event-image-area > .form-group:last .uploaded-area').remove();
        $('#event-image-area > .form-group:last .remove-area').show();
        $('#event-image-area > .form-group:last .removeimage').attr('data-removeid', findNumberAddOne($('#event-image-area > .form-group:last .removeimage').attr('data-removeid'))).show();
        addImageValidation();
    });

    $('#field-0 .remove-area').hide();

    $('#event-image-area').on('click', '.remove-area', function () {
        if ($(this).parent().attr('id') != 'field-0') {
            $('#' + $(this).parent().attr('id')).remove();
        }
    });

    $('#event-image-area').on('click', '.removeimage', function () {
        $(this).parents('div').eq(1).remove();
    });

});
