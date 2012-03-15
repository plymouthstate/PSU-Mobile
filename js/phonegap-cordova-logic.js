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

		// TODO: Change the alerts to a better looking, more native PhoneGap alert/confirm
		// When the user clicks the button to add the directory user to their contacts
		$(document).on('vclick', '#add-to-contacts', function(event) {
			// Let's cache their name. We're going to be using it plenty
			var contactsName = $.trim($('#directory-details-name').text());

			// Let's define some success and error functions
			function saveSuccess(contact) {
				console.log('Contact "' + contactsName + '" saved');
				alert('Contact "' + contactsName + '" saved');
			}
			function saveError(contactError) {
				console.log('Contact save failed with error ' + contactError.code);
				alert('Uh oh! There was a problem saving the contact'); 
			}

			// Let's make sure that the user really wants to do this
			if (confirm('Add "' + contactsName + '" as a contact?')) {

				// Create a new contact object
				var newContact = navigator.contacts.create();

				// Set the new contacts details
				// Set both the displayName and nickname for maximum device compatibility
				newContact.displayName = contactsName;
				newContact.nickname = contactsName;

				newContact.emails = new Array(
					new ContactField('work', $.trim($('#directory-details-email').text()), false)
				);

				newContact.phoneNumbers = new Array(
					new ContactField('work', $.trim($('#directory-phone-office').text()), false),
					new ContactField('other', $.trim($('#directory-phone-voicemail').text()), false)
				);

				// Ok, we have the contact object and its properties. Now let's try and save it to the device
				console.log('Attempting to save contact "' + contactsName + '" to the device');
				newContact.save( saveSuccess, saveError );

			} // End confirmation

		});

	}); // End jQuery dependence
});
