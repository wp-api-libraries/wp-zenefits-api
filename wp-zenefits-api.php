<?php
/**
 * WP Zenefits API
 *
 * @link https://developers.zenefits.com/v1.0/docs API Docs
 * @package WP-API-Libraries\WP-Zenefits-API
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
	 *
	 * @link https://developers.zenefits.com/v1.0/docs API Docs
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

		/* OAUTH. */

		/**
		 * get_token function.
		 *
		 * @access public
		 * @param mixed $grant_type
		 * @param mixed $refresh_token
		 * @param mixed $client_id
		 * @param mixed $client_secret
		 * @return void
		 */
		public function get_token( $grant_type, $refresh_token, $client_id, $client_secret ) {
			$request = 'https://secure.zenefits.com/oauth2/token/';
			return $this->fetch( $request );
		}

		/**
		 * get_example_sync_button_html function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_example_sync_button_html() {
			echo '<a href="https://secure.zenefits.com/oauth2/platform-authorize/?client_id={{ client_id }}%26scope=platform%20companies%20people%26response_type=code%26state={{ zenefits_state_token }}"><img alt="Sync with Zenefits" height="42" width="200" src="https://secure.zenefits.com/static/img/sync-with-zenefits-platform-button.png" srcset="https://secure.zenefits.com/static/img/sync-with-zenefits-platform-button.png 1x, https://secure.zenefits.com/static/img/sync-with-zenefits-platform-button@2x.png 2x" style="border:none;"/></a>';
		}

		/* PLATFORM. */

		/**
		 * get_applications function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_applications() {

			$request = $this->base_uri . '/platform/applications';
			return $this->fetch( $request );

		}

		/**
		 * get_company_installs function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_company_installs() {

			$request = $this->base_uri . '/platform/company_installs';
			return $this->fetch( $request );
		}

		/**
		 * set_install_custom_fields function.
		 *
		 * @access public
		 * @param mixed $install_id
		 * @return void
		 */
		public function set_install_custom_fields( $install_id ) {

			$request = $this->base_uri . '/platform/company_installs/'.$install_id.'/fields_changes/';
			return $this->fetch( $request );

		}

		/**
		 * set_install_status function.
		 *
		 * @access public
		 * @param mixed $installation_id
		 * @return void
		 */
		public function set_install_status( $installation_id ) {

			$request = $this->base_uri . '/platform/company_installs/'.$installation_id.'/status_changes/';
			return $this->fetch( $request );
		}

		/**
		 * get_person_subscriptions function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_person_subscriptions() {

			$request = $this->base_uri . '/platform/person_subscriptions';
			return $this->fetch( $request );
		}

		/**
		 * set_subscription_custom_fields function.
		 *
		 * @access public
		 * @param mixed $subscription_id
		 * @return void
		 */
		public function set_subscription_custom_fields( $subscription_id ) {

			$request = $this->base_uri . '/platform/person_subscriptions/'.$subscription_id.'/fields_changes/';
			return $this->fetch( $request );
		}

		/**
		 * set_subscription_status function.
		 *
		 * @access public
		 * @param mixed $subscription_id
		 * @return void
		 */
		public function set_subscription_status( $subscription_id ) {

			$request = $this->base_uri . '/platform/person_subscriptions/'.$subscription_id.'/status_changes/';
			return $this->fetch( $request );
		}

		/**
		 * get_flows function.
		 *
		 * @access public
		 * @param mixed $subscription_id
		 * @return void
		 */
		public function get_flows( $subscription_id ) {

			$request = $this->base_uri . '/platform/person_subscriptions/'.$subscription_id.'/flows';
			return $this->fetch( $request );

		}

		/**
		 * set_flow_custom_fields function.
		 *
		 * @access public
		 * @param mixed $subscription_id
		 * @return void
		 */
		public function set_flow_custom_fields( $subscription_id ) {

			$request = $this->base_uri . '/platform/flows/'.$subscription_id.'/fields_changes/';
			return $this->fetch( $request );

		}


		/**
		 * trigger_new_flow function.
		 *
		 * @access public
		 * @return void
		 */
		public function trigger_new_flow() {

			$request = $this->base_uri . '/platform/flows/';
			return $this->fetch( $request );
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
		public function get_departments( $company_id ) {

			$request = $this->base_uri . '/companies/' . $company_id . '/departments';

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
