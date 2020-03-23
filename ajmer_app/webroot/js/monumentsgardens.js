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
                        if ($("#event-image-area .monumentsgardens_images").length < 0) {
                            $("#event-image-area").append('<div class="form-group" id="field-0">\n\
                                                                <div class="form-group file required" aria-required="true">\n\
                                                                <label>Monuments Gardens Image</label><input name="monumentsgardens_images[0][image]" class="image_field_audio_cover form-control" required="required" id="monumentsgardens-images-0-image" aria-required="true" type="file"></div>\n\
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
		
		value = value.replace(/&nbsp;/g,"");
		value = value.replace(/\r\n/g,"");
		value = value.replace(/\n/g,"");
		
		if(value == '<p></p>'){
			return false;
		}
		return true;
    });  
	
	$.validator.addMethod("validateImageTypes", function (value, element) {
		
		 if(value == '') {
			return true;
		 }
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
	
	$.validator.addMethod("validateAudioTypes", function (value, element) {
		
		 if(value == '') {
			return true;
		 }
		 var extensionToCheck = "mp3|mp4|wma|wav";
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
	
    $("#monumentsgardens").validate({
            errorContainer      : "#messagebox1",
            errorLabelContainer : "#messageBox",
            wrapper				: "div",
            errorClass			: "error1",
			ignore				: [],
        rules: {
            //"monuments_category":{required: true},
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
           // "state_id": {required: true},
           // "city_id": {required: true},
            "address": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},
            "tour_title": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},
           /* "tour_video": {
				required: {
					depends:function(){
						$(this).val($.trim($(this).val()));
						return true;
					}
				}
			},*/
        },
        messages: {
          //  "monuments_category": {required: "Please select category"},
            "title": {required: "Please enter title"},
            "description": {
				required: "Please enter description",
				ckrequired: "Please enter description"
			},
          //  "state_id": {required: "Please select state"},
          //  "city_id": {required: "Please select city"},
            "address": {required: "Please enter address"},
            "tour_title": {required: "Please enter tour title"},
            //"tour_video": {required: "Please enter tour video url"},
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
 
	 var addAudioValidation = function () {
        $(".image_field").each(function () {
            $(this).rules('add', {
                // required: true,
				validateAudioTypes : true,
				messages: {
                   // required: "Please upload audio",
					validateAudioTypes : "Invalid type. Please upload mp3 wma wav audio"
                }
            });
        });
    };
    addAudioValidation();
	
    var addImageValidation = function () {
        $(".image_field_audio_cover").each(function () {
            $(this).rules('add', {
               // required: true,
				validateImageTypes : true,
				messages: {
                   // required: "Please upload image",
					validateImageTypes : "Invalid type. Please upload jpg png jpeg gif bmp images"
                }
            });
        });
    };
    addImageValidation();
    
    //var getCityByState = "<?= $this->Url->build(['controller'=> 'Event','action' =>'getCityByState']); ?>";
    if (typeof (getCityByState) != "undefined") {
        $("#state-id").change(function (e) {
            var StateId = $(this).val();
            if (StateId != '') {
                $.ajax({
                    url: getCityByState,
                    data: {'state_id': StateId},
                    method: "POST",
                    datatype: 'json',
                    success: function (data) {
                        var data = $.parseJSON(data);
                        $('#city-id').html('');
                        $('#city-id').append("<option value=''>Please select city</option>");
                        //Loop for Append the value in the Option
                        $.each(data.cities, function (cityId, cityName) {
                            $('#city-id').append("<option value='" + cityId + "'>" + cityName + "</option>");
                        });
                    }
                });
            }
        });
    }
    function findNumberAddOne(attributeString) {
        /*Finds the number in the given string
         ** and returns a string with that number increased by one
         */
        var re = new RegExp("(.*)([0-9])(.*)");
        var nPlusOne = attributeString.replace(re, "$2") + "+1";
        var newstr = attributeString.replace(re, "$1") + eval(nPlusOne) + attributeString.replace(re, "$3");
        return newstr;
    }
    

    $('#addmoreimage').click(function() {
            $('#event-image-area > .form-group:last').clone().insertAfter('#event-image-area > .form-group:last');
            //$('#event-image-area > .form-group:last label').text(findNumberAddOne($('#event-image-area > .form-group:last label').text()));
            $('#event-image-area > .form-group:last label.error').remove();
            $('#event-image-area > .form-group:last div.error-text').remove();
            $('#event-image-area > .form-group:last').attr('id',findNumberAddOne($('#event-image-area > .form-group:last').attr('id')));
            $('#event-image-area > .form-group:last > .form-group input').attr('id',findNumberAddOne($('#event-image-area > .form-group:last > .form-group input').attr('id')));
            $('#event-image-area > .form-group:last > .form-group input').val(''); /*Blank out the actual value*/
            $('#event-image-area > .form-group:last > .form-group input').attr('name',findNumberAddOne($('#event-image-area > .form-group:last > .form-group input').attr('name')));
            $('#event-image-area > .form-group:last > .form-group input').addClass('image_field');
            $('#event-image-area > .form-group:last .uploaded-area').remove();
            $('#event-image-area > .form-group:last .remove-area').show();
            $('#event-image-area > .form-group:last .removeimage').attr('data-removeid',findNumberAddOne($('#event-image-area > .form-group:last .removeimage').attr('data-removeid'))).show();
            addImageValidation();
    });
    
    $('#field-0 .remove-area').hide();

    $('#event-image-area').on('click', '.remove-area', function () {
        if($(this).parent().attr('id') != 'field-0'){
            $('#'+$(this).parent().attr('id')).remove();
        }
    });

    $('#event-image-area').on('click', '.removeimage', function () {
        $(this).parents('div').eq(1).remove();
    });
    
});
