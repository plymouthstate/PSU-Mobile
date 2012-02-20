<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Get the available clusters with the PSU REST API
	$clusters = (array) \PSU::api('backend')->get('clusters');

	// Sort the returned clusters array
	/* This sort's the clusters array by this priority:
	 * Number of computer's free
	 * Building name
	 * Cluster name
	 */
     usort( $clusters, function( $a, $b ) {
		// If the number of computers free are the same
          if( $a->num_computers_free == $b->num_computers_free ) {
			// If the buildings are the same
               if( $a->building == $b->building ) {
				// If the cluster name is the same
                    if( $a->name == $b->name ) {
					// Return 0. They're equal
                         return 0;
				}
				else {
					// Return the name in alphabetical order
                         return ( $a->name < $b->name ) ? -1 : 1;
                    } //end else
			}
			else {
				// Return the name of the building in alphabetical order
                    return ( $a->building < $b->building ) ? -1 : 1;
               } //end else
          } else {
			// Return the number of computers free, descending from the highest
               return ( $a->num_computers_free > $b->num_computers_free ) ? -1 : 1;
          } //end else
     });

	// Assign the clusters array to the template
	$app->tpl->assign( 'clusters', $clusters );

	// Display the template
	$app->tpl->assign( 'show_page', 'clusters' );
	$app->tpl->display( '_wrapper.tpl' );
});

// Cluster detail view
respond( '/[i:id]', function( $request, $response, $app ){
	// Get the id from the request
	$request_id = $request->param('id');

	// Get the cluster details with the PSU REST API
	$cluster = (array) \PSU::api('backend')->get('clusters/' . $request_id );

	// Assign the clusters array to the template
	$app->tpl->assign( 'cluster', $cluster );

	// Display the template
	$app->tpl->assign( 'show_page', 'clusters-details' );
	$app->tpl->display( '_wrapper.tpl' );
});
