<?php

use Mobile\Newsfeeds,
	Mobile\Feedback,
	Mobile\Events;

class Mobile {

	/**
	 * Newsfeed aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 *
	 * @param $ajax_format (boolean)	Whether the function should treat its data and response as an Ajax request and format it accordingly. 
	 */
	public static function newsfeed($ajax_format = false) {
		// Get the data
		$feed_data = Newsfeeds::aggregate();

		// If called with Ajax, make sure to respond in JSON format
		if ($ajax_format) {
			return json_encode($feed_data);
		}

		return $feed_data;

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
		if(Feedback::validate($form_data, $response_data, $ajax_format)) {
			// Submit the feedback
			$response_data = Feedback::submit($form_data, $response_data);
		}

		// If called with Ajax, make sure to respond in JSON format
		if ($ajax_format) {
			return json_encode($response_data);
		}

		return $response_data;

	} // End feedback

	/**
	 * Event News aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 *
	 * @param $ajax_format (boolean)	Whether the function should treat its data and response as an Ajax request and format it accordingly. 
	 */
	public static function events($ajax_format = false) {
		// Get the data
		$feed_data = Events::aggregate();

		// Let's remove any weird HTML from the blog posts content
		$feed_data = Events::clean_post_content($feed_data);

		// Let's parse the dates from the feed
		$feed_data = Events::parse_event_dates($feed_data);

		// If called with Ajax, make sure to respond in JSON format
		if ($ajax_format) {
			return json_encode($feed_data);
		}

		return $feed_data;

	} // End events

} // End class Mobile
