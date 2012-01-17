// Plugin to jQuery
(function($) {
	/*
	// Create a universal animation function that optimizes for the browsers capabilities
	$.fn.optAnimate = function(props, speed, easing, callback) {
		// If modernizr reports that the browser supports CSS animations, and the animateWithCss function has correctly been loaded/defined
		if (Modernizr.cssanimations && typeof($.fn.animateWithCss) == 'function') {
			return $(this).animateWithCss(props, speed, easing, callback);
		}
		else {
			return $(this).animate(props, speed, easing, callback);
		}
	};
	*/

	// Get the device's OS and add it as a class to the HTML tag
	// To be used for OS-specific styling (trying to stay more true to the native styling)
	$.fn.deviceOS = function() {
		var deviceOS = '';

		// Get the data
		var devicePlatform = navigator.userAgent.match(/Android/i)
			|| navigator.userAgent.match(/iPod/i)
			|| navigator.userAgent.match(/iPad/i)
			|| navigator.userAgent.match(/iPhone/i)
			|| navigator.userAgent.match(/webOS/i)
			|| 'Other';

		if (devicePlatform == 'iPod' || devicePlatform == 'iPad' || devicePlatform == 'iPhone') {
			deviceOS = 'ios';
		}
		else if (devicePlatform == 'Android') {
			deviceOS = 'android';
		}
		else {
			deviceOS = devicePlatform.toLowerCase();
		}

		// Add the deviceOS as a CSS class to the HTML tag
		$('html').addClass(deviceOS);

		return deviceOS;
	};

})(jQuery);

// Bind generic events to be triggered on EVERY page initialization
$(document).live('pageinit', function() {
	// Function to change the class of the HTML tag based on the orientation of the device
	function changeOrientationClass(orientation) {
		// Add the orientation as a CSS class to the HTML tag
		$('html').addClass(orientation);
	}

	// Functions to run on orientation change
	$(window).bind('orientationchange', function(event){
		changeOrientationClass(event.orientation);
	});

	// Functions to run on page-load
	(function() {
		$(window).trigger('orientationchange');
		$().deviceOS();
	})();
});

// Bind generic events to be triggered on the DASHBOARD page initialization
$('#page-dashboard').live('pageinit', function() {
	// Detect and mark the "middle" elements of the dashboard
	function detectMiddleElements() {
		// Grab the width of the entire dashboard
		var dashWidth = parseInt($('nav#dashboard').width());

		// Grab the percentage width of the first element
		var elemWidth = parseInt($('nav#dashboard ul#dashboard-mapps li').width());

		// Find the number of elements per row
		var elemPerRow = Math.floor(dashWidth / elemWidth);

		// Set the number of elements per row as a css class on the dashboard tag
		$('nav#dashboard').addClass(elemPerRow + '-per-row');

		// Calculate the middle-th element
		var middleCount = Math.ceil(elemPerRow / 2);

		// Create the nth-child expression
		var everyNthChild = elemPerRow + String('n+') + middleCount;
		console.log(elemPerRow);
		console.log(middleCount);
		console.log(everyNthChild);
		console.log(elemPerRow + 'n+' + middleCount);

		// Finally, set every middle-th element to have a class
		$('nav#dashboard ul#dashboard-mapps li:nth-child(' + everyNthChild +')').addClass('dash-middle-element');
	}

	// Detect device and meta info and display it on the page
	function deviceInfo() {
		// Get the data
		var devicePlatform = $().deviceOS();
		var displayDensity = window.devicePixelRatio;

		// Display it by adding it to the mobile-info span
		$('#mobile-info').append('<li>Device Platform: ' + devicePlatform + '</li>');
		$('#mobile-info').append('<li>Display Density: ' + displayDensity + '</li>');

	}

	// Make the info button footer clickable
	$('.info-button').click(function() {
		$('#hidden-info-div').animate({ height: 'toggle', leaveTransforms: true, useTranslate3d: true}, 800, 'easeOutExpo', function() {
			// Fix window height bugs by triggering an updatelayout and resize (repaint, please)
			$(window).trigger('resize');
			$(this).trigger('updatelayout');
		});
		$('footer').animate({ opacity: 'toggle'}, 1200, 'easeInExpo', function() {
			// Do something on callback
		});
	});

	// Functions to run on orientation change
	$(window).bind('orientationchange', function(event){
		detectMiddleElements();
	});

	// Functions to run on page-load
	(function() {
		detectMiddleElements();
		deviceInfo();
	})();
});

// Bind events to be triggered on the CAMPUS MAP page initialization
$('#page-campusmap').live('pageinit', function() {
	// Create a Google Map
	var startingCenterPoint = new google.maps.LatLng(43.758976, -71.688709);
	var zoomLevel = 15;
	var gmapObject = {'center': startingCenterPoint, 'zoom': zoomLevel};

	// Create the map
	$('div#campus-google-map').gmap( gmapObject );
});
// Bind events to be triggered on the CAMPUS MAP page showing
$('#page-campusmap').live("pageshow", function() {
	// Refresh/repaint
	$(window).trigger('resize');
	$(this).trigger('updatelayout');
	$('div#campus-google-map').gmap('refresh');
});
