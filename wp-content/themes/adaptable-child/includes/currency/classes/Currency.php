<?php namespace LukeRoberts;

use Exception;

use NumberFormatter;

/**
 * Handles Interaction with wp_currencies for site needs
 */
class Currency
{

    private $defaultCurrency;


    /**
     * [__construct description]
     */
    function __construct() {}





    /**
     * Filter out the current currency in use as we don't want to display that twice.
     * @param  [array] $currencies [list of all the currencies available]
     * @return [array]             [modified array of currency strings]
     */
    private function filterCurrentCurrency($currencies)
    {
        $current = $this->getCurrentCurrency();

        return array_filter($currencies, function($val) use ($current) {
            return $val != $current;
        });
    }





    /**
     * Localize currency data into script
     */
    public function localizeCurrency()
    {
        wp_register_script('currencySessionJs', get_stylesheet_directory_uri() . '/js/js-currencies.js', array('bundle'), false, true);

        wp_localize_script('currencySessionJs', 'adp_currency_scripts', array(
            'sessionFile' => get_template_directory_uri() . 'includes/currency/CreateSession.php'
        ));

        wp_enqueue_script('currencySessionJs');
    }





    /**
     * Return simple array of currencies enabled in the admin panel
     * @return [array] (An array of available currencis)
     */
    public function availableCurrency($optionName = 'c_currency')
    {
        if (!get_field($optionName, 'option')) {
            throw new Exception("There are no available currencies, please select currencies in the admin panel");
        };

        return get_field($optionName, 'option');
    }





    /**
     * Get the default currency set
     * @return [type] [description]
     */
    public function defaultCurrency()
    {
        // Get the currency set in the WP options panel
        $default = $GLOBALS['imic_options']['paypal_currency'];

        // If it's empty throw an exception
        if (empty($default)) {
            throw new Exception('Please specify a default currency in the paypal options panel');
        }

        // Otherwise return out
        return $default;
    }





    /**
     * Returns the default currency
     * @return [string] [default currency]
     */
    public function getDefaultCurrency()
    {
        try {

            $this->defaultCurrency();

        } catch (Exception $e) {

            _log("Caught Exception: " . $e->getMessage() . "\n");
            _log("Stack Trace: " . $e->getTraceAsString() . "\n");

            // Default Currency is always GBP
            return 'GBP';
        }

        // Return default currency from admin
        return $this->defaultCurrency();
    }





    /**
     * Extract array keys from the currencies array
     * @return [array] [currency keys as values]
     */
    public function currencyAbbreviations()
    {
        try {

            $this->availableCurrency();

        } catch (Exception $e) {

            _log("Caught Exception: " . $e->getMessage() . "\n");
            _log("Stack Trace: " . $e->getTraceAsString() . "\n");

            return;
        }

        // Return the abbreviations, filtering out the currently in use currency
        return $this->filterCurrentCurrency( array_keys($this->availableCurrency()) );

    }





    /**
     * Get the currently in use currency
     * @return [string] [contains the currency currency in use]
     */
    public function getCurrentCurrency()
    {
        // If User defined cookie exists then use their preference
        if (isset($_COOKIE['userCurrency'])) {
            return $_COOKIE['userCurrency'];
        }

        // else, use the default currency
        return $this->getDefaultCurrency();
    }



    /**
     * Get the currency symbol for a given currency code/locale
     * @param  string $currencyCode Currency code you want to get the symbol for
     * @param  string $locale       Locale you want to target as well, default is en_US
     * @return HTML Entity          Currency Symbol
     */
    public function getCurrencySymbol($currencyCode, $locale = 'en_US')
    {
        $formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);

        return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }
}
