<!doctype html>
<html class="no-js" lang="en">
<head> 
	<meta charset="utf-8">

     <title>{$title|default:"PSU Mobile"}</title> 

	<!-- Web App Info -->
	<meta name="app-version" content="{$PHP.APP_VERSION}">
	<meta name="app-build-name" content="{$PHP.APP_BUILD_NAME}">
	<meta name="app-build-type" content="{$PHP.APP_BUILD_TYPE}">
	<!-- Web App Info -->

	<!-- Mobile Meta and Graphic Tags -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$PHP.BASE_URL}/templates/images/xhigh/appicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$PHP.BASE_URL}/templates/images/high/appicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{$PHP.BASE_URL}/templates/images/medium/appicon.png">
	<link rel="apple-touch-icon-precomposed" href="{$PHP.BASE_URL}/templates/images/xhigh/appicon.png">
	<link rel="shortcut icon" href="{$PHP.BASE_URL}/templates/images/low/appicon.png">
	<!-- Mobile Meta and Graphic Tags -->

	<!-- jQuery Mobile Styles -->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css">
	<link rel="stylesheet" href="{$PHP.BASE_URL}/templates/psu-mobile-jqm-theme.min.css">
	<!-- jQuery Mobile Styles -->

	<!-- PSU Mobile/Custom (Must be in this order) -->
	<link rel="stylesheet" href="{$PHP.BASE_URL}/templates/style.css">
	<!-- PSU Mobile/Custom -->

	<!-- jQuery -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- jQuery -->

	<!-- jQuery Mobile Configuration -->
	<script type="text/javascript" src="{$PHP.BASE_URL}/js/jquery.mobile.config.js"></script>
	<!-- jQuery Mobile Configuration -->

	<!-- jQuery Mobile -->
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	<!-- jQuery Mobile -->

	<!-- Google Maps API -->
	<!-- Must be loaded in the HEAD, as it uses a document.write to load an external script -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<!-- Google Maps API -->

	<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">

</head> 
<body> 
