/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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