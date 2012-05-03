<?php

namespace Mobile;

class Newsfeeds {
	// Settings
	private static	$limit_posts_per_source = 8;
	private static	$limit_posts_total = 20;
	private static	$old_post_days = 365;

	// Feed sources
	private static $news_sources = array(
		'twitter' => array(
			'feed_url' => 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=',
			'username' => 'plymouthstate',
		),
		'facebook' => array(
			'feed_url' => 'https://graph.facebook.com/',
			'username' => 'plymouthstate',
			'request' => 'posts',
			'access_token' => '172080957061|378dd241939ba50ed21ffcf3.0-600269293|gDzn_Na8xFpzdnb8WNmspws9k-g',
		),
		'rss_feeds' => array(
			'feed_urls' => array(
				'http://www.plymouth.edu/includes/rss.php?v=2x&s=hn',
				'http://athletics.plymouth.edu/landing/headlines-featured?feed=rss_2.0',
			),
		),
	);

	/**
	 * Private method to get the twitter feed
	 */
	private static function get_twitter_feed() {
		// Create a new Twitter feed
		$twitter = new Feeds\Twitter(
			self::$news_sources['twitter']['feed_url'], 
			self::$news_sources['twitter']['username'] 
		);

		// Set some options
		$twitter->set_post_limit(self::$limit_posts_per_source);

		// Get and return the data
		return $twitter->get_normalized_data();
	}

	/**
	 * Private method to get the facebook feed
	 */
	private static function get_facebook_feed() {
		// Create a new Facebook feed
		$facebook = new Feeds\Facebook(
			self::$news_sources['facebook']['feed_url'], 
			self::$news_sources['facebook']['username'], 
			self::$news_sources['facebook']['request'], 
			self::$news_sources['facebook']['access_token']
		);

		// Set some options
		$facebook->set_post_limit(self::$limit_posts_per_source);

		// Get and return the data
		return $facebook->get_normalized_data();
	}

	/**
	 * Private method to get the rss feed
	 * @param string $url A string containg the url of the rss feed being requested
	 */
	private static function get_rss_feed($url) {
		// Create a new RSS feed
		$rss = new Feeds\Rss($url);

		// Set some options
		$rss->set_post_limit(self::$limit_posts_per_source);
		$rss->set_old_limit(self::$old_post_days);

		// Get the data
		return $rss->get_normalized_data();
	}

	/**
	 * Method to take in all of the feed data and aggregate it as one feed
	 */
	public static function aggregate() {
		// Create an array for all of the feed data aggregated together
		$agg_feed_data = array();

		// Get the twitter feed and merge the returned array into our aggregate array
		$agg_feed_data = array_merge($agg_feed_data, self::get_twitter_feed());

		// Get the facebook feed and merge the returned array into our aggregate array
		$agg_feed_data = array_merge($agg_feed_data, self::get_facebook_feed());

		// Loop through each feed
		foreach (self::$news_sources['rss_feeds']['feed_urls'] as $url) {
			// Get the data and merge the returned array into our aggregate array
			$agg_feed_data = array_merge($agg_feed_data, self::get_rss_feed($url));
		}

		// Sort the array so the newest items show on top
		usort($agg_feed_data, array(__NAMESPACE__ . '\Feeds', 'compare_array_timestamp'));

		// Limit the posts to a set amount
		$agg_feed_data = array_slice($agg_feed_data, 0, self::$limit_posts_total);

		return $agg_feed_data;

	} // End aggregate

} // End class Newsfeeds 
