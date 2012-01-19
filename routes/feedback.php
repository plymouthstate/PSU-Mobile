<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the feedback template
	$app->tpl->display( 'feedback.tpl' );
});

// Form submission handler
respond( 'POST', '/submit', function( $request, $response, $app ){
	// Do something with the posted form data
	$response = Mobile::feedback( $_POST );

	// Display the template
	$app->tpl->assign( 'response', $response );
	$app->tpl->display( 'feedback-result.tpl' );
});
