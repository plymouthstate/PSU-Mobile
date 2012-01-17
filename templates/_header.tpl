<!DOCTYPE html>
<html> 
<head> 
     <title>{$title|default:"jQuery Mobile Test"}</title> 

     <!-- Mobile Meta and Graphic Tags -->
	<meta name="HandheldFriendly" content="True">
     <meta name="MobileOptimized" content="320">

     <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

     <meta name="apple-mobile-web-app-capable" content="yes" />
     <meta name="apple-mobile-web-app-status-bar-style" content="black">
     <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/webapp/mobile/templates/images/xhigh/appicon.png">
     <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/webapp/mobile/templates/images/high/appicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/webapp/mobile/templates/images/medium/appicon.png">
     <link rel="apple-touch-icon-precomposed" href="/webapp/mobile/templates/images/xhigh/appicon.png">
     <link rel="shortcut icon" href="/webapp/mobile/templates/images/low/appicon.png">
     <!-- Mobile Meta and Graphic Tags -->

	{if isset($pre_jq_js)}
		<!-- Pre jQuery Javascript from a specific template/page -->
		{foreach from=$pre_jq_js item="js"}
			<script type="text/javascript" src="{$js}"></script>
		{/foreach}
		<!-- Pre jQuery Javascript -->
	{/if}

	<!-- Google Maps API -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<!-- Google Maps API -->

     <!-- jQuery -->
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- jQuery -->

	{if isset($pre_jqm_js)}
		<!-- Pre jQuery Mobile Javascript from a specific template/page -->
		{foreach from=$pre_jqm_js item="js"}
			<script type="text/javascript" src="{$js}"></script>
		{/foreach}
		<!-- Pre jQuery Mobile Javascript -->
	{/if}

	<!-- jQuery Mobile Configuration -->
	<script type="text/javascript" src="/webapp/mobile/js/jquery.mobile.config.js"></script>
	<!-- jQuery Mobile Configuration -->

     <!-- jQuery Mobile -->
     <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
     <link rel="stylesheet" href="/webapp/mobile/templates/psu-mobile-jqm-theme.min.css" />
     <script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
     <!-- jQuery Mobile -->

     <!-- PSU Mobile/Custom -->
	<script type="text/javascript" src="/webapp/mobile/js/modernizr.custom.12420.js"></script>
	<script type="text/javascript" src="/webapp/mobile/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="/webapp/mobile/js/jquery.animate-enhanced.min.js"></script>
	<script type="text/javascript" src="/webapp/mobile/js/jquery.ui.map.full.min.js"></script>
     <script type="text/javascript" src="/webapp/mobile/js/global-logic.js"></script>
     <!-- PSU Mobile/Custom -->

	{if isset($post_jqm_js)}
		<!-- Post jQuery Mobile Javascript from a specific template/page -->
		{foreach from=$post_jqm_js item="js"}
			<script type="text/javascript" src="{$js}"></script>
		{/foreach}
		<!-- Post jQuery Mobile Javascript -->
	{/if}

	<!-- PSU Mobile/Custom (Must be in this order) -->
     <link rel="stylesheet" href="/webapp/mobile/templates/style.css" />
	<!-- PSU Mobile/Custom -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">

</head> 
<body> 
