<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '[/?]', function( $request, $response, $app ){
	// Grab the news
	$feed_json = Mobile::newsfeed();

	// Decode the JSON into a more PHP usable array
	$feed_data = json_decode( $feed_json );

	$app->tpl->assign( 'feed_data', $feed_data );
	$app->tpl->display( 'newsfeed.tpl' );
});
