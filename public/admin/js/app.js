$(document).ready(function () {


    /**
     * Set file uploaded in [img-el]
     */
    $(".upload").change(function() {
        previewImg(this, validate(this));
    });

});



/**
 * Preview img before upload it
 *
 * @param input
 * @param img
 */
function previewImg(input,img) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $(img).attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Validate Preview Image Selector
 *
 * @param selector
 * @returns {null|*|undefined|jQuery}
 */
function validate(selector) {
    return  $(selector).parent().prev().attr('id')
               ? '#' + $(selector).parent().prev().attr('id')
               : $(selector).parent().prev().attr('class')
                  ? '.' + $(selector).parent().prev().attr('class')
                  : '.preview-img';
}
