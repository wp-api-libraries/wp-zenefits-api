<?php
/**
 * WP Zenefits API (http://help.papertrailapp.com/kb/how-it-works/http-api/)
 *
 * @package wp-zenefits-api
 */

/*
* Plugin Name: WP Zenefits API
* Plugin URI: https://github.com/wp-api-libraries/wp-zenefits-api
* Description: Perform API requests to Zenefits in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-zenefits-api
* GitHub Branch: master
* Text Domain: wp-zenefits-api
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'ZenefitsAPI' ) ) {

	/**
	 * ZenefitsAPI Class.
	 */
	class ZenefitsAPI {

		/**
		 * API Key.
		 *
		 * @var string
		 */
		static private $api_key;

		/**
		 * Base URI.
		 *
		 * (default value: 'https://api.zenefits.com/')
		 *
		 * @var string
		 * @access private
		 * @static
		 */
		static private $base_uri = 'https://api.zenefits.com/';

		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct(  $api_key ) {

			static::$api_key = $api_key;

			$this->args['headers'] = array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $api_key
			);
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_request( $request, $this->args );

			$code = wp_remote_retrieve_response_code($response );
			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'wp-zenefits-api' ), $code ) );
			}
			$body = wp_remote_retrieve_body( $response );
			return json_decode( $body );
		}

		/* Companies. */

		public function get_companies() {

		}

		public function get_company( $company_id ) {

		}

		/* People. */

		public function get_people() {

		}

		public function get_person( $person_id ) {

		}

		/* Employments. */

		public function get_employments( $person_id ) {

		}

		/* Company Bank Accounts. */

		public function get_company_bank_account( $company_id ) {

		}

		/* Employee Bank Accounts. */

		public function get_employee_bank_account( $person_id ) {

		}

		/* Departments. */

		public function get_departments( $department_id ) {
			// companies/1/departments
		}

		/* Locations. */

		public function get_locations() {

		}

		/* Me. */

		public function get_me() {
			// /core/me
		}


	}
}
