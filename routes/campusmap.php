<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ){
	// Display the campus map template
	$app->tpl->assign( 'show_page', 'campusmap' );
	$app->tpl->display( '_wrapper.tpl' );
});
