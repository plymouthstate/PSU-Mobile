<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '[/?]', function( $request, $response, $app ){
	// Create an array to be used to load pre jquery javascript
	$pre_jq_js = array(
		'http://maps.google.com/maps/api/js?sensor=true',
	);
	
	// Create an array to be used to load post jquery mobile javascript
	$post_jqm_js = array(
		'/webapp/mobile/js/jquery.ui.map.full.min.js',
	);

	$app->tpl->assign( 'pre_jq_js', $pre_jq_js );
	$app->tpl->assign( 'post_jqm_js', $post_jqm_js );
	$app->tpl->display( 'campusmap.tpl' );
});
