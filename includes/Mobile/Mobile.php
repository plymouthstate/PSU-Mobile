<?php

namespace Mobile;

class Mobile {

	/**
	 * Newsfeed aggregator.
	 * Grabs different feeds, combines them, and converts them to JSON
	 * format for easy AJAX parsing
	 */
	public function newsfeed() {
		// Get the data from each source
		$feed_data['twitter'] = MobileNewsfeeds::twitter();
		$feed_data['facebook'] = MobileNewsfeeds::facebook();
		$feed_data['rss'] = MobileNewsfeeds::rss();

		// Aggregate the feeds into one feed for JSON response
		$agg_feed_data = MobileNewsfeeds::aggregate($feed_data);

		echo json_encode($agg_feed_data);
	} // End newsfeed

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
		if(MobileFeedback::validate_data($postData, $responseData)) {
			// Submit the feedback
			MobileFeedback::submit_feedback($postData, $responseData);
		}

		echo json_encode($responseData);
	} // End feedback

} // End class Mobile
