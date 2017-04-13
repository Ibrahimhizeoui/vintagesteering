import $ from 'jquery';
import 'magnific-popup';

let initGallery = function(el){
    $(el).magnificPopup({
        delegate: 'a',
        type: 'image',
        mainClass: 'mfp-fade',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        }
    });
};

let initBillboard = function(el){
    $(el).magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade'
    });
};

let api = {
    initGallery,
    initBillboard
};

export default api;
