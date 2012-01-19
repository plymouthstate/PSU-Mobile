<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Grab the news
	$feed_data = Mobile::newsfeed();

	$app->tpl->assign( 'feed_data', $feed_data );
	$app->tpl->display( 'newsfeed.tpl' );
});
