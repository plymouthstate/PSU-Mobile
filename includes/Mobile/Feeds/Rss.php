<?php

namespace Mobile\Feeds;

use Mobile\Feeds;

class Rss extends Feeds {
	// Settings
	private $post_limit = 8;
	private $old_post_days = 365;

	/*
	 * Method to set the limit of posts returned from the feed
	 * @param int $limit An integer amount of posts to return for each individual source
	 */
	public function set_post_limit($limit) {
		return $this->post_limit = $limit;
	}

	/*
	 * Method to set the cutoff date for old posts (any posts older than this amount of days will be removed from the returned data)
	 * @param int $limit An integer amount of days
	 */
	public function set_old_limit($limit) {
		return $this->old_post_days = $limit;
	}

	/**
	 * Method to grab the Rss feed data and return it as an array
	 */
	protected function get_source_data() {
		// The Rss feeds are a JSON source
		$this->data = $this->get_rss_source($this->url);
	} // End get_source_data

	/**
	 * Method to parse the source's data into a standard format
	 */
	protected function parse_data() {
		// Create a normalized feed array (to be served later)
		$parsed_data = array();

		// Reference just the feed
		$feed = $this->data->feed;

		// If the feed doesn't have a title, give it a generic name
		$feed_title = $feed->title();
		if (strlen($feed_title) <= 0) {
			$feed_title = 'Plymouth State News';
		}

		// Let's loop through each article
		$item_count = 0;
		foreach($feed as $item) {
			// If we've gone over the post limit setting, then break out of this loop
			if ($item_count > $this->post_limit) {
				// Stop adding posts from this feed
				break;
			}

			// Cut posts if they're too old
			$post_timestamp = strtotime($item->pubDate());
			if ((time() - $post_timestamp) > ($this->old_post_days * 86400)) {
				// Skip adding this one... its too old
				continue;
			}

			// Quick function to clean the posts text
			$clean_the_post = function($post) {
				// Run some cleaners on the string
				$post = htmlspecialchars_decode($post);
				$post = html_entity_decode($post);
				$post = strip_tags($post);
				$post = \PSU::html_all_entities($post);
				$post = str_replace('&#12287;', '\'', $post);

				return $post;
			};
			$post_text = $clean_the_post($item->title());

			// Add the posts data to the normalized array
			$parsed_data[] = array(
				'source' => 'RSS',
				'title' => $feed_title,
				'userid' => '',
				'rawtime' => $item->pubDate(),
				'timestamp' => $post_timestamp,
				'datetime' => \PSU::html5_datetime($post_timestamp),
				'time_ago' => \PSU::date_diff($post_timestamp, time(), 'simple'),
				'url' => $item->link(),
				'image' => '',
				'text' => $post_text,
			);

			$item_count++;
		}

		return $parsed_data;

	} // End parse_data
} // End class Rss
