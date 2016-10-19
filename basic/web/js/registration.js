var setStates = function(){
    var selectedCountryId = $("#registrationform-country").val();
    if(selectedCountryId == 1){
        var hideCountryId = 2;
    }else{
        var hideCountryId = 1;
    }
    $('#' + hideCountryId).attr("disabled", true);
    $('#' + hideCountryId).attr("required", false);
    $('.field-' + hideCountryId).hide();
    $('#' + selectedCountryId).attr("disabled", false);
    $('#' + selectedCountryId).attr("required", true);
    $('.field-' + selectedCountryId).show();
}

$( document ).ready(function() {
    setStates();
    $("#registrationform-country").change(function() {
        setStates();
    });
});