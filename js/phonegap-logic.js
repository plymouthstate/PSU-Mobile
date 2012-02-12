// Let's listen for when PhoneGap has correctly loaded
// THEN we'll run our PhoneGap dependent code
document.addEventListener('deviceready', function () { // Don't use a jQuery event listener here. PhoneGap will shit itself.
	// Let the log know that PhoneGap is working! :)
	console.log('DEVICEREADY event fired. PhoneGap has been initialized');

	// Add the PhoneGap version to the info panel and show it
	var $infoPanel = $('.info-panel .app-frameworks');
	$infoPanel.find('#phonegap span').text(device.phonegap);
	$infoPanel.find('#phonegap').show(0);
});
