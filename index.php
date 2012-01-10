<?php

require_once 'autoload.php';
PSU::session_start(); // force ssl + start a session

$GLOBALS['BASE_URL'] = '/webapp/mobile';
$GLOBALS['BASE_DIR'] = dirname(__FILE__);

$GLOBALS['TITLE'] = 'PSU Mobile';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates';

require_once 'Zend/Feed.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileController.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileController_search.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileAPI.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/MobileFeeds.class.php';
require_once 'PSUWordPress.php';

/*/
IDMObject::authN();

if( ! IDMObject::authZ('permission', 'mis') ) {
	die('You do not have access to this application.');
}
//*/

MobileController::delegate();
