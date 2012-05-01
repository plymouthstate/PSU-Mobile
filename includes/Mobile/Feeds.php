<?php

namespace Mobile;

abstract class Feeds {
	// Properties
	protected $url;
	protected $data;
	
	// Abstract functions
	abstract protected function get_source_data();
	abstract protected function parse_data();

	// Constructor
	final public function __construct($url) {
		// Set the initial properties
		$this->url = $url;
		$this->data = array();

	} // End __construct

	final public function get_normalized_data() {
		// Let's get the source data, parse it, and return it as a normalized source
		$this->get_source_data();
		return $this->parse_data();

	} // End get_normalized_data

	/**
	 * Compare timestamps for sorting
	 * @param array $a An array with a 'timestamp' key
	 * @param array $b An array with a 'timestamp' key
	 */
	public static function compare_array_timestamp($a, $b) {
		return $a['timestamp'] < $b['timestamp'];
	} // End compare_array_timestamp

	/**
	 * Method to grab JSON data from a feed source URL and return it as an array
	 */
	public function get_json_source($url) {
		// Set up the feed_data array
		$feed_data = array();

		// PSU::curl throws an exception if the document doesn't return a perfect 200 error
		try {
			// Get the JSON data with a CURL request to the url
			$feed_data = \PSU::curl($url, \PSU::FILE_GET_CONTENTS);

			// Return the JSON decoded as an array
			return json_decode($feed_data, true);
		}
		catch (\PSUToolsException $e) {
			// For now, lets just grab the exception and put it into the session
			$_SESSION['errors'][] = $e->getMessage();
		}

		return $feed_data;
	} // End get_json_source

	/**
	 * Method to grab RSS data as an array of PSU Zend Feed objects
	 */
	public function get_rss_source($url) {
		// \PSU\Feed::import can throw many exceptions due to the Zend underpinnings. We don't need to handle them individually, so let's just catch them all
		// Possible exceptions seen so far:
		// Zend_Feed_Exception
		// Zend_Http_Client_Exception
		// Zend_Http_Client_Adapter_Exception
		try {
			// Get the feed data
			$feed_data = \PSU\Feed::import($url);
		}
		catch (\Exception $e) {
			// For now, lets just grab the exception and put it into the session
			$_SESSION['errors'][] = $e->getMessage();
		}

		return $feed_data;
	} // Ebd get_rss_source
} // End class Feeds
