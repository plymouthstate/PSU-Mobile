// Things to happen RIGHT AWAY (as soon as this loads)

// Detect the device's OS
GlobalTools.deviceOS();

// Bind events to be triggered BEFORE EVERY page creation
$(document).on('pagebeforecreate', function() {
	// Function to find all jQuery Mobile back buttons and add an attribute to it
	function modifyBackButtons() {
		// Back buttons jQuery object
		var $backBtns = $('a[data-rel=back]');

		// Add attribute
		$backBtns.attr('data-direction', 'reverse');
	}

	// Functions to run immediately
	modifyBackButtons();
});

// Bind generic events to be triggered on EVERY page creation
$(document).on('pagecreate', function() {
	// Function to change the class of the HTML tag based on the orientation of the device
	function changeOrientationClass(orientation) {
		// Remove the old orientation classes
		$('html').removeClass('landscape').removeClass('portrait');

		// Add the orientation as a CSS class to the HTML tag
		$('html').addClass(orientation);
	}

	// Functions to run on orientation change
	$(window).on('orientationchange', function(event){
		changeOrientationClass(event.orientation);

		// Fix window height bugs by triggering an updatelayout and resize (repaint, please)
		$(window).trigger('resize');
		$(this).trigger('updatelayout');
	});

	// Function to find all jQuery Mobile back buttons and add an attribute to it
	function modifyBackButtons() {
		// Back buttons jQuery object
		var $backBtns = $('a[data-rel=back]');

		// Add HTML
		$backBtns.append('<span class="ui-icon ui-icon-arrow-l ui-icon-shadow"></span>');
	}

	// Functions to run immediately
	$(window).trigger('orientationchange');
	modifyBackButtons();
});

// Bind generic events to be triggered BEFORE EVERY page show
$(document).on('pagebeforeshow', function() {
	// Function to hide all the vertically centered divs, so they don't POP into place
	function hidePreModifiedDivs() {
		// Iterate over each div
		$('.vertically-centered').hide();
	}

	// Function to hide all of the phonegap/cordova required elements
	// We have to use JavaScript because of the way jQuery Mobile stylizes some of the elements
	function togglePhoneGapRequired() {
		// The device object may not be ready yet, so let's test to see if it exists
		if (typeof device == 'undefined') {
			$('.cordova-required').hide();
			$('.cordova-required').parents('.ui-btn').hide();
		}
		else if (typeof device.cordova == 'undefined' && typeof device.phonegap == 'undefined') {
			$('.cordova-required').hide();
			$('.cordova-required').parents('.ui-btn').hide();
		}
	}

	// Functions to run immediately
	hidePreModifiedDivs();
	togglePhoneGapRequired();
});

// Bind generic events to be triggered on EVERY page show
$(document).on('pageshow', function() {
	// Function to vertically center all divs marked with the "vertically-centered" class
	function verticallyCenterDivs() {
		// Grab the divs
		var $divs = $('.vertically-centered');

		// Iterate over each div
		$divs.each(function() {
			// Grab their height
			var divHeight = $(this).innerHeight();

			// Center them vertically
			$(this).css('top', '50%');
			$(this).css('margin-top', -(Math.floor(divHeight / 2)));
		});

		// Show all of them (un-hide them)
		$divs.fadeIn('slow');
	}

	// Functions to run immediately
	verticallyCenterDivs();
});

// Bind generic events to be triggered on EVERY m-app initialization
$(document).on('pageinit', '.m-app', function() {
	// Function to add both an html element and a click listener to all android headers
	function convertAndroidHeaders() {
		// Header jQuery object
		var $header = $("html.android h1#header-logo");

		// Grab the url of the hard-coded back button
		var backUrl = $('a[data-rel=back]').attr('href');

		// Add a class and an html span element
		$header.addClass('back-button');
		$header.prepend('<span class="back-image"></span>');

		// Make the header clickable
		$(document).on('vclick', $header.selector, function() {
			// Use jQuery Mobile's page change function to animate with transitions and load with Ajax, even if they weren't already there (that's why we're not using history.back)
			$.mobile.changePage(backUrl, {reverse: true});
		});
	}

	// Functions to run immediately
	convertAndroidHeaders();
});

// Bind generic events to be triggered on the DASHBOARD page initialization
$(document).on('pageinit', '#page-dashboard', function() {
	// Set variables for the dashboard
	var currentElemPerRow = '';
	
	// Detect and mark the "middle" elements of the dashboard
	function detectMiddleElements() {
		// Store the dashboard jQuery object
		var $dashboardNav = $('nav#dashboard');

		// Grab the width of the entire dashboard
		var dashWidth = parseInt($dashboardNav.width());

		// Grab the percentage width of the first element
		var elemWidth = parseInt($dashboardNav.find('ul#dashboard-mapps li').width());

		// Find the number of elements per row
		var elemPerRow = Math.floor(dashWidth / elemWidth);

		// Remove the current element per row class, so there aren't more than one class
		$dashboardNav.removeClass(currentElemPerRow + '-per-row');

		// Set the number of elements per row as a css class on the dashboard tag
		$dashboardNav.addClass(elemPerRow + '-per-row');
		currentElemPerRow = elemPerRow;

		// Calculate the middle-th element
		var middleCount = Math.ceil(elemPerRow / 2);

		// Create the nth-child expression
		var everyNthChild = elemPerRow + String('n+') + middleCount;
		console.log(elemPerRow);
		console.log(middleCount);
		console.log(everyNthChild);
		console.log(elemPerRow + 'n+' + middleCount);

		// Finally, set every middle-th element to have a class
		$dashboardNav.find('ul#dashboard-mapps li').removeClass('dash-middle-element');
		$dashboardNav.find('ul#dashboard-mapps li:nth-child(' + everyNthChild +')').addClass('dash-middle-element');
	}

	// Make the info button footer clickable
	$(document).on('vclick', '.info-button', function(event) {
		$('#hidden-info-div').toggleClass('open').stop().animate({ height: 'toggle', leaveTransforms: true, useTranslate3d: true}, 800, 'easeOutExpo', function() {
			// Fix window height bugs by triggering an updatelayout and resize (repaint, please)
			$(window).trigger('resize');
			$(this).trigger('updatelayout');
		});
		$('footer').animate({ opacity: 'toggle'}, 1200, 'easeInExpo', function() {
			// Do something on callback
		});
	});

	// Functions to run on orientation change
	$(window).on('orientationchange', function(event){
		detectMiddleElements();
	});

	// Functions to run immediately
	detectMiddleElements();
});


/*
 *
 * Campus Map m-app
 *
 */

// Bind events to be triggered on the CAMPUS MAP page initialization
$(document).on('pageinit', '#page-campusmap', function() {
	// We might not have the Google Maps API loaded yet, so let's try
	try {
		// Create a Google Map
		var startingCenterPoint = new google.maps.LatLng(43.758976, -71.688709);
		var zoomLevel = 15;
		var gmapObject = {'center': startingCenterPoint, 'zoom': zoomLevel};

		// Create the map
		$('div#campus-google-map').gmap( gmapObject );
	}
	catch (e) {
		console.log('Couldn\'t load the Google Map. Died with: ' + e);
	}
});
// Bind events to be triggered on the CAMPUS MAP page showing
$(document).on('pageshow', '#page-campusmap', function() {
	// Refresh/repaint
	$(window).trigger('resize');
	$(this).trigger('updatelayout');

	// We might not have the Google Maps API loaded yet, so let's try
	try {
		$('div#campus-google-map').gmap('refresh');
	}
	catch (e) {
		console.log('Couldn\'t load the Google Map. Died with: ' + e);
	}
});


/*
 *
 * Directory m-app
 *
 */

// On form submit
$(document).on('submit', '#page-directory form', function(event) {
	// Prevent the form from submitting normally
	event.preventDefault();

	// Get the data from the searh box and URL encode it
	var query = encodeURI($('#directory-search').val());

	// Make the request pretty
	$.mobile.changePage('search/' + query);
});

// When a result is clicked
$(document).on('vclick', '#page-directory-results #directory-results a', function(event) {
	// Prevent the form from submitting normally
	event.preventDefault();

	// Get the URL from the link
	var URL = $(this).attr('href');

	// Get the data from the hidden input
	var userData = $(this).find('input[name=user-details]').serialize();

	// Make the request pretty
	$.mobile.changePage( URL, {
		type: "post",
		data: userData
	});
});
