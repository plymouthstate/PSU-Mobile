<?php

require_once 'autoload.php';
PSU::session_start(); // force ssl + start a session

$GLOBALS['BASE_URL'] = '/webapp/psu-mobile';
$GLOBALS['BASE_DIR'] = __DIR__;

$GLOBALS['TITLE'] = 'PSU Mobile';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates/';

$GLOBALS['APP_VERSION'] = '0.4.1';
$GLOBALS['APP_BUILD_NAME'] = 'jqm-html5';
$GLOBALS['APP_BUILD_TYPE'] = 'beta';

// If the app is currently running on the development server
if (PSU::isdev()) {
	// Have the APP_BUILD_TYPE global reflect the current server/code status
	$GLOBALS['APP_BUILD_TYPE'] .= '-dev';

	// Set a global for easier access from templates
	$GLOBALS['IS_DEV'] = true;
}
else {
	// Have the APP_BUILD_TYPE global reflect the current server/code status
	$GLOBALS['APP_BUILD_TYPE'] .= '-prod';

	// Set a global for easier access from templates
	$GLOBALS['IS_DEV'] = false;
}

// Include my custom mobile smarty class
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileTemplate.class.php';

require_once 'klein/klein.php';

if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
	include $GLOBALS['BASE_DIR'] . '/debug.php';
}

// Register my directory into the autoloader
includes_psu_register( 'Mobile', $GLOBALS['BASE_DIR'] . '/includes' );


/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 */

// Make some objects available elsewhere
respond( function( $request, $response, $app ) {
	// Initialize the PSU smarty templating
	$app->tpl = new MobileTemplate;
});

// Generic request 
respond( '/', function( $request, $response, $app ) {
	// Grab a couple of the request parameters
	$response->session('phonegap', $request->param('phonegap'));
	$response->session('cordova', $request->param('cordova'));
	$response->session('client-app', $request->param('client-app'));

	// Remove the variables if they're null
	if (is_null($_SESSION['phonegap'])) {
		unset($_SESSION['phonegap']);
	}
	if (is_null($_SESSION['cordova'])) {
		unset($_SESSION['cordova']);
	}
	if (is_null($_SESSION['client-app-version'])) {
		unset($_SESSION['client-app-version']);
	}

	// Show the index on a generic request
	$app->tpl->display( '_wrapper.tpl' );
});

$app_routes = array(
	'newsfeed',
	'campusmap',
	'feedback',
	'clusters',
	'directory',
);

foreach( $app_routes as $base ) {
	with( "/{$base}", $GLOBALS['BASE_DIR'] . "/routes/{$base}.php" );
}//end foreach

dispatch( $_SERVER['PATH_INFO'] );
