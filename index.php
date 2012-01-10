<?php

require_once 'autoload.php';
PSU::session_start(); // force ssl + start a session

$GLOBALS['BASE_URL'] = '/webapp/mobile/';
$GLOBALS['BASE_DIR'] = __DIR__;

$GLOBALS['TITLE'] = 'PSU Mobile';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates';

require_once $GLOBALS['BASE_DIR'] . '/API.php';
require_once 'klein/klein.php';

require_once $GLOBALS['BASE_DIR'] . '/includes/MobileAPI.class.php';

if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
	include $GLOBALS['BASE_DIR'] . '/debug.php';
}

/*/
IDMObject::authN();

if( ! IDMObject::authZ('permission', 'mis') ) {
	die('You do not have access to this application.');
}
//*/

/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 * Make some objects available elsewhere.
 */
respond( function( $request, $response, $app ) {
	// initialize the template
	$app->tpl = new PSUTemplate;

	// get the logged in user
	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 

	// assign user to template
	$app->tpl->assign( 'user', $app->user );
});
