import { check } from './utilities/helpers.js';

/**
 * Typekit
 * Imports our custom Typekit modul
 */
import { typekit } from './modules/typekit';
{
    let opts = {
        kitId: 'fqy6ckx',
        scriptTimeout: 3000,
        async: true
    };

    typekit(document, opts);
}

/**
 * Vanilla JS FitVids
 * Imports a vanilla js implementation of Dave Ruperts Fit Vids
 */
import fitvids from 'fitvids';
fitvids();

/**
 * Floating Forms
 * Small library that allows us to have inline form labels which move when focused on
 * "Floaters, lol"
 */
import floaters from './modules/floating-labels';
{
    //floatingClassName: 'custom-class', // defaults to 'floating'
    // delegateEvents: true // defaults to false
    let opts = {};

    floaters.init(opts);
}

/**
 * Video Modals
 */
import videoModal from './modules/video-modals';
{
    // modals for listings
    let gallery = document.querySelector('[data-listings-modal]');
    if (check(gallery)) {
        // initializes gallery
        videoModal.initGallery(gallery);
    }

    // videos inside billboards, there's only ever one of these
    let videoBillboard = document.querySelector('[data-billboard-video]');
    if (check(videoBillboard)) {
        videoModal.initBillboard(videoBillboard.firstChild.nextSibling);
    }
}

import { initModal } from './modules/base-modals';
{
    let magnificDelegationContainer = document.querySelector('[data-mfp-delegation]');

    let premiumModals = document.querySelectorAll('[data-premium-modal]');
    let approvalSealModals = document.querySelectorAll('[data-approval-seal-modal]');

    // In order to properly delegate the events
    let premiumModalsStrEl = '[data-premium-modal]';
    let approvalSealModalsStrEl = '[data-approval-seal-modal]';


    if (check(premiumModals[0])) {
        initModal(magnificDelegationContainer, premiumModalsStrEl);
    }

    if (check(approvalSealModals[0])) {
        initModal(magnificDelegationContainer, approvalSealModalsStrEl);
    }
}

// switchCurrency
import { setCookie, switchCurrency, updatePrices }  from './modules/currencies';
{
    // dropdown
    let dropdown = document.querySelector('[data-currency-switcher]');

    dropdown.addEventListener('click', function(e) {

        if (e.target.nodeName === 'A') {

            // prevent default browser behavioud for links in menu
            e.preventDefault();

            // set/update the cookie
            setCookie(e.target.dataset);

            // update prices on the page
            updatePrices(e.target.dataset);

            // switch the currency in the dropdown
            switchCurrency(e.target);
        }
    });
}
