<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Grab the news
	$feed_data = Mobile::events();

	// Assign the feed_data array to the template
	$app->tpl->assign( 'feed_data', $feed_data );

	// Display the template
	$app->tpl->assign( 'show_page', 'events' );
	$app->tpl->display( '_wrapper.tpl' );
});
