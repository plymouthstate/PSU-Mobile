<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Grab the news
	$feed_data = Mobile::events();
	//\PSU::dbug($feed_data);

	// Assign the feed_data array to the template
	$app->tpl->assign( 'feed_data', $feed_data );

	// Display the template
	$app->tpl->assign( 'show_page', 'events' );
	$app->tpl->display( '_wrapper.tpl' );
});

// Let's get the details of the event
respond( 'POST', '/details/[:timestamp]/?', function( $request, $response, $app ){
	// Get the event detail data from the request. That way we can save a round trip.
	$event_details = json_decode( stripslashes( $request->param( 'event-details' ) ) );

	// Assign the user_details object to the template
	$app->tpl->assign( 'event_data', $event_details );

	// Display the template
	$app->tpl->assign( 'show_page', 'event-details' );
	$app->tpl->display( '_wrapper.tpl' );
});
