<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the template
	$app->tpl->assign( 'show_page', 'directory' );
	$app->tpl->display( '_wrapper.tpl' );
});

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/search/?', function( $request, $response, $app ){
	// Get the search parameter from the request
	$search_query = $request->param( 'query' );

	// Get the search results with the PSU REST API
	$search_results = (array) \PSU::api('backend')->get('directory/search/' . $search_query );

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
