<?php

use Mobile\Newsfeeds,
	Mobile\Feedback;

class Mobile {

	/**
	 * Newsfeed aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 */
	public static function newsfeed() {
		// Get the data from each source
		$feed_data['twitter'] = Newsfeeds::twitter();
		$feed_data['facebook'] = Newsfeeds::facebook();
		$feed_data['rss'] = Newsfeeds::rss();

		// Aggregate the feeds into one feed for JSON response
		$agg_feed_data = Newsfeeds::aggregate($feed_data);

		return json_encode($agg_feed_data);
	} // End newsfeed

	/**
	 * Feedback Mailer
	 * Takes in JSON formatted data
	 * Validates it like a form
	 * Mails the ITS Helpdesk
	 * And then responds with JSON
	 */
	public static function feedback() {
		// Localize and decode POST data
		$postData = json_decode(stripslashes($_POST['postData']), true);
		$responseData = array();

		// Initialize the response data
		$responseData = array();

		// If data is valid
		if(Feedback::validate_data($postData, $responseData)) {
			// Submit the feedback
			Feedback::submit_feedback($postData, $responseData);
		}

		return json_encode($responseData);
	} // End feedback

} // End class Mobile
