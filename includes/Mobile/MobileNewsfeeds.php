<?php

namespace Mobile;

class MobileFeeds {
	// Plymouth.edu Feed List
	// http://www.plymouth.edu/main/rss.html

	// Settings
	private static $sort_settings = array(
		'limit_posts_per_source' => 8,
		'limit_posts_total' => 20,
		'old_post_days' => 365,
	);
	private static $news_settings = array(
		'twitter' => array(
			'feed_url' => 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=',
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
	 * Compare timestamps for sorting
	 * @param array $a An array with a 'timestamp' key
	 * @param array $b An array with a 'timestamp' key
	 */
	public static function compare_array_timestamp($a, $b) {
		return $a['timestamp'] < $b['timestamp'];
	} // End compare_array_timestamp

	/**
	 * Method to grab JSON data from a Twitter feed and return it as an array
	 */
	public static function twitter() {
		// Setup the parameters for limiting the returned data
		$url_params = '&count='.self::$sort_settings['limit_posts_per_source'];

		// Grab and parse the Twitter Feed
		// Set the url
		$twitter_url = self::$news_settings['twitter']['feed_url'].self::$news_settings['twitter']['username'].$url_params;

		// Get the JSON data with a CURL request to the url
		$feed_data = PSU::curl($twitter_url, PSU::FILE_GET_CONTENTS);

		// Return the JSON decoded as an array
		return json_decode($feed_data, true);
	} // End twitter

	/**
	 * Method to grab JSON data from a Facebook feed and return it as an array
	 */
	public static function facebook() {
		// Setup the parameters for limiting the returned data
		$url_params = '&limit='.self::$sort_settings['limit_posts_per_source'];

		// Grab and parse the Facebook Feed
		// Set the url
		$facebook_url = self::$news_settings['facebook']['feed_url'].self::$news_settings['facebook']['username'].'/'.self::$news_settings['facebook']['request'].'?access_token='.self::$news_settings['facebook']['access_token'].$url_params;

		// Get the JSON data with a CURL request to the url
		$feed_data = PSU::curl($facebook_url, PSU::FILE_GET_CONTENTS);

		// Return the JSON decoded as an array
		return json_decode($feed_data, true);
	} // End facebook

	/**
	 * Method to grab RSS data as an array of PSU Zend Feed objects
	 */
	public static function rss() {
		// Go through each RSS feed and parse it
		$feed_data = array();
		$feedCount = 0;
		foreach (self::$news_settings['rss_feeds']['feed_urls'] as $feed) {
			try {
				// Get the feed data
				$feed_data[$feedCount] = PSU\Feed::import($feed);
			}
			catch (Zend_Feed_Exception $e) {
				//echo "Exception caught importing feed: {$e->getMessage()}\n";
				continue;
			}

			// Up the counter
			$feedCount++;
		}

		// Return the RSS feeds object
		return $feed_data;
	} // End rss

	/**
	 * Method to take in all of the feed data and aggregate it as one feed
	 * @param array $feed_data An array holding the feed data gathered by the twitter, facebook, and RSS methods
	 */
	public static function aggregate($feed_data) {
		// Create a normalized feed array (to be served later)
		$agg_feed_data = array();

		// Now, let's normalize each feed format into something that we care about/can use
		// Twitter
		foreach($feed_data['twitter'] as $tweet) {
			$agg_feed_data[] = array(
				'source' => 'Twitter',
				'title' => $tweet['user']['name'],
				'userid' => $tweet['user']['id'],
				'time' => $tweet['created_at'],
				'timestamp' => strtotime($tweet['created_at']),
				'url' => 'https://twitter.com/'.$tweet['user']['screen_name'].'/status/'.$tweet['id_str'],
				'image' => '',
				'text' => $tweet['text'],
			);
		}

		// Facebook
		foreach($feed_data['facebook']['data'] as $post) {
			if (empty($post['message']) && !empty($post['name'])) {
				$post['message'] = $post['name'];
			}

			$agg_feed_data[] = array(
				'source' => 'Facebook',
				'title' => $post['from']['name'],
				'userid' => $post['from']['id'],
				'time' => $post['created_time'],
				'timestamp' => strtotime($post['created_time']),
				'url' => $post['actions'][0]['link'],
				'image' => '',
				'text' => $post['message'],
			);
		}

		// RSS Feeds
		foreach($feed_data['rss'] as $psu_feed) {
			// Reference just the feed
			$feed = $psu_feed->feed;

			// If the feed doesn't have a title, give it a generic name
			$feed_title = $feed->title();
			if (strlen($feed_title) <= 0) {
				$feed_title = 'Plymouth State News';
			}

			// Go through each post
			$item_count = 0;
			foreach($feed as $item) {
				// If we've gone over the post limit setting, then break out of this loop
				if ($item_count > self::$sort_settings['limit_posts_per_source']) {
					// Stop adding posts from this feed
					break;
				}

				// Cut posts if they're too old
				$post_timestamp = strtotime($item->pubDate());
				if ((time() - $post_timestamp) > (self::$sort_settings['old_post_days'] * 86400)) {
					// Skip adding this one... its too old
					continue;
				}

				// Clean the posts text
				$post_text = htmlspecialchars_decode(html_entity_decode(strip_tags($item->title())));

				// Add the posts data to the normalized array
				$agg_feed_data[] = array(
					'source' => 'RSS',
					'title' => $feed_title,
					'userid' => '',
					'time' => $item->pubDate(),
					'timestamp' => $post_timestamp,
					'url' => $item->link(),
					'image' => '',
					'text' => $post_text,
				);

				$item_count++;
			}
		}

		// Debug: Test the updating by adding a dummy row
		/*
		$agg_feed_data[] = array(
			'source' => 'RSS',
			'title' => 'Donkey Kong',
			'userid' => '',
			'time' => date('Y-m-d H:i:s'),
			'timestamp' => time(),
			'url' => 'http://old.blennd.com/',
			'image' => '',
			'text' => 'Pancakes! Bork! Donkey! St**z!'
		);
		//*/

		// Sort the array so the newest items show on top
		usort($agg_feed_data, array('MobileFeeds', 'compare_array_timestamp'));
		
		// Limit the posts to a set amount
		$agg_feed_data = array_slice($agg_feed_data, 0, self::$sort_settings['limit_posts_total']);

		// Return the aggregated data
		return $agg_feed_data;
	} // End aggregate

} // End class MobileFeeds 
