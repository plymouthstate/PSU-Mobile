<?php

require_once 'autoload.php';
PSU::session_start(); // force ssl + start a session

$GLOBALS['BASE_URL'] = '/webapp/mobile';
$GLOBALS['BASE_DIR'] = __DIR__;

$GLOBALS['TITLE'] = 'PSU Mobile';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates/';


// Include my custom mobile smarty class
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileTemplate.class.php';

require_once $GLOBALS['BASE_DIR'] . '/API.php';
require_once 'klein/klein.php';

require_once $GLOBALS['BASE_DIR'] . '/includes/MobileAPI.class.php';

if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
	include $GLOBALS['BASE_DIR'] . '/debug.php';
}

// Build an autoloader for my custom Mobile classes
function mobile_autoloader($class_name) {
	// Only use this autoloader when the class name STARTS (position 0) with Mobile
	if ( stripos( $class_name, 'Mobile' ) === 0 ) {
		// Declare the include directory
		$inc_directory = $GLOBALS['BASE_DIR'] . '/includes/Mobile/';

		// Strip out the namespace in the class name argument
		if ( strpos( $class_name, '\\' ) !== false) {
			$class_name = substr( strrchr( $class_name, '\\' ), 1 );
		}

		$file = $inc_directory . $class_name . '.php';

		// Include (require_once) the class files
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
}

// Register that autoloader
spl_autoload_register('mobile_autoloader');


/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 */

// Make some objects available elsewhere
respond( function( $request, $response, $app ) {
	// Initialize the PSU smarty templating
	$app->tpl = new MobileTemplate;
});

// Klein catch-all (should be more developed later)
respond( '[*]', function( $request, $response, $app ) {
	// Put master response code here
});

// Generic request 
respond( '/', function( $request, $response, $app ) {
	// Show the index on a generic request
	$app->tpl->display( 'index.tpl' );
});

$app_routes = array(
	'newsfeed',
);

foreach( $app_routes as $base ) {
	with( "/{$base}", $GLOBALS['BASE_DIR'] . "/routes/{$base}.php" );
}//end foreach

dispatch( $_SERVER['PATH_INFO'] );
