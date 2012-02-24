<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the template
	$app->tpl->assign( 'show_page', 'directory' );
	$app->tpl->display( '_wrapper.tpl' );
});

// When someone searches
respond( '/search/[:what]/?', function( $request, $response, $app ){
	// Get the search parameter from the request
	$search_query = $request->param( 'what' );

	// Initialize the search results array, in case the API fails
	$search_results = array();

	// PSU::api uses Guzzle for its HTTP responses. We need to catch an exception, in case the call fails
	try {
		// Get the search results with the PSU REST API
		$search_results = (array) \PSU::api('backend')->get('directory/search/' . $search_query );
	}
	catch (Guzzle\Http\Message\BadResponseException $e) {
		// Lets grab the exception and put it into the session
		$_SESSION['errors'][] = $e->getMessage();

		// Let's get the response data so we can see the problem
		$response = $e->getResponse();

		// Let's grab the HTTP status and status code
		$response_data['status'] = $response->getReasonPhrase();
		$response_data['status_code'] = $response->getStatusCode();
	}

	// Do a little cleaning up
	foreach ( $search_results as &$result ) {
		// Iterate over each object property in the result
		foreach ( $result as $property_name => $property ) {
			// If the property's value is null, or it contains the word "unknown"
			if ( $property == null || stristr( $property, 'unknown' ) !== false ) {
				// Remove the property
				unset( $result->$property_name );
			}
		}
	}

	// Assign the search results array to the template
	$app->tpl->assign( 'results', $search_results );

	// Display the template
	$app->tpl->assign( 'show_page', 'directory-results' );
	$app->tpl->display( '_wrapper.tpl' );
});
