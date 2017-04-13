<?php
/**
 * WP Currencies API
 *
 * Support for WordPress JSON REST API.
 *
 * @package WP_Currencies\API
 */

namespace WP_Currencies;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WP Currencies API class.
 *
 * Extends WP API with currencies routes.
 *
 * @since 1.4.0
 */
class API {

	/**
	 * Instance of this class.
	 *
	 * @since 1.4.0
	 * @access protected
	 * @var API
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.4.0
	 *
	 * @return API A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Register JSON API routes.
	 * Provides two endpoints for the API `/currencies/` and `/currencies/rates/`.
	 *
	 * @since 1.4.0
	 *
	 * @param  array $routes The REST API routes to filter.
	 * @return array Returns the filtered routes for the REST API.
	 */
	public function register_routes( $routes ) {

        /**
         * Get a list of available currencies
         */
        register_rest_route( 'currencies/v1', '/currencies', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_currencies')
        ));

        /**
         * Get a list of rates for available currencies
         */
        register_rest_route( 'currencies/v1', '/rates', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_rates')
        ));

        /**
         * Allow conversion of currencies amount/from/to
         */
        register_rest_route( 'currencies/v1', '/conversion', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'convert_currency'),
            'args' => array(
                'amount' => array(
                    'validate_callback' => function($param, $request, $key){
                        return is_numeric($param);
                    }
                ),
                'fromCurrency' => array(
                    'validate_callback' => function($param, $request, $key){
                        return currency_exists($param);
                    }
                ),
                'toCurrency' => array(
                    'validate_callback' => function($param, $request, $key){
                        return currency_exists($param);
                    }
                )
            )
        ));
	}

	/**
	 * Get currency data API callback function.
	 *
	 * @since 1.4.0
	 *
	 * @return array Currencies data
	 */
	public function get_currencies( ) {
		return get_currencies();
	}

	/**
	 * Get currency rates API callback function
	 *
	 * @since 1.4.0
	 *
	 * @param  string $currency	(optional) Base currency, default US Dollars.
	 * @return array  Currency rates.
	 */
	public function get_rates( $currency = 'USD' ) {

		return get_exchange_rate( $currency );
	}

    /**
     * Convert Currency API Callback function
     *
     * @since 1.4.0
     *
     * @param int    $amount        (required) The currency
     * @param string $fromCurrency	(required) The currency to convert from, default is USD
     * @param string $toCurrency	(required) The currency to convert to
     * @return array  Currency rates.
     */
    public function convert_currency( \WP_REST_Request $request ) {

        // Request params
        $amount = $request->get_param('amount');
        $fromCurrency = $request->get_param('fromCurrency');
        $toCurrency = $request->get_param('toCurrency');

        // Get and convert currency based on our parameters
        return convert_currency($amount, $fromCurrency, $toCurrency);
    }
}
