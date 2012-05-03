<?php

namespace Mobile\Feeds;

use Mobile\Feeds;

class Facebook extends Feeds {
	// Settings
	private $post_limit = 8;

	/**
	 * Constructor
	 * Let's override it so we can provide the Facebook feeds with all of the data they need
	 * @param string $url 			A string containing the url of the feed source
	 * @param string $username 		A string containing the facebook username of the feed
	 * @param string $request 		A string describing the type of data being requested
	 * @param string $access_token 	A string containing the required api access token
	 */
	final public function __construct($url, $username, $request, $access_token) {
		// Call the parent's constructor to set the initial properties
		parent::__construct($url);

		// Complete the request url by combining the data parameters and appending them to the url
		$this->url .= $username . '/' . $request . '?access_token=' . $access_token;

	} // End __construct

	/*
	 * Method to set the limit of posts returned from the feed
	 * @param int $limit An integer amount of posts to return for each individual source
	 */
	public function set_post_limit($limit) {
		// Add the limit to the request url
		$this->url .= '&limit=' . $limit;

		// Set the limit and return
		return $this->post_limit = $limit;
	}

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
