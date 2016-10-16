var setOverlay = function(overlay){
    var overlayId = $(overlay).prop('id');
    var overlayValue = $(overlay).val();
    var exp = overlayId.split('-');
    var itemId = exp[exp.length-1];
    var orderId = exp[exp.length-2];
    if(overlayValue == 4){
        $('#form-initial-color-' + orderId +  '-'  + itemId ).hide();
        $('#initial-color-' + orderId +  '-'  + itemId ).prop('disabled', true);
    }else{
        $('#form-initial-color-' + orderId +  '-'  + itemId ).show();
        $('#initial-color-' + orderId +  '-'  + itemId ).prop('disabled', false);
    }
}

var setMonogram = function(monogram){
    var embroideryId = $(monogram).prop('id');
    var embroideryValue = $(monogram).val();
    var exp = embroideryId.split('-');
    var itemId = exp[exp.length-1];
    var orderId = exp[exp.length-2];
    if(embroideryValue == "Name / Initial"){
        $('#form-item-font-' + orderId +  '-'  + itemId ).show();
        $('#form-front-chest-first-line-' + orderId +  '-'  + itemId ).show();
        $('#item-font-' + orderId +  '-'  + itemId ).prop('disabled', false);
        $('#front-chest-first-line-' + orderId +  '-'  + itemId ).prop('disabled', false);
        $('#form-monogram-style-' + orderId +  '-'  + itemId ).hide();
        $('#form-monogram-' + orderId +  '-'  + itemId ).hide();
        $('#monogram-style-' + orderId +  '-'  + itemId ).prop('disabled', true);
        $('#monogram-' + orderId +  '-'  + itemId ).prop('disabled', true);
    }else{
        $('#form-item-font-' + orderId +  '-'  + itemId ).hide();
        $('#form-front-chest-first-line-' + orderId +  '-'  + itemId ).hide();
        $('#item-font-' + orderId +  '-'  + itemId ).prop('disabled', true);
        $('#front-chest-first-line-' + orderId +  '-'  + itemId ).prop('disabled', true);
        $('#form-monogram-style-' + orderId +  '-'  + itemId ).show();
        $('#form-monogram-' + orderId +  '-'  + itemId ).show();
        $('#monogram-style-' + orderId +  '-'  + itemId ).prop('disabled', false);
        $('#monogram-' + orderId +  '-'  + itemId ).prop('disabled', false);
    }
}

$( document ).ready(function() {
    $(".overlay-style").each(function() {
        setOverlay(this);
    });
    $(".embroidery-type").each(function() {
        setMonogram(this);
    });
});

$('.overlay-style').change(function() {
    setOverlay(this);
});

$('.embroidery-type').change(function() {
    setMonogram(this);
});