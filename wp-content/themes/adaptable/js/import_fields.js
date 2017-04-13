function remove_field(obj) {
    var parent = jQuery(obj).parent();
    parent.remove();
}

function add_field_row() {

    var row = jQuery('#master-row').html();
    jQuery('#field_wrap').append(row);
}
