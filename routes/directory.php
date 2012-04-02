<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the template
	$app->tpl->assign( 'show_page', 'directory' );
	$app->tpl->display( '_wrapper.tpl' );
});

// When someone searches
respond( '/search/[:what]/?', function( $request, $response, $app ){
	// Get the search parameter from the request (url encode it... it may contain spaces, etc)
	$search_query = urlencode( $request->param( 'what' ) );

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

	/*
	 * Do a little cleaning up
	 */
	// Remove Title's labeled as "unknown"
	// Remove Department's labeled as "Student Distribution"
	foreach ( $search_results as &$result ) {
		// Iterate over each object property in the result
		foreach ( $result as $property_name => $property ) {
			// If the property's value is null, or it contains the word "unknown"
			if ( $property == null || stristr( $property, 'unknown' ) !== false || stristr( $property, 'Student Distribution' ) !== false ) {
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

// Let's get the details of the person
respond( 'POST', '/user/[:username]/?', function( $request, $response, $app ){
	// Get the user detail data from the request. That way we can save an API call.
	$user_details = json_decode( stripslashes( $request->param( 'user-details' ) ) );

	// Assign the user_details object to the template
	$app->tpl->assign( 'user_data', $user_details );

	// Display the template
	$app->tpl->assign( 'show_page', 'directory-details' );
	$app->tpl->display( '_wrapper.tpl' );
});
