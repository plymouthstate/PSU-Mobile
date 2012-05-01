<?php

namespace Mobile\Feeds;

use Mobile\Feeds;

class Facebook extends Feeds {
	/**
	 * Method to grab the Facebook feed data and return it as an array
	 */
	protected function get_source_data() {
		// The Facebook feeds are a JSON source
		$this->data = $this->get_json_source($this->url);
	} // End get_source_data

	/**
	 * Method to parse the source's data into a standard format
	 */
	protected function parse_data() {
		// Create a normalized feed array (to be served later)
		$parsed_data = array();

		// Let's loop through each post
		foreach($this->data['data'] as $post) {
			// Set reusable timestamp variable
			$timestamp = strtotime($post['created_time']);

			// If the message data is empty, but the name/title isn't, just set the message to have the value of the name
			if (empty($post['message']) && !empty($post['name'])) {
				$post['message'] = $post['name'];
			}

			$parsed_data[] = array(
				'source' => 'Facebook',
				'title' => $post['from']['name'],
				'userid' => $post['from']['id'],
				'rawtime' => $post['created_time'],
				'timestamp' => $timestamp,
				'datetime' => \PSU::html5_datetime($timestamp),
				'time_ago' => \PSU::date_diff($timestamp, time(), 'simple'),
				'url' => $post['actions'][0]['link'],
				'image' => '',
				'text' => $post['message'],
			);
		}

		return $parsed_data;
	} // End parse_data
} // End class Facebook
