import $ from 'jquery';
import 'magnific-popup';

export let initModal = function(delegator, el) {

    // Set click el to passed parent for delegation
    $(delegator).on('click', el, function(e){

        // prevent a tags doing their thing
        e.preventDefault();

        // initialize the popup and pass the open method as we want to open it.
        $(this).magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        }).magnificPopup('open');

    });

};
