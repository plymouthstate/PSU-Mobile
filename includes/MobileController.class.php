<?php

class MobileController extends PSUController {
	public static function _auth() {
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		$wp_user = wp_authenticate( $username, $password );

		if( $wp_user instanceof WP_User ) {
			return PSUPerson::get( $username );
		}//end if

		return false;
	}//end _auth

	public function getUserInfo() {
		header('Content-type: application/json');

		if( $person = self::_auth() ) {

			$roles = array();
			foreach( $person->banner_roles as $role => $desc ) {
				$roles[] = $role;
			}//end foreach

			$data = array(
				'status' => 'ok',
				'userId' => $person->id,
				'roles' => $roles,
			);
		} else {
			$data = array(
				'failure'
			);
		}//end else

		die( json_encode( $data ) );
	}//end getUserInfo

	// redefine delegate so parent knows which controller to use as default.
	// placeholder until php 5.3 "static" keyword.
	public static function delegate( $path = null, $controller_class = __CLASS__ ) {
		parent::delegate( $path, $controller_class );
	}

	/**
	 * Feedback Mailer
	 * Takes in JSON formatted data
	 * Validates it like a form
	 * Mails the ITS Helpdesk
	 * And then responds with JSON
	 */
	public function feedback() {
		// Localize and decode POST data
		$postData = json_decode(stripslashes($_POST['postData']), true);
		$responseData = array();

		// Initialize the response data
		$responseData = array();

		// If data is valid
		if(MobileAPI::validate_data($postData, $responseData)) {
			// Submit the feedback
			MobileAPI::submit_feedback($postData, $responseData);
		}

		echo json_encode($responseData);
	}

	/**
	 * Newsfeed aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 */
	public function newsfeed() {
		// Get the data from each source
		$feed_data['twitter'] = MobileFeeds::twitter();
		$feed_data['facebook'] = MobileFeeds::facebook();
		$feed_data['rss'] = MobileFeeds::rss();

		// Aggregate the feeds into one feed for JSON response
		$agg_feed_data = MobileFeeds::aggregate($feed_data);

		echo json_encode($agg_feed_data);
	}
}//end class MobileController
