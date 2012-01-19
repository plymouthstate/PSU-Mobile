<?php

use Mobile\Newsfeeds,
	Mobile\Feedback;

class Mobile {

	/**
	 * Newsfeed aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 *
	 * @param $ajax_format (boolean)	Whether the function should treat its data and response as an Ajax request and format it accordingly. 
	 */
	public static function newsfeed($ajax_format = false) {
		// Get the data from each source
		$feed_data['twitter'] = Newsfeeds::twitter();
		$feed_data['facebook'] = Newsfeeds::facebook();
		$feed_data['rss'] = Newsfeeds::rss();

		// Aggregate the feeds into one feed for JSON response
		$agg_feed_data = Newsfeeds::aggregate($feed_data);

		// If called with Ajax, make sure to respond in JSON format
		if ($ajax_format) {
			return json_encode($agg_feed_data);
		}

		return $agg_feed_data;

	} // End newsfeed

	/**
	 * Feedback Mailer
	 * Takes in JSON formatted data
	 * Validates it like a form
	 * Mails the ITS Helpdesk
	 * And then responds with JSON
	 *
	 * @param $post_data (array)		An array holding the contents of the data posted by the feedback form
	 * @param $ajax_format (boolean)	Whether the function should treat its data and response as an Ajax request and format it accordingly. 
	 */
	public static function feedback($post_data, $ajax_format = false) {
		// If called with Ajax, make sure to properly decode the JSON
		if ($ajax_format) {
			// Decode POST data
			$form_data = json_decode(stripslashes($post_data), true);
		}
		else {
			$form_data = $post_data;
		}

		// Initialize the response data
		$response_data = array();

		// If data is valid
		if(Feedback::validate_data($form_data, $response_data, $ajax_format)) {
			// Submit the feedback
			$response_data = Feedback::submit_feedback($form_data, $response_data);
		}

		// If called with Ajax, make sure to respond in JSON format
		if ($ajax_format) {
			return json_encode($response_data);
		}

		return $response_data;

	} // End feedback

} // End class Mobile
