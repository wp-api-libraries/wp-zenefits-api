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
		static private $base_uri = 'https://api.zenefits.com';

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


		/**
		 * get_companies function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_companies() {

			$request = $this->base_uri . '/core/companies';

			return $this->fetch( $request );

		}


		/**
		 * get_company function.
		 *
		 * @access public
		 * @param mixed $company_id
		 * @return void
		 */
		public function get_company( $company_id ) {

			$request = $this->base_uri . '/core/companies/' . $company_id;

			return $this->fetch( $request );

		}

		/* People. */


		/**
		 * get_people function.
		 *
		 * @access public
		 * @param mixed $company_id
		 * @return void
		 */
		public function get_people( $company_id ) {

			$request = $this->base_uri . '/core/companies/' . $company_id . '/people';

			return $this->fetch( $request );

		}

		/**
		 * get_person function.
		 *
		 * @access public
		 * @param mixed $person_id
		 * @return void
		 */
		public function get_person( $person_id ) {

				$request = $this->base_uri . '/core/people/' . $person_id;

			return $this->fetch( $request );

		}

		/* Employments. */


		/**
		 * get_employments function.
		 *
		 * @access public
		 * @param mixed $person_id
		 * @return void
		 */
		public function get_employments( $person_id ) {

			$request = $this->base_uri . '/core/people/' . $person_id . '/employments';

			return $this->fetch( $request );

		}

		/* Company Bank Accounts. */


		/**
		 * get_company_bank_account function.
		 *
		 * @access public
		 * @param mixed $company_id
		 * @return void
		 */
		public function get_company_bank_account( $company_id ) {

			$request = $this->base_uri . '/core/companies/' . $company_id . '/company_banks';

			return $this->fetch( $request );

		}

		/* Employee Bank Accounts. */


		/**
		 * get_employee_bank_account function.
		 *
		 * @access public
		 * @param mixed $person_id
		 * @return void
		 */
		public function get_employee_bank_account( $person_id ) {

			$request = $this->base_uri . '/core/people/' . $person_id . '/banks';

			return $this->fetch( $request );

		}

		/* Departments. */


		/**
		 * get_departments function.
		 *
		 * @access public
		 * @param mixed $department_id
		 * @return void
		 */
		public function get_departments( $department_id ) {

			$request = $this->base_uri . '/companies/' . $department_id . '/departments';

			return $this->fetch( $request );
		}

		/* Locations. */


		/**
		 * get_locations function.
		 *
		 * @access public
		  * @param mixed $company_id
		 * @return void
		 */
		public function get_locations( $company_id ) {

			$request = $this->base_uri . '/core/companies/' . $company_id . '/locations';

			return $this->fetch( $request );

		}

		/* Me. */


		/**
		 * Get Me.
		 *
		 * @access public
		 * @return void
		 */
		public function get_me() {

			$request = $this->base_uri . '/core/me';

			return $this->fetch( $request );
		}


	}
}
