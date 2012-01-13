<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '[/?]', function( $request, $response, $app ){
	// Grab the news
	Mobile::newsfeed();

	$app->tpl->display( 'newsfeed.tpl' );
});
