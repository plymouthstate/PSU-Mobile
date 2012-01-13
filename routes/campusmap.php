<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '[/?]', function( $request, $response, $app ){
	// Create an array to be used to load pre jquery javascript
	$pre_jq_js = array(
		'http://maps.google.com/maps/api/js?sensor=true',
	);

	$app->tpl->assign( 'pre_jq_js', $pre_jq_js );
	$app->tpl->display( 'campusmap.tpl' );
});
