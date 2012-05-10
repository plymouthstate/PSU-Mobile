<?php

namespace Mobile\Feeds;

use Mobile\Feeds;

class Twitter extends Feeds {
	// Settings
	private $post_limit = 8;

	/**
	 * Constructor
	 * Let's override it so we can provide the Twitter feeds with all of the data they need
	 * @param string $url 			A string containing the url of the feed source
	 * @param string $username 		A string containing the twitter username of the feed
	 */
	final public function __construct($url, $username) {
		// Call the parent's constructor to set the initial properties
		parent::__construct($url);

		// Complete the request url by combining the data parameters and appending them to the url
		$this->url .= $username;

	} // End __construct

	/*
	 * Method to set the limit of posts returned from the feed
	 * @param int $limit An integer amount of posts to return for each individual source
	 */
	public function set_post_limit($limit) {
		// Add the limit to the request url
		$this->url .= '&count=' . $limit;

		// Set the limit and return
		return $this->post_limit = $limit;
	}

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
				'text' => $tweet['text'],
			);
		}

		return $parsed_data;

	} // End parse_data

} // End class Twitter
