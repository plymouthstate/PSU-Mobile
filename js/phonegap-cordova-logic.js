// Let's listen for when PhoneGap/Cordova has correctly loaded
// THEN we'll run our PhoneGap/Cordova dependent code
document.addEventListener('deviceready', function () { // Don't use a jQuery event listener here. PhoneGap/Cordova will shit itself.
	if (typeof device.cordova != undefined) {
		// Let the log know that Cordova is working! :)
		console.log('DEVICEREADY event fired. Cordova has been initialized');

		// Add the Cordova version to the info panel and show it
		var $infoPanel = $('.info-panel .app-frameworks');
		$infoPanel.find('#cordova span').text(device.cordova);
		$infoPanel.find('#cordova').show(0);
	}
	else if (typeof device.phonegap != undefined) {
		// Let the log know that PhoneGap is working! :)
		console.log('DEVICEREADY event fired. PhoneGap has been initialized');

		// Add the PhoneGap version to the info panel and show it
		var $infoPanel = $('.info-panel .app-frameworks');
		$infoPanel.find('#phonegap span').text(device.phonegap);
		$infoPanel.find('#phonegap').show(0);
	}

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
			if ($('#hidden-info-div').is(':visible')) {
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
});
