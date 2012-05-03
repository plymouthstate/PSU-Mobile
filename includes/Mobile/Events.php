<?php

namespace Mobile;

class Events {
	// Settings
	private static	$limit_posts_per_source = 8;
	private static	$limit_posts_total = 20;
	private static	$old_post_days = 365;

	// Feed urls (leaving this as an array, since more event feeds are being added
	private static $feed_urls = array(
		'http://thisweek.blogs.plymouth.edu/category/upcoming-events/feed/',
	);

	/**
	 * Method to take in all of the feed data and aggregate it as one feed
	 */
	public static function aggregate() {
		// Create an array for all of the feed data aggregated together
		$agg_feed_data = array();

		// Loop through each feed
		foreach (self::$feed_urls as $url) {
			// Create a new RSS feed
			$rss = new Feeds\Rss($url);

			// Set some options
			$rss->set_post_limit(self::$limit_posts_per_source);
			$rss->set_old_limit(self::$old_post_days);

			// Get the data
			$feed_data = $rss->get_normalized_data();

			// Get the data and merge the returned array into our aggregate array
			$agg_feed_data = array_merge($agg_feed_data, $feed_data);
		}

		// Sort the array so the newest items show on top
		usort($agg_feed_data, array(__NAMESPACE__ . '\Feeds', 'compare_array_timestamp'));

		// Limit the posts to a set amount
		$agg_feed_data = array_slice($agg_feed_data, 0, self::$limit_posts_total);

		return $agg_feed_data;

	} // End aggregate

} // End class Events 
