<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the feedback template
	$app->tpl->assign( 'show_page', 'feedback' );
	$app->tpl->display( '_wrapper.tpl' );
});

// Form submission handler
respond( 'POST', '/submit', function( $request, $response, $app ){
	// Do something with the posted form data
	$response = Mobile::feedback( $_POST );

	// Assign the response array to the template
	$app->tpl->assign( 'response', $response );

	// Display the template
	$app->tpl->assign( 'show_page', 'feedback-result' );
	$app->tpl->display( '_wrapper.tpl' );
});
