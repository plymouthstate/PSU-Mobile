// Create the Global Tools object
var GlobalTools = {};

// Get the device's OS and add it as a class to the HTML tag
// To be used for OS-specific script loading
// To be used for OS-specific styling (trying to stay more true to the native styling)
GlobalTools.deviceOS = function () {
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
	document.documentElement.className += ' ' + deviceOS;

	return deviceOS;
};

// Create a wrapper function for console.log
GlobalTools.log = function () {
	// Disable this function if we're in production
	if (!isDev) {
		return false;
	}

	// Disable console.log on non-supporting browsers
     if (typeof console == "undefined") {
		return false;
     }

	// If all is well, let's use the browser's native console.log function
	console.log( Array.prototype.slice.call(arguments).toString() );
};

// Alias the GlobalTools.log function for quicker access
var psu = {};
psu.log = GlobalTools.log;
