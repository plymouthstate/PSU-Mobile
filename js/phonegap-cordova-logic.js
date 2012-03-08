// Let's listen for when PhoneGap/Cordova has correctly loaded
// THEN we'll run our PhoneGap/Cordova dependent code
document.addEventListener('deviceready', function () { // Don't use a jQuery event listener here. PhoneGap/Cordova will shit itself.
	// Setup some variables
	var nativeFramework = {};

	// Depending on which framework loaded the app, lets grab some info
	if (typeof device.cordova != 'undefined') {
		nativeFramework.name = 'Cordova';
		nativeFramework.version = device.cordova;
	}
	else if (typeof device.phonegap != 'undefined') {
		nativeFramework.name = 'PhoneGap';
		nativeFramework.version = device.phonegap;
	}

	// Let the log know that the framework is working! :)
	console.log('DEVICEREADY event fired. ' + nativeFramework.name + ' has been initialized');

	// Now that the framework has loaded, let's wait for jQuery to be ready so we can do some more elegant things. :)
	$(document).ready( function() {

		// Add the Framework version to the info panel and show it
		var $infoElement = $('.info-panel .app-frameworks #' + nativeFramework.name.toLowerCase() );
		$infoElement.find('span').text(nativeFramework.version);
		$infoElement.show(0).css('display', 'block !important');

		// When the Android back button is pressed
		// !NOTE!: This PERMANENTLY OVERRIDES the native back button functionality.
		$(document).on('backbutton', function () {
			console.log('Back button pressed.');

			// Grab the current page as a jQuery object
			var $currentPage = $.mobile.activePage;

			// If the current page is the dashboard
			if ($currentPage.attr('id') == 'page-dashboard') {
				console.log('Back button pressed on the dashboard');

				// If the hidden info div is visible, the dashboard info slider is open
				if ($('#hidden-info-div.open').is(':visible')) {
					console.log('Closing the hidden info slider');

					// Let the other event handlers do the work
					$('#footer-info-button').trigger('vclick');
				}
				// Its closed
				else {
					console.log('Closing the app');

					// Close the app
					navigator.app.exitApp();
				}
			}
			// If none of these match, we need to restore native functionality
			else {
				// Go back 
				window.history.back();
			}
		});

	}); // End jQuery dependence
});
