import $ from 'jQuery';
import Cookies from 'js-cookie';
import currencySymbols from 'currency-symbol-map';
import accounting from 'accounting';

// change accounting.js settings
accounting.settings = {
    currency: {
        format: '%s%v', // controls output: %s = symbol, %v = value/number (can be object: see below)
        decimal : '.',  // decimal point separator
        thousand: ',',  // thousands separator
        precision : 2   // decimal places
    },
    number: {
        precision : 0,  // default precision on numbers is 0
        thousand: ',',
        decimal : '.'
    }
};

// Take the value of the data attr and replace the current session variable
export let setCookie = function(data){

    // Set the cookie UserCurrency to the newly clicked value
    return Cookies.set('userCurrency', data.currency, { expires : 28 });

};





let formatPrice = function(price, currency) {

    // Round price so we don't get odd numbers
    // let roundedPrice = accounting.toFixed(price, 1);

    // Get the symbol from the currency code passed in
    let shortSymbol = currencySymbols.getSymbolFromCurrency(currency);

    if (price <= 0) {
        return 'TBC';
    }

    // Format the price
    let newPrice = accounting.formatMoney(price, { symbol: shortSymbol });

    return newPrice;

};




// change all instances of currency on page
export let updatePrices = function(target) {

    // all fields to convert on page
    let priceFields = $('[data-price-conversion]');

    // Get the currently set currency on page
    let currentCurrency = 'GBP';

    // The target currency we want to convert to
    let targetCurrency = target.currency;

    // cache data let
    let data;

    // loop through all price fields/elements and apply conversion
    $.each(priceFields, function(index, value){

        let price = $(value).data('vehiclePrice');

        // update the data we're passing in
        data = {
            amount       : price,
            fromCurrency : currentCurrency,
            toCurrency   : targetCurrency
        };

        $.get('/wp-json/currencies/v1/conversion', data, function(res) {

            value.innerHTML = formatPrice(res, targetCurrency);

        });

    });

};





export let switchCurrency = function (target) {

    // The currency to be switched
    let currency = target.dataset.currency;

    // The current currency in place
    let currentCurrency = document.querySelector('[data-current-currency]');

    // change the clicked element
    target.dataset.currency = currentCurrency.dataset.currentCurrency;
    target.textContent = currentCurrency.dataset.currentCurrency;

    // change the data/text values of the currently in-use currency
    currentCurrency.dataset.currentCurrency = currency;
    currentCurrency.textContent = currency;
};
