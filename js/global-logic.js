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
})(jQuery);

// Bind events to be triggered BEFORE jQuery Mobile loads/executes
$(document).bind('mobileinit', function() {
	// Set jQuery mobile settings
	//$.mobile.touchOverflowEnabled = true;
});

// Bind events to be triggered on page initialization
$(document).bind('pageinit', function() {
	// Detect orientation change
	// Bind the event to the window
	$(window).bind('orientationchange', function(event){
		changeOrientation(event.orientation);
	});

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

	// Get the device's OS and add it as a class to the HTML tag
	// To be used for OS-specific styling (trying to stay more true to the native styling)
	function deviceOS() {
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
	}

	// Detect device and meta info and display it on the page
	function deviceInfo() {
		// Get the data
		var devicePlatform = deviceOS();
		var displayDensity = window.devicePixelRatio;

		// Display it by adding it to the mobile-info span
		$('#mobile-info').append('<li>Device Platform: ' + devicePlatform + '</li>');
		$('#mobile-info').append('<li>Display Density: ' + displayDensity + '</li>');

	}

	$('.info-button').click(function() {
		$('#hidden-info-div').animate({opacity: 'toggle', height: 'toggle', leaveTransforms: true, useTranslate3d: true}, 1000, 'easeOutExpo', function() {
			// Fix window height bugs by triggering an updatelayout and resize (repaint, please)
			$(window).trigger('resize');
			$(this).trigger('updatelayout');
		});
	});
	
	// Functions to run on orientation change
	function changeOrientation(orientation) {
		// Add the orientation as a CSS class to the HTML tag
		$('html').addClass(orientation);

		// Fire off some functions
		detectMiddleElements();
	}

	// Functions to run on page-load
	(function() {
		$(window).trigger('orientationchange');
		detectMiddleElements();
		deviceOS();
		deviceInfo();
	})();
});
