// Bind events to be triggered BEFORE jQuery Mobile loads/executes
$(document).bind('mobileinit', function() {
	/*
	// Set jQuery mobile settings
	*/

	//$.mobile.addBackBtn = true;
	$.mobile.page.prototype.options.backBtnText = 'back';
	$.mobile.page.prototype.options.backBtnTheme = 'c';

	// Set the default page transition to "slide"
	$.mobile.defaultPageTransition = 'slide';
});
