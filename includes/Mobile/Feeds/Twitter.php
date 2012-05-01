<?php

namespace Mobile\Feeds;

use Mobile\Feeds;

class Twitter extends Feeds {
	/**
	 * Method to grab the Twitter feed data and return it as an array
	 */
	protected function get_source_data() {
		// The Twitter feeds are a JSON source
		$this->data = $this->get_json_source($this->url);
	} // End get_source_data

	/**
	 * Method to parse the source's data into a standard format
	 */
	protected function parse_data() {
		// Create a normalized feed array (to be served later)
		$parsed_data = array();

		// Let's loop through each "tweet"
		foreach($this->data as $tweet) {
			// Set reusable timestamp variable
			$timestamp = strtotime($tweet['created_at']);

			$parsed_data[] = array(
				'source' => 'Twitter',
				'title' => $tweet['user']['name'],
				'userid' => $tweet['user']['id'],
				'rawtime' => $tweet['created_at'],
				'timestamp' => $timestamp,
				'datetime' => \PSU::html5_datetime($timestamp),
				'time_ago' => \PSU::date_diff($timestamp, time(), 'simple'),
				'url' => 'https://twitter.com/'.$tweet['user']['screen_name'].'/status/'.$tweet['id_str'],
				'image' => '',
				'text' => $tweet['text'],
			);
		}

		return $parsed_data;
	} // End parse_data
} // End class Twitter
