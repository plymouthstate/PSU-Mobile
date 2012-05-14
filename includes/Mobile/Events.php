<?php

namespace Mobile;

class Events {
	// Settings
	private static	$limit_posts_per_source = 20;
	private static	$limit_posts_total = 20;
	private static	$old_post_days = 365;

	// Feed urls (leaving this as an array, since more event feeds are being added
	private static $feed_urls = array(
		'http://thisweek.blogs.plymouth.edu/category/upcoming-events/feed/rss2',
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
			$rss = new Feed\Rss($url);

			// Set some options
			$rss->set_post_limit(self::$limit_posts_per_source);
			$rss->set_old_limit(self::$old_post_days);

			// Get the data
			$feed_data = $rss->get_normalized_data();

			// Get the data and merge the returned array into our aggregate array
			$agg_feed_data = array_merge($agg_feed_data, $feed_data);
		}

		// Limit the posts to a set amount
		$agg_feed_data = array_slice($agg_feed_data, 0, self::$limit_posts_total);

		return $agg_feed_data;

	} // End aggregate

	/**
	 * Private method to remove the date iconlet's from the posts content that are added by the WordPress event-plugin
	 */
	private static function remove_date_iconlet(&$feed_data) {
		// Our icon removal regular expression
		$remove_iconlet = "/(<div class=(?:'|\")?ec3_iconlet(?:.*?)(?:'|\")?>(?:.*?)<\/div>)/";

		// Loop through each feed
		foreach ($feed_data as &$event) {
			// Let's replace all occurrences of this tag (that match the regex) in the content area
			$event['content'] = preg_replace($remove_iconlet, '', $event['content']);
		}
	}

	/**
	 * Private method to remove the share widget from the posts content
	 */
	private static function remove_share_widget(&$feed_data) {
		// Our icon removal regular expression
		$remove_iconlet = "/(<p class=(?:'|\")?akst_link(?:'|\")?>(?:.*?)<\/p>)/s";

		// Loop through each feed
		foreach ($feed_data as &$event) {
			// Let's replace all occurrences of this tag (that match the regex) in the content area
			$event['content'] = preg_replace($remove_iconlet, '', $event['content']);
		}
	}

	/**
	 * Private method to remove links from the posts content
	 */
	private static function remove_links(&$feed_data) {
		// Our icon removal regular expression
		$remove_iconlet = "/(<a (?:.*?)>(?:.*?)<\/a>)/s";

		// Loop through each feed
		foreach ($feed_data as &$event) {
			// Let's replace all occurrences of this tag (that match the regex) in the content area
			$event['content'] = preg_replace($remove_iconlet, '', $event['content']);
		}
	}

	/**
	 * Private method to clean the post's content by removing uneccessary tags/links/etc
	 */
	public static function clean_post_content($feed_data) {
		// Let's pass all cleanup operations by reference

		// Let's remove the date iconlet
		self::remove_date_iconlet($feed_data);

		// Let's remove the share widget
		self::remove_share_widget($feed_data);

		// Let's remove any links
		self::remove_links($feed_data);

		return $feed_data;
	}

	/**
	 * Method to parse the dates from each event and add it as a special value in the feed_array
	 */
	public static function parse_event_dates($feed_data) {
		// Let's define some regular expressions
		// This gets the date string from the feed description
		$date_from_description = "/(?:^\[ (.*?) \])/";

		// This gets a simple no-time date range (From to To). Example: [ May 8, 2012 to May 9, 2012. ]
		$simple_date_range = "/(?:^([\w]+ [\d]+, [\d]+)(?: to ([\w]+ [\d]+, [\d]+))\.)/";

		// Get only the first and last dates from an interval range. Example: [ April 12, 2012; 5:30 pm to 7:00 pm. April 19, 2012; 5:30 pm to 7:00 pm. April 26, 2012; 5:30 pm to 7:00 pm. ]
		$interval_dates = "/(?:^(.*?\.) (?:(?:.*?)\.)+ (.*?\.))/"; 

		// This gets a single date and a time range. Example: [ May 8, 2012; 11:30 am to 1:00 pm. ]
		$single_date_time_range = "/(?:^([\w]+ [\d]+, [\d]+); ([\w]+:[\w]+ (?:am|pm)) to ([\w]+:[\w]+ (?:am|pm))\.)/";

		// Loop through each feed
		foreach ($feed_data as &$event) {
			// Let's first add the new keys to the array (we want all the events to have the same keys)
			$event['date_start'] = "";
			$event['date_end'] = "";
			$event['time_start'] = "";
			$event['time_end'] = "";

			// Let's grab the date data out of the description
			preg_match($date_from_description, $event['description'], $matches, PREG_OFFSET_CAPTURE);

			// Let's get the date string from the matches
			$cleaned_date_string = $matches[1][0]; // Example: April 17, 2012 to May 19, 2012.

			// Let's remove the found date string from the description
			$event['description'] = preg_replace($date_from_description, '', $event['description']);

			// Ok, now that we have the date string, let's get the from and to dates and times
			// Let's first see if the date string is a simple date range
			if (preg_match($simple_date_range, $cleaned_date_string, $dates)) {
				// If it is, then we have easy mode. Let's just set the feeds properties
				$event['date_start'] = $dates[1];
				$event['date_end'] = $dates[2];
			}
			// Otherwise, let's see if the date string is an interval range (we only care about the first and last dates)
			elseif (preg_match($interval_dates, $cleaned_date_string, $date_range)) {
				// If it is, let's get the dates and times from this interval range
				preg_match($single_date_time_range, $date_range[1], $date_from);
				preg_match($single_date_time_range, $date_range[2], $date_to);

				// Now, let's set the feeds properties
				$event['date_start'] = $date_from[1];
				$event['date_end'] = $date_to[1];
				$event['time_start'] = $date_from[2];
				$event['time_end'] = $date_from[3];
			}
			// Otherwise, let's see if the date string is a date with a time range
			elseif (preg_match($single_date_time_range, $cleaned_date_string, $dates)) {
				// If it is, let's set the feeds properties
				$event['date_start'] = $dates[1];
				$event['time_start'] = $dates[2];
				$event['time_end'] = $dates[3];
			}
		}

		return $feed_data;
	}

} // End class Events 
