// Bind events to be triggered BEFORE jQuery Mobile loads/executes
$(document).bind('mobileinit', function() {
	// Set jQuery mobile settings
	$.mobile.touchOverflowEnabled = true;
	$.mobile.addBackBtn = true;
});
